<?php

namespace App\Http\Controllers;

use App\Models\NatureOfBusiness;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierType;
use App\Rules\Business_no;
use App\Rules\doc_no;
use App\Rules\Fax_no;
use App\Rules\Name;
use App\Rules\Phone;
use App\Rules\Vat_no;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    private $log;
    /**
     * SupplierController constructor.
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
        if (!Auth::user()->canViewSupplier()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $suppliers = Supplier::all();
        return view('supplier.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->canCreateSupplier()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $nature_of_business = NatureOfBusiness::all()->pluck('name','id');
        $products = Product::all()->pluck('name','id');
        return view('supplier.create',compact('products' , 'nature_of_business'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canCreateSupplier()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $this->validate($request,[
            'doc_no'=>['required', new Doc_no()],
            'reciept_no'=>'required',
            'company_name'=>'required',
            'phone_1'=>['required', new Phone()],
            'phone_2'=>'nullable',
            'fax_1'=>['required', new Fax_no()],
            'fax_2'=>'nullable',
            'email'=>'required|email',
            'business_reg_no'=>['required', new Business_no()],
            'business_reg_date'=>'required|before_or_equal:'.Carbon::now(),
            'vat_no'=>['required', new Vat_no()],
            'nature_of_business_id'=>'required',
            'contact_person'=>'nullable',
            'remark'=>'max:500',
            'is_active'=>'required|integer'
        ], [
            'doc_no.required'=>'Document number is required',
            'phone_1.required'=>'Phone number is required',
            'fax_1.required'=>'Fax number is required',
            'business_reg_no.required'=>'business Registration number is required',
            'business_reg_date.required'=>'business Registration date is required',
            'vat_no.required'=>'Vat number is required',
            'nature_of_business_id.required'=>'Nature of business is required',
            'is_active.required'=>'Supplier status is required'
            ]);

        $supplier = new Supplier;
        $supplier->doc_no = $request->doc_no;
        $supplier->reciept_no = $request->reciept_no;
        $supplier->company_name = $request->company_name;
        $supplier->phone_1 = $request->phone_1;
        $supplier->phone_2 = $request->phone_2;
        $supplier->fax_1 = $request->fax_1;
        $supplier->fax_2 = $request->fax_2;
        $supplier->email = $request->email;
        $supplier->business_reg_no = $request->business_reg_no;
        $supplier->business_reg_date = Carbon::parse($request->business_reg_date);
        $supplier->vat_no = $request->vat_no;
        $supplier->nature_of_business_id = $request->nature_of_business_id;
        $supplier->contact_person = $request->contact_person;
        $supplier->remark = $request->remark;
        $supplier->is_active = $request->is_active;

        $supplier->save();

        return redirect('/supplier/'.$supplier->id.'/products')->with(['success'=>'Supplier created successfully ! Add products to supplier']);

    }

    public function products($id){

        if ($supplier = Supplier::whereId($id)->first()){
            return view('supplier.products',compact('supplier'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->canEditSupplier()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        if ($supplier = Supplier::whereId($id)->with('products')->first()){

            $nature_of_business = NatureOfBusiness::all()->pluck('name','id');
            $products = Product::all()->pluck('name','id');

            return view('supplier.edit',compact('supplier','products','nature_of_business'));
        }
        return redirect()->back()->withErrors('Supplier not found !');
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
        if (!Auth::user()->canEditSupplier()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        if ($supplier = Supplier::whereId($id)->first()){

            $this->validate($request,[
                'doc_no'=>['required', new Doc_no()],
                'reciept_no'=>'required',
                'company_name'=>'required',
                'phone_1'=>['required', new Phone()],
                'phone_2'=>'nullable',
                'fax_1'=>['required', new Fax_no()],
                'fax_2'=>'nullable',
                'email'=>'required|email',
                'business_reg_no'=>['required', new Business_no()],
                'business_reg_date'=>'required|before_or_equal:'.Carbon::now(),
                'vat_no'=>['required', new Vat_no()],
                'nature_of_business_id'=>'required',
                'contact_person'=>'nullable',
                'remark'=>'max:500',
                'is_active'=>'required|integer'
            ], [
                'doc_no.required'=>'Document number is required',
                'phone_1.required'=>'Phone number is required',
                'fax_1.required'=>'Fax number is required',
                'business_reg_no.required'=>'business Registration number is required',
                'business_reg_date.required'=>'business Registration date is required',
                'vat_no.required'=>'Vat number is required',
                'nature_of_business_id.required'=>'Nature of business is required',
                'is_active.required'=>'Supplier status is required'
            ]);

            $supplier->doc_no = $request->doc_no;
            $supplier->reciept_no = $request->reciept_no;
            $supplier->company_name = $request->company_name;
            $supplier->phone_1 = $request->phone_1;
            $supplier->phone_2 = $request->phone_2;
            $supplier->fax_1 = $request->fax_1;
            $supplier->fax_2 = $request->fax_2;
            $supplier->email = $request->email;
            $supplier->business_reg_no = $request->business_reg_no;
            $supplier->business_reg_date = Carbon::parse($request->business_reg_date);
            $supplier->vat_no = $request->vat_no;
            $supplier->nature_of_business_id = $request->nature_of_business_id;
            $supplier->contact_person = $request->contact_person;
            $supplier->remark = $request->remark;
            $supplier->is_active = $request->is_active;

            $supplier->update();

            return redirect()->back()->with(['success'=>'Supplier updated successfully !']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
