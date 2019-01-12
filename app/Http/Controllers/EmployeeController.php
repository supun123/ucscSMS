<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\Photo;
use App\Models\Title;
use App\Rules\Address;
use App\Rules\emp_no;
use App\Rules\Name;
use App\Rules\Nic;
use App\Rules\Phone;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    private $log;
    /**
     * EmployeeController constructor.
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
        if (!Auth::user()->canViewEmployee()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $employees = Employee::all();
        return view('employee.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->canCreateEmployee()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        $titles = Title::all()->pluck('name','id');
        $genders = Gender::all()->pluck('name','id');
        $maritalStatusList = MaritalStatus::all()->pluck('name','id');
        $designations = Designation::all()->pluck('name','id');
        $divisions = Division::all()->pluck('name','id');
        return view('employee.create',compact('titles','genders','maritalStatusList','designations','divisions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canCreateEmployee()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        $this->validate($request,[

            'emp_id'=>['required' , 'unique:employee' , 'max:12' , new Emp_no()],
            'title_id'=>'required',
            'initials'=>['required', new Name()],
            'full_name'=>['required', new Name()],
            'last_name'=>['required', new Name()],
            'date_of_birth'=>'required|before:'.Carbon::now()->subYears(18),
            'nic'=>['required' , new Nic()],
            'gender_id'=>'required',
            'marital_status_id'=>'required',
            'address'=>['required' , new Address()],
            'mobile'=>['required' , new Phone()],
            'land'=>['required' , new Phone()],
            'email'=>'required|email',
            'designation_id'=>'required',
            'division_id'=>'required',
            'date_of_join'=>'required|before_or_equal:'.Carbon::now(),
            'image'=>'required|mimes:jpeg,png'

        ],[
            'emp_id.required'=>'Employee id is required',
            'title_id.required'=>'Title is required',
            'nic.required'=>'NIC number  is required',
            'gender_id.required'=>'Gender is required',
            'marital_status_id.required'=>'Marital Status is required',
            'designation_id.required'=>'Designation is required',
            'division_id'=>'Division is required',

        ]);

        $employee = new Employee;

        $employee->emp_id = $request->emp_id;
        $employee->title_id = $request->title_id;

        $employee->initials = $request->initials;
        $employee->full_name = $request->full_name;
        $employee->last_name = $request->last_name;
        $employee->date_of_birth = Carbon::parse($request->date_of_birth);

        $employee->nic = $request->nic;

        $employee->gender_id = $request->gender_id;
        $employee->marital_status_id = $request->marital_status_id;

        $employee->address = $request->address;
        $employee->mobile = $request->mobile;
        $employee->land = $request->land;
        $employee->email = $request->email;
        $employee->designation_id = $request->designation_id;
        $employee->division_id = $request->division_id;
        $employee->date_of_join = Carbon::parse($request->date_of_join);

        if ($request->hasFile('image')) {

            $photo = $request->file('image');
            $extension =  '.'.$photo->getClientOriginalExtension();
            $oName = $photo->getClientOriginalName();
            $name = $request->emp_id.$extension;

            $path =  $photo->move('img/users',$name);

            $employee->img_url = $path;

        }

        $employee->save();

//            Activity Log
        $this->log->log('Employee Created - EmpID - '.$employee->emp_id);
        return redirect()->back()->with(['success'=>'New Employee added successfully !']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user()->canViewEmployee()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        if ($employee = Employee::withTrashed()->where('id','=',$id)->first()){

            $titles = Title::all()->pluck('name','id');
            $genders = Gender::all()->pluck('name','id');
            $maritalStatusList = MaritalStatus::all()->pluck('name','id');
            $designations = Designation::all()->pluck('name','id');

            return view('employee.show',compact('employee','titles','genders','maritalStatusList','designations'));
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
        if (!Auth::user()->canEditEmployee()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        if ($employee = Employee::where('id','=',$id)->first()){

            $titles = Title::all()->pluck('name','id');
            $genders = Gender::all()->pluck('name','id');
            $maritalStatusList = MaritalStatus::all()->pluck('name','id');
            $designations = Designation::all()->pluck('name','id');
            $divisions = Division::all()->pluck('name','id');

            return view('employee.edit',compact('employee','titles','genders','maritalStatusList','designations','divisions'));
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
        if (!Auth::user()->canEditEmployee()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $this->validate($request,[

            'title_id'=>'required',
            'initials'=>['required', new Name()],
            'full_name'=>['required', new Name()],
            'last_name'=>['required', new Name()],
            'date_of_birth'=>'required|before:'.Carbon::now()->subYears(18),
            'nic'=>['required' , new Nic()],
            'gender_id'=>'required',
            'marital_status_id'=>'required',
            'address'=>['required' , new Address()],
            'mobile'=>['required' , new Phone()],
            'land'=>['required' , new Phone()],
            'email'=>'required|email',
            'designation_id'=>'required',
            'division_id'=>'required',
            'date_of_join'=>'required|before_or_equal:'.Carbon::now(),

        ],[

            'title_id.required'=>'Title is required',
            'nic.required'=>'NIC number  is required',
            'gender_id.required'=>'Gender is required',
            'marital_status_id.required'=>'Marital Status is required',
            'designation_id.required'=>'Designation is required',
            'division_id'=>'Division is required',

            ]);

        if ($employee = Employee::where('id','=',$id)->first()){


            $employee->title_id = $request->title_id;

            $employee->initials = $request->initials;
            $employee->full_name = $request->full_name;
            $employee->last_name = $request->last_name;
            $employee->date_of_birth = Carbon::parse($request->date_of_birth);

            $employee->nic = $request->nic;

            $employee->gender_id = $request->gender_id;
            $employee->marital_status_id = $request->marital_status_id;

            $employee->address = $request->address;
            $employee->mobile = $request->mobile;
            $employee->land = $request->land;
            $employee->email = $request->email;
            $employee->designation_id = $request->designation_id;
            $employee->date_of_join = Carbon::parse($request->date_of_join);

            if ($request->hasFile('image')) {

                $photo = $request->file('image');
                $extension =  '.'.$photo->getClientOriginalExtension();
                $oName = $photo->getClientOriginalName();
                $name = $request->emp_id.$extension;

                $path =  $photo->move('img/users',$name);

                $employee->img_url = $path;

            }

            $employee->update();

//            Activity Log
            $this->log->log('Employee Updated - EmpID - '.$employee->emp_id);
            return redirect()->back()->with(['success'=>'New Employee updated successfully !']);

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
        if (!Auth::user()->canDeleteEmployee()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        if ($employee = Employee::whereId($id)->first()){
            $this->log->log('Employee Deleted - EmpID - '.$employee->emp_id);

            if ($user = $employee->user){
                $user->is_active = 0;
                $user->update();
                $user->delete();
            }

            $employee->delete();
            return redirect()->back()->with(['success'=>'Employee deleted successfully !']);
        }
    }
}
