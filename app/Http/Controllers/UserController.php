<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $log;
    /**
     * UserController constructor.
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
        if (!Auth::user()->canViewUser()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $users = User::all();
        return view('user.index',compact('users'));
    }

    public function userSelect()
    {
        if (!Auth::user()->canCreateUser()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $employees = Employee::NotUsers()->get();
        return view('user.userSelect',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (!Auth::user()->canCreateUser()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        if ($employee = Employee::where('id','=',$id)->first()){
            $roles = Role::all()->pluck('name','id');
            return view('user.create',compact('id','employee','roles'));
        }

        return redirect('home');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canCreateUser()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        $this->validate($request,[
            'user_name'=>'required|min:6|unique:users',
            'email'=>'required|email|unique:users',
            'role_id'=>'required|integer',
            'is_active'=>'required|integer|between:0,1',
            'password'=>'required|min:6|confirmed'
        ]);


        if ($request->id !='' && $employee = Employee::where('id','=',$request->id)->first()){

            if ($user = User::where('employee_id','=',$employee->id)->first()){

                return redirect()->back()->withErrors(['error'=>'This employee already has a user account !']);
            }

            $user = new User;
            $user->employee_id = $request->id;
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->is_active = $request->is_active;

            $user->password = bcrypt($request->password);
            $user->save();

//            Activity Log
            $this->log->log('User account created');

            return redirect('/user/create/select')->with(['success'=>'New user created successfully !']);
        }

        return redirect('home');
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
        if (!Auth::user()->canEditUser()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        if ($user = User::where('id','=',$id)->first()){
            $roles = Role::all()->pluck('name','id');
            return view('user.edit',compact('user','roles'));
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
        if (!Auth::user()->canEditUser()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }

        $user = User::where('id','=',$id)->first();
        $this->validate($request,[
            'user_name'=>'required|min:6|unique:users,id,'.$user->id,
            'email'=>'required|email|unique:users,id,'.$user->id,
            'role_id'=>'required|integer',
            'is_active'=>'required|integer|between:0,1',
            'password'=>'nullable|min:6'
        ]);

        if ($user = User::where('id','=',$id)->first()){

            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->is_active = $request->is_active;

            if($request->password != ''){
                $user->password = bcrypt($request->password);
            }

            $user->update();
//            Activity Log
            $this->log->log('User account updated');

            return redirect()->back()->with(['success'=>'User details updated successfully !']);

        }
    }
}
