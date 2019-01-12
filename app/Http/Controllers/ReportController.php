<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductIssue;
use App\Models\ProductIssueItem;
use App\Models\ProductRequestItem;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getDepartmentBill(){
        $divisions = Division::all()->pluck('name','id');
        return view('reports.departmentBillForm',compact('divisions'));
    }

    public function Chart()
    {
        return view('reports.productIssuedRecieved');
    }

    public function generateDepartmentBill(Request $request){
        $this->validate($request,[
            'division_id'=>'required',
//            'date_range'=>'required'
        ]);
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if ($department = Division::whereId($request->division_id)->first()){
            $completedProducts = $department->completedProductRequests;
            return view('reports.departmentBill',compact('completedProducts','department','startDate','endDate'));
        }
    }

    public function productWiseReceivedIssued(){
        $products = Product::all();
        $pro = (object) array(
        );
        $counter = 0;
        foreach ($products as $product){
            $counter++;
            $requested = 0;
            $issued = 0;
          $requestedItems =  ProductRequestItem::where('product_id','=',$product->id)->get();
          foreach ($requestedItems as $requestedItem){
              $requested+=$requestedItem->quantity;

              foreach ($requestedItem->product_issue_items as $issue_item){
                  $issued+=$issue_item->quantity;
              }
          }
          $inventorys = Inventory::where('product_id','=',$product->id)->get();
            $productQuantity = 0;
            foreach ($inventorys as $inventory){
                $inventoryItemQuantity = $inventory->quantity;
                $productQuantity+=$inventoryItemQuantity;
            }
            $pro->$counter = (object) array(
                "name" => $product->name,
                "quantity"=> $requested,
                "issued"=> $issued,
                "inventory"=>$productQuantity,
            );
        }
        return json_encode($pro);
    }
}
