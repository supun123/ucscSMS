<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersCount = count(User::where('deleted_at','=',null)->get());
        $productCount = count(Product::where('product_status_id','=',1)->get());
        $employeeCount = count(Employee::where('deleted_at','=',null)->get());
        $supplierCount = count(Supplier::where('is_active','=',1)->get());

        $inventorys = Inventory::distinct()->select('product_id')->get();
        $products = [];
        foreach ($inventorys as $index => $value){
            $inventoryItems = Inventory::where('product_id','=',$value->product_id)->with('product','stock')->get();
            $quantity = 0;
            foreach ($inventoryItems as $inventoryItem){
                $quantity += $inventoryItem->quantity;
            }
            $inventoryItem = $inventoryItems->first();
            $inventoryItem->quantity = $quantity;

            array_push($products,$inventoryItem);
        }
        return view('home',compact('usersCount' ,'productCount' , 'employeeCount' , 'supplierCount' ,'products'));
    }
}
