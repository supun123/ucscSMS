<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductRequestItem;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRequestController extends Controller
{
    private $log;
    /**
     * ProductRequestController constructor.
     */
    public function __construct()
    {
        $log = new LogService;
        $this->log = $log;
    }

    public function index(){
        if (!Auth::user()->canViewProductRequest()){
            return redirect('home');
        }
        $requests = ProductRequest::where('approved_at','!=',null)->get();
        return view('product.request.index',compact('requests'));
    }

    public function getRequestsForApprove(){
        if (!Auth::user()->canApproveProductRequest()){
            return redirect('home');
        }
        $requests = ProductRequest::where('divisional_head_id','=',Auth::user()->employee->id)->get();
        return view('product.request.approve',compact('requests'));
    }

    public function getRequestsForConfirm(){
        if (!Auth::user()->canConfirmProductRequest()){
            return redirect('home');
        }
        $requests = ProductRequest::where('approved_at','!=',null)->get();
        return view('product.request.confirm',compact('requests'));
    }

    public function create(){
        if (!Auth::user()->canCreateProductRequest()){
            return redirect('home');
        }
        $products = Product::all();
        return view('product.request.create',compact('products'));
    }

    public function generateNextProductRequestNumber(){
        if ($productRequest = ProductRequest::where('requested_at','like','%'.\Carbon\Carbon::now()->toDateString().'%')->orderBy('id','desc')->first()){
            $lastNumber = $productRequest->product_request_number;
            return ++$lastNumber;
        }else{
            $date = Carbon::now()->format('ymd');
            $productRequestNumber = 'RQ'.$date.'001';
            return $productRequestNumber;
        }
    }

    public function store(Request $request){
        if (!Auth::user()->canCreateProductRequest()){
            return redirect('home');
        }
        $this->validate($request,[
            'items'=>'required'
        ],[
            'items.required'=>'Please select at least one item.'
        ]);



        $productRequest = new ProductRequest;
        $productRequest->requested_by = Auth::user()->employee->id;
        $productRequest->requested_at = Carbon::now();
        $productRequest->divisional_head_id = Auth::user()->employee->division->head->id;
        $productRequest->requested_division_id = Auth::user()->employee->division->id;


        $productRequest->product_request_number = $this->generateNextProductRequestNumber();
        $productRequest->save();

        foreach ($request->items as $RItem => $values){
            $item = new ProductRequestItem;
            foreach ($values as $key => $val){
                if($key==='product_id'){
                    $item->product_id = $val;
                }
                if($key==='quantity'){
                    $item->quantity = $val;
                }
            }
            $item->product_request()->associate($productRequest);
            $item->save();
        }
//            Activity Log
        $this->log->log('Requested new products - Request number - '.$productRequest->product_request_number);
        return redirect()->back()->with(['success'=>'Product request sent successfully ! /n Your divisional head has to authorize this request.']);

    }

    public function approve(Request $request){
        $this->validate($request,[
            'request_id'=>'required'
        ]);

        if ($productRequest = ProductRequest::whereId($request->request_id)->first()){

            if ($request->deny){
                if (!Auth::user()->canApproveProductRequest()){
                    return redirect('home');
                }
                $productRequest->delete();

                //            Activity Log
                $this->log->log('Product request approval denied - Request number - '.$productRequest->product_request_number);

                return redirect()->back()->with(['success'=>'Product request denied successfully !']);
            }elseif ($request->approve){
                if (!Auth::user()->canApproveProductRequest()){
                    return redirect('home');
                }
                $productRequest->approved_at = Carbon::now();
                $productRequest->approved_by = Auth::user()->employee->id;
                $productRequest->update();
                //            Activity Log
                $this->log->log('Product request approved - Request number - '.$productRequest->product_request_number);

                return redirect()->back()->with(['success'=>'Product request approved successfully !']);
            }elseif ($request->deny_confirmation){
                if (!Auth::user()->canConfirmProductRequest()){
                    return redirect('home');
                }
                $productRequest->delete();
                //            Activity Log
                $this->log->log('Product request confirmation denied - Request number - '.$productRequest->product_request_number);

                return redirect()->back()->with(['success'=>'Product request confirmation denied successfully !']);

            }elseif ($request->confirm){
                if (!Auth::user()->canConfirmProductRequest()){
                    return redirect('home');
                }
                $productRequest->confirmed_at = Carbon::now();
                $productRequest->confirmed_by = Auth::user()->employee->id;
                $productRequest->update();
                //            Activity Log
                $this->log->log('Product request confirmed - Request number - '.$productRequest->product_request_number);

                return redirect()->back()->with(['success'=>'Product request confirmed successfully !']);
            }

        }


    }

}
