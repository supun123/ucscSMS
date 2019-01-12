<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockRequest;
use App\Models\StockRequestItem;
use App\Rules\Stock_req_no;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Exception\Exception;

class StockRequestController extends Controller
{
    private $log;
    /**
     * StockRequestController constructor.
     */
    public function __construct()
    {
        $log = new LogService;
        $this->log = $log;
    }

    public function create(){

        if (!Auth::user()->canCreateStockRequest()){
            return redirect('home');
        }

        $stockReqNumber = $this->generateNextStockRequestNumber();
        $products = Product::all();
        return view('stock.createRequest',compact('products' , 'stockReqNumber'));

    }

    public function generateNextStockRequestNumber(){
        if ($stockRequest = StockRequest::where('date','like','%'.\Carbon\Carbon::now()->toDateString().'%')->orderBy('id','desc')->first()){
            $lastNumber = $stockRequest->stock_request_number;
            return ++$lastNumber;
        }else{
            $date = Carbon::now()->format('ymd');
            $stockRequestNumber = 'SRN'.$date.'001';
            return $stockRequestNumber;
        }
    }
    public function store(Request $request){

        if (!Auth::user()->canCreateStockRequest()){
            return redirect('home');
        }

        $this->validate($request,[
            'stock_request_number'=>['required' , 'unique:stock_request' ,],
            'items'=>'required'
        ],[
            'items.required'=>'Please select at least one item.'
        ]);

        $stockRequest = new StockRequest;
        $stockRequest->stock_request_number = $this->generateNextStockRequestNumber();
        $stockRequest->date = Carbon::now();
        $stockRequest->requested_by = Auth::user()->employee->id;
        $stockRequest->save();

        foreach ($request->items as $RItem => $values){
            $item = new StockRequestItem;
            foreach ($values as $key => $val){
                if($key==='product_id'){
                    $item->product_id = $val;
                }
                if($key==='quantity'){
                    $item->quantity = $val;
                }
            }
            $item->stock_request()->associate($stockRequest);
            $item->save();
        }

//            Activity Log
        $this->log->log('Stock request added - stock request number - '.$stockRequest->stock_request_number);

        return redirect()->back()->with(['success'=>'Stock request sent successfully !']);
    }

    public function requests(){

        if (Auth::user()->canViewStockRequest()||Auth::user()->canDownloadStockRequest()){
            $requests = StockRequest::notApproved()->get();
            $approvedRequests = StockRequest::approved()->get();
            return view('stock.requests',compact('requests','approvedRequests'));
        }
        return redirect('home');
    }

    public function approve(Request $request){

        if (!Auth::user()->canApproveStockRequest()){
            return redirect('home');
        }

        $this->validate($request,[
            'request_id'=>'required'
        ]);

        if ($request->deny && $stockRequest = StockRequest::whereId($request->request_id)->first()){
            $stockRequest->delete();

//            Activity Log
            $this->log->log('Stock request denied - stock request number - '.$stockRequest->stock_request_number);

            return redirect()->back()->with(['success'=>'Stock request denied successfully !']);
        }

        if($stockRequest = StockRequest::whereId($request->request_id)->first()){

            $stockRequest->items()->delete();

            foreach ($request->items as $RItem => $values){
                $item = new StockRequestItem;
                foreach ($values as $key => $val){
                    if($key==='product_id'){
                        $item->product_id = $val;
                    }
                    if($key==='quantity'){
                        $item->quantity = $val;
                    }
                }
                $item->stock_request()->associate($stockRequest);
                $item->save();
            }

            $stockRequest->approved_at = Carbon::now();
            $stockRequest->approved_by = Auth::user()->employee->id;
            $stockRequest->update();

//            Activity Log
            $this->log->log('Stock request added - stock request approved - '.$stockRequest->stock_request_number);

            return redirect()->back()->with(['success'=>'Stock request approved successfully !']);
        }
    }

    public function downloadStockRequest($id){

        if (!Auth::user()->canDownloadStockRequest()&&!Auth::user()->canViewStockRequest()){
            return redirect('home');
        }

        if ($request = StockRequest::whereId($id)->first()){

            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $phpWord->addTitleStyle(1, array('name'=>'HelveticaNeueLT Std Med', 'size'=>16));
            $section = $phpWord->addSection();
            $section->addTitle(
                'Request Number - '.$request->stock_request_number
            );
            $section->addTitle(
                'Request Date - '.$request->date->toDayDateTimeString()
            );
            $tableStyle = array(
                'borderColor' => '#006699',
                'borderSize'  => 6,
                'cellMargin'  => 50
            );
            $firstRowStyle = array('bgColor' => '#66BBFF');

            $table = $section->addTable($tableStyle);
            $table->addRow(100, $firstRowStyle);
            $cell = $table->addCell()->addText('Product Code');
            $cell = $table->addCell()->addText('Product Name');
            $cell = $table->addCell()->addText('Category');
            $cell = $table->addCell()->addText('Subcategory');
            $cell = $table->addCell()->addText('Quantity');

            foreach ($request->items as $item){
                $table->addRow(100, $firstRowStyle);
                $cell = $table->addCell()->addText($item->product->code);
                $cell = $table->addCell()->addText($item->product->name);
                $cell = $table->addCell()->addText($item->product->subCategory->category->name);
                $cell = $table->addCell()->addText($item->product->subCategory->name);
                $cell = $table->addCell()->addText($item->quantity);
            }

            $requestNumber = $request->stock_request_number;
            try {

//            Activity Log
                $this->log->log('Stock request downloaded - stock request number - '.$requestNumber);

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save(storage_path('temp/'.$requestNumber.'.docx'));
                return response()->download(storage_path('temp/'.$requestNumber.'.docx'));
            } catch (Exception $e) {
            }
        }

    }
}
