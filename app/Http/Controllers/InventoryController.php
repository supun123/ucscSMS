<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(){

        if (!Auth::user()->canViewInventory()){
            return redirect('home');
        }

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

        return view('inventory.index',compact('products'));
    }
}
