<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
use App\Models\ProductSubCategory;
use App\Models\ProductType;
use App\Rules\Asset_code;
use App\Rules\Barcode;
use App\Rules\Product_no;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $log;
    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $log = new LogService;
        $this->log = $log;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->canViewProduct()){
            return redirect('home');
        }

        $products = Product::all();
        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->canCreateProduct()){
            return redirect('home');
        }

        $categories = ProductCategory::all()->pluck('name','id');
        $subCategories = ProductSubCategory::all()->pluck('name','id');
        $types = ProductType::all()->pluck('name','id');
        $status = ProductStatus::all()->pluck('name','id');
        return view('product.create',compact('products','categories','types','subCategories','status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canCreateProduct()){
            return redirect('home');
        }

        $this->validate($request,[
            'name'=>'required',
            'code'=>['required', new Product_no()],
            'asset_code'=>['nullable', new Asset_code()],
            'barcode'=>['required', new Barcode()],
            'description'=>'nullable',
            'product_category_id'=>'required',
            'product_sub_category_id'=>'required',
            'product_status_id'=>'required',
            'product_type_id'=>'required',
            'image'=>'required',
            'reorder_level'=>'required|numeric',
            'critical_reorder_level'=>'required|numeric',
        ], [

            'product_category_id.required'=>'Category is required.',
            'product_sub_category_id.required'=>'Subcategory is required.',
            'product_status_id.required'=>'Product Status is required.',
            'product_type_id.required'=>'Product type is required.'
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->code = $request->code;
        $product->asset_code = $request->asset_code;
        $product->barcode = $request->barcode;
        $product->description = $request->description;
        $product->product_sub_category_id = $request->product_sub_category_id;
        $product->product_status_id = $request->product_status_id;
        $product->product_type_id= $request->product_type_id;
        if ($request->product_type_id != 2){
            $product->asset_code = null;
        }
        $product->reorder_level= $request->reorder_level;
        $product->critical_reorder_level= $request->critical_reorder_level;

        if ($request->hasFile('image')) {

            $photo = $request->file('image');
            $extension =  '.'.$photo->getClientOriginalExtension();
            $oName = $photo->getClientOriginalName();
            $name = $product->code.$extension;

            $path =  $photo->move('img/products',$name);

            $product->image_url = $path;

        }

        $product ->save();

//            Activity Log
        $this->log->log('Product Created - Product Code - '.$product->code);

        return redirect()->back()->with(['success'=>'New Product added successfully !']);
    }

    public function getSubcategoryByCategoryId($id){

        if (!Auth::user()->canViewProduct()&&!Auth::user()->canEditProduct()&&!Auth::user()->canCreateProduct()){
            return response('No Permissions','400');
        }

        if ($category = ProductCategory::whereId($id)->first()){
            return $category->product_sub_categories;
        }
    }

    public function getCategoryBySubcategoryId($id){

        if (!Auth::user()->canViewProduct()&&!Auth::user()->canEditProduct()&&!Auth::user()->canCreateProduct()){
            return response('No Permissions','400');
        }

        if($subCategory = ProductSubCategory::whereId($id)->first()){

            return $subCategory->category;
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->canEditProduct()){
            return redirect('home');
        }

        if ($product = Product::whereId($id)->first()){

            $categories = ProductCategory::all()->pluck('name','id');
            $subCategories = ProductSubCategory::all()->pluck('name','id');
            $types = ProductType::all()->pluck('name','id');
            $status = ProductStatus::all()->pluck('name','id');

            return view('product.edit',compact(
                'product',
                'subCategories',
                    'types',
                    'categories',
                    'types',
                    'status'
            ));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->canEditProduct()){
            return redirect('home');
        }

        if ($product = Product::whereId($id)->first()){

            $this->validate($request,[
                'name'=>'required',
                'code'=>['required', new Product_no()],
                'asset_code'=>['nullable', new Asset_code()],
                'barcode'=>['nullable', new Barcode()],
                'description'=>'required',
                'product_category_id'=>'required',
                'product_sub_category_id'=>'required',
                'product_status_id'=>'required',
                'product_type_id'=>'required',
                'image'=>'nullable',
                'reorder_level'=>'required|numeric',
                'critical_reorder_level'=>'required|numeric'
            ], [
                'product_category_id.required'=>'Category is required.',
                'product_sub_category_id.required'=>'Subcategory is required.',
                'product_status_id.required'=>'Product Status is required.',
                'product_type_id.required'=>'Product type is required.'
            ]);

            $product->name = $request->name;
            $product->code = $request->code;
            $product->asset_code = $request->asset_code;
            $product->barcode = $request->barcode;
            $product->description = $request->description;
            $product->product_sub_category_id = $request->product_sub_category_id;
            $product->product_status_id = $request->product_status_id;
            $product->product_type_id= $request->product_type_id;
            if ($request->product_type_id != 2){
                $product->asset_code = null;
            }
            $product->reorder_level= $request->reorder_level;
            $product->critical_reorder_level= $request->critical_reorder_level;

            if ($request->hasFile('image')) {

                $photo = $request->file('image');
                $extension =  '.'.$photo->getClientOriginalExtension();
                $oName = $photo->getClientOriginalName();
                $name = $product->code.$extension;

                $path =  $photo->move('img/products',$name);

                $product->image_url = $path;

            }

            $product ->update();

//            Activity Log
            $this->log->log('Product Updated - Product Code - '.$product->code);

            return redirect()->back()->with(['success'=>'Product details updated successfully!']);
        }
    }
}
