<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    public function index(){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            $productCategorys = ProductCategory::all();
            return view('admin.productCategory.index',compact('productCategorys'));
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }

    public function store(Request $request){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            $this->validate($request,[
                'name'=>'required|unique:product_category'
            ]);

            $productCategory = new ProductCategory;
            $productCategory->name = $request->name;
            $productCategory->save();

            return redirect()->back()->with(['success'=>'New productCategory added successfully !']);
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }

    public function edit($id){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            if ($productCategory = ProductCategory::whereId($id)->first()){
                $productCategorys = ProductCategory::all();
                return view('admin.productCategory.edit',compact('productCategorys','productCategory'));
            }
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }

    public function update(Request $request,$id){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            $this->validate($request,[
                'name'=>'required'
            ]);

            if ($productCategory = ProductCategory::whereId($id)->first()){
                $productCategory->name = $request->name;
                $productCategory->save();

                return redirect()->back()->with(['success'=>'ProductCategory updated successfully !']);
            }
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }
}
