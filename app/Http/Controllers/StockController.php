<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\StockRequest;
use App\Models\StockRequestItem;
use App\Models\Supplier;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    private $log;
    /**
     * StockController constructor.
     */
    public function __construct()
    {
        $log = new LogService;
        $this->log = $log;
    }

    public function index(){
        if (!Auth::user()->canViewStock()){
            return redirect('home');
        }
        $stocks = Stock::all();
        return view('stock.index',compact('stocks'));
    }

    public function getStockRequests(){

        if (!Auth::user()->canCreateStock()){
            return redirect('home');
        }

        $requests = StockRequest::notCompleted()->get();
        return view('stock.selectRequests',compact('requests'));
    }

    public function create($stockRequestId){

        if (!Auth::user()->canCreateStock()){
            return redirect('home');
        }

        if ($stockRequest = StockRequest::whereId($stockRequestId)->with('items')->first()){
            if (!$stockRequest->completed_at){
                $suppliers = Supplier::where('is_active','=',1)->pluck('company_name','id');
                return view('stock.create',compact('stockRequest','suppliers'));
            }
            return redirect()->back()->withErrors('The request you selected is already completed !');
        }
    }

    public function store(Request $request){

        if (!Auth::user()->canCreateStock()){
            return redirect('home');
        }

        $this->validate($request,[
            'stock_request_number'=>'required',
            'invoice_number'=>'required',
            'stock_number'=>'required',
            'date'=>'required|date',
            'items'=>'required',
            'supplier_id'=>'required'
        ]);


        if ($stockRequest = StockRequest::where('stock_request_number','=',$request->stock_request_number)->first()){

            $stock = new Stock;
            $stock->date = Carbon::parse($request->date);
            $stock->supplier_id = $request->supplier_id;
            $stock->invoice_number = $request->invoice_number;
            $stock->stock_number = $request->stock_number;
            $stock->stock_request_id = $stockRequest->id;
            $stock->created_by = Auth::user()->employee->id;
            $stock->save();

            foreach ($request->items as $RItem => $values){
                $stockRequestItemId = 0;
                $stockRequestItemQuantity = 0;
                $item = new StockItem;
                $item->stock_id = $stock->id;

                foreach ($values as $key => $val){
                    if($key==='quantity'){
                        $item->quantity = $val;
                        $stockRequestItemQuantity = $val;
                    }
                    if($key==='stock_request_items_id'){
                        $item->stock_request_items_id = $val;
                        $stockRequestItemId = $val;
                    }
                    if($key==='unit_price'){
                        $item->unit_price = $val;
                    }
                    if($key==='tax'){
                        $item->tax = $val;
                    }
                }

                $item->stock()->associate($stock);
                $item->save();

                if ($stockRequestItem = StockRequestItem::whereId($stockRequestItemId)->first()){
                    $receivedQuantity =  $stockRequestItem->received_quantity;
                    $stockRequestItem->received_quantity = $receivedQuantity+$stockRequestItemQuantity;
                    $stockRequestItem->last_recieved_date = Carbon::parse($request->date);
                    $stockRequestItem->update();

                    if($stockRequestItemQuantity>0){
                        $inventory = new Inventory;
                        $inventory->stock_id = $stock->id;
                        $inventory->product_id = $stockRequestItem->product_id;
                        $inventory->quantity = $stockRequestItemQuantity;
                        $inventory->save();
                    }
                }

                $stockRequest->updated_at = Carbon::now();
                $stockRequest->update();

            }

            $this->completeStockRequest($stockRequest);

//            Activity Log
            $this->log->log('New stock added - Stock number - '.$stock->stock_number);

            return redirect('/stock/create')->with(['success'=>'Stock added successfully !']);
        }

        return redirect()->back()->withErrors(['request'=>'Stock request not found']);
    }

    public function completeStockRequest(StockRequest $stockRequest){
        $completed = true;
        foreach ($stockRequest->items as $item){
            if ($item->quantity !== $item->received_quantity){
                $completed = false;
            }
        }
        if ($completed){
            $stockRequest->completed_at = Carbon::now();
            $stockRequest->update();
        }
    }

}
