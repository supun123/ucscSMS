<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSubCategoryController extends Controller
{
    public function index(){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            $productCategorys = ProductCategory::all()->pluck('name','id');
            $productSubCategorys = ProductSubCategory::all();
            return view('admin.productSubCategory.index',compact('productSubCategorys','productCategorys'));
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }

    public function store(Request $request){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            $this->validate($request,[
                'name'=>'required',
                'product_category_id'=>'required'
            ]);

            $productSubCategory = new ProductSubCategory;
            $productSubCategory->name = $request->name;
            $productSubCategory->product_category_id = $request->product_category_id;
            $productSubCategory->save();

            return redirect()->back()->with(['success'=>'New product Subcategory added successfully !']);
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }

    public function edit($id){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            if ($productSubCategory = ProductSubCategory::whereId($id)->first()){
                $productCategorys = ProductCategory::all()->pluck('name','id');
                $productSubCategorys = ProductSubCategory::all();
                return view('admin.productSubCategory.edit',compact('productSubCategorys','productCategorys','productSubCategory'));
            }
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }

    public function update(Request $request,$id){
        if (Auth::user()->canEditProduct() || Auth::user()->canCreateProduct()){
            $this->validate($request,[
                'name'=>'required',
                'product_category_id'=>'required'
            ]);

            if ($productSubCategory = ProductSubCategory::whereId($id)->first()){
                $productSubCategory->name = $request->name;
                $productSubCategory->product_category_id = $request->product_category_id;
                $productSubCategory->save();

                return redirect()->back()->with(['success'=>'Product Subcategory updated successfully !']);
            }
        }
        return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
    }
}
