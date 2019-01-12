<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(){
        $designations = Designation::all();
        return view('admin.designation.index',compact('designations'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|unique:designation'
        ]);

        $designation = new Designation;
        $designation->name = $request->name;
        $designation->save();

        return redirect()->back()->with(['success'=>'New designation added successfully !']);
    }

    public function edit($id){
        if ($designation = Designation::whereId($id)->first()){
            $employees = Employee::all()->pluck('shortName','id');
            $designations = Designation::all();
            return view('admin.designation.edit',compact('designations','designation'));
        }
    }

    public function update(Request $request,$id){
        $this->validate($request,[
            'name'=>'required'
        ]);

        if ($designation = Designation::whereId($id)->first()){
            $designation->name = $request->name;
            $designation->save();

            return redirect()->back()->with(['success'=>'Designation updated successfully !']);
        }
    }
}
