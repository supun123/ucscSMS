<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ProductIssue;
use App\Models\ProductIssueItem;
use App\Models\ProductIssueItemsStock;
use App\Models\ProductRequest;
use App\Models\ProductRequestItem;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductIssueController extends Controller
{
    private $log;
    /**
     * ProductIssueController constructor.
     */
    public function __construct()
    {
        $log = new LogService;
        $this->log = $log;
    }

    public function select(){

        if (!Auth::user()->canIssueProducts()){
            return redirect('home');
        }

        $requests = ProductRequest::where('confirmed_at','!=',null)->where('completed_at','=',null)->get();
        return view('product.issue.select',compact('requests'));
    }

    public function create($id){

        if (!Auth::user()->canIssueProducts()){
            return redirect('home');
        }

        if ($request = ProductRequest::whereId($id)->where('completed_at','=',null)->first()){
            return view('product.issue.create',compact('request'));
        }
        return redirect('/product/issue/select');
    }

    public function store(Request $request){

        if (!Auth::user()->canIssueProducts()){
            return redirect('home');
        }

        $this->validate($request,[
            'request_id'=>'required',
            'items'=>'required'
        ]);

        if ($productRequest = ProductRequest::whereId($request->request_id)->first()){
            $isIssued = false;
            $quantityError = false;
            foreach ($request->items as $RItem => $values){
                $receivedQuantity = 0;
                $requestedItemId = 0;
                $requestedProductId = 0;
                foreach ($values as $key => $val){
                    if($key==='quantity'){
                        $receivedQuantity = $val;
                    }
                    if($key==='product_request_items_id'){
                        $requestedItemId = $val;
                    }
                    if($key==='product_id'){
                        $requestedProductId = $val;
                    }
                }

                if($receivedQuantity<=0){
                    $quantityError = true;
                    continue;
                }

                if (!$this->checkStores($receivedQuantity,$requestedProductId)){
                    return redirect()->back()->withErrors(['error'=>'Stores cannot provide requested quantity !']);
                }

                $productIssue = new ProductIssue;
                $productIssue->issued_by = Auth::user()->employee->id;
                $productIssue->issued_at = Carbon::parse(Carbon::now());;
                $productIssue->product_request_id = $productRequest->id;
                $productIssue->save();

                echo "requestedQuantity - ".$receivedQuantity."<br> requestedItemId - ".$requestedItemId."<br> requestedProductId - ".$requestedProductId;

                $inventoryItems = Inventory::where('product_id','=',$requestedProductId)->where('quantity','>',0)->orderBy('id','desc')->get();
                $storesQuantity = 0;
                foreach ($inventoryItems as $inventoryItem){
                    $storesQuantity += $inventoryItem->quantity;
                }

                echo "<br> storesQuantity - ".$storesQuantity;

                $PriceTax = $this->updateStores($receivedQuantity,$requestedProductId);
                if ($requestedItem = ProductRequestItem::whereId($requestedItemId)->first()){
                    $requestedItem->received_quantity += $receivedQuantity;
                    $requestedItem->last_received_date = Carbon::parse(Carbon::now());
                    $requestedItem->save();
                }

                $productIssueItem = new ProductIssueItem;
                $productIssueItem->product_issue_id = $productIssue->id;
                $productIssueItem->product_request_items_id = $requestedItemId;
                $productIssueItem->quantity = $receivedQuantity;
                $productIssueItem->price = $PriceTax->price;
                $productIssueItem->tax = $PriceTax->tax;
                $productIssueItem->save();

                $isIssued = true;
            }
            $this->completeProductRequest($productRequest);
            if ($isIssued){

//            Activity Log
                $this->log->log('Products Issued - request ID - '.$productRequest->id);

                return redirect()->back()->with(['success'=>'Products Issued Successfully!']);
            }elseif (!$isIssued && $quantityError){
                return redirect()->back()->withErrors(['error'=>'Please enter at least one quantity !']);
            }
        }

//        return redirect()->back()->withErrors(['error'=>'Product request not found !']);
    }

    public function completeProductRequest(ProductRequest $productRequest){
        $completed = true;
        foreach ($productRequest->items as $item){
            if ($item->quantity != $item->received_quantity){
                $completed = false;
            }
        }
        if ($completed){
            $productRequest->completed_at = Carbon::now();
            $productRequest->save();
        }
    }

    public function updateStores($quantity,$productId){

        $stockItems = Inventory::where('product_id','=',$productId)->where('quantity','>',0)->orderBy('id','desc')->get();
        $balance = $quantity;
        $totalPrice = 0;
        $totalTax = 0;
        foreach ($stockItems as $stockItem){
            if ($quantity > 0){
                if ($stockItem->quantity > $balance){
                    $item = Inventory::whereId($stockItem->id)->first();
                    $oldQuantity = $item->quantity;
                    $item->quantity = $oldQuantity-$quantity;
                    $item->save();
                    $totalPrice = $item->unitPrice() * $quantity;
                    $totalTax = $item->tax() * $quantity;
                    $quantity = 0;
                }elseif ($stockItem->quantity = $balance){
                    $item = Inventory::whereId($stockItem->id)->first();
                    $item->quantity = 0;
                    $item->save();
                    $totalPrice = $item->unitPrice() * $quantity;
                    $totalTax = $item->tax() * $quantity;
                    $quantity = 0;
                }elseif ($stockItem->quantity < $balance){
                    $item = Inventory::whereId($stockItem->id)->first();
                    $item->quantity = 0;
                    $item->save();
                    $totalPrice += $item->unitPrice() * $quantity;
                    $totalTax += $item->tax() * $quantity;
                    $oldQuantity = $quantity;
                    $quantity = $oldQuantity-$item->quantity;
                }
            }
        }

        $myObj = (object) array(
            'price'=>$totalPrice,
            'tax'=>$totalTax
        );

        return $myObj;
    }

    public function checkStores($quantity,$productId){
        if ($quantity>0){
            $stockItems = Inventory::where('product_id','=',$productId)->where('quantity','>',0)->orderBy('id','desc')->get();

            $storesQuantity = 0;
            foreach ($stockItems as $stockItem){
                $storesQuantity += $stockItem->quantity;
            }

            return $storesQuantity>=$quantity;
        }
    }
}
