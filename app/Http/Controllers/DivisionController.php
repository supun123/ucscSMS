<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(){
        $employees = Employee::all()->pluck('shortName','id');
        $divisions = Division::all();
        return view('admin.division.index',compact('divisions','employees'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|unique:division',
            'head_employee_id'=>'required'
        ]);

        $division = new Division;
        $division->name = $request->name;
        $division->head_employee_id = $request->head_employee_id;
        $division->save();

        return redirect()->back()->with(['success'=>'New division added successfully !']);
    }

    public function edit($id){
        if ($division = Division::whereId($id)->first()){
            $employees = Employee::all()->pluck('shortName','id');
            $divisions = Division::all();
            return view('admin.division.edit',compact('divisions','employees','division'));
        }
    }

    public function update(Request $request,$id){
        $this->validate($request,[
            'name'=>'required',
            'head_employee_id'=>'required'
        ]);

        if ($division = Division::whereId($id)->first()){
            $division->name = $request->name;
            $division->head_employee_id = $request->head_employee_id;
            $division->save();

            return redirect()->back()->with(['success'=>'Division updated successfully !']);
        }
    }
}
