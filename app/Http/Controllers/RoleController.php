<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Privilege;
use App\Models\Role;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    private $log;
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $log = new LogService;
        $this->log = $log;
    }

    public function index(){

        if (Auth::user()->canViewRole()){

            $roles = Role::all();
            return view('role.index',compact('roles'));

        }
        return redirect('home');
    }

    public function assignNewModule($id){
        if (!Auth::user()->canEditRole()){

            return redirect('home');
        }

        $role = Role::whereId($id)->first();
        $modules = Role::notAssignedmodules($id);
        return view('role.assignNewModule',compact('role','modules'));

    }

    public function getPermissionsByModuleId($id){

        if (Auth::user()->canViewRole()){

            if ($id !='' && $module = Module::whereId($id)->first()){
                return response($module->permissions,'200');
            }

            return response('Not Found','501');

        }

        return response('<h5 class="text-center text-danger">You Don\'t have permissions.</h5>','501');


    }

    public function getPermissionsByModule(Request $request){

        if (Auth::user()->canViewRole()){

            if ($request->moduleId && $module = Module::whereId($request->moduleId)->first()){
                return response($module->permissions,'200');
            }
            return response('Not Found','501');
        }

        return response('<h5 class="text-center text-danger">You Don\'t have permissions.</h5>','501');

    }

    public function storeNewModule(Request $request){

        if (Auth::user()->canEditRole()){

            if($role = Role::whereId($request->role_id)->first()){

                $privilege = new Privilege;
                $privilege->module_id = $request->module_id;
                $privilege->role_id = $request->role_id;
                $privilege->save();

                $privilege->permissions()->attach($request->permission_ids);
                $privilege->update();
//            Activity Log
                $this->log->log('User Role has updated. Added new permissions.');
                return redirect()->back()->with(['success'=>'Module assigned successfully!.']);

            }
        }

        return redirect('home');

    }

    public function editPerimssionsByModule($rId,$mId){

        if (Auth::user()->canEditRole()){
            if($rId!=''){
                if($role = Role::whereId($rId)->first()){
                    $permissions =  $role->privileges->where('module_id','=',$mId)->first()->permissions;
                    $module = Module::whereId($mId)->first();
                    return view('role.editPrivilegesByModule',compact('role','permissions','module'));
                }
            }
        }

        return redirect('home');

    }

    public function updatePermissionsByModule(Request $request){
        if (Auth::user()->canEditRole()){

            if($role = Role::whereId($request->role_id)->first()){

                $privilege = Privilege::whereRoleId($request->role_id)->whereModuleId($request->module_id)->first();
                $privilege->permissions()->detach();
                $privilege->permissions()->attach($request->permission_ids);
                $privilege->update();

//            Activity Log
                $this->log->log('User Role has updated. Changed permissions.');

                return redirect()->back()->with(['success'=>$privilege->module->name." module's permissions updated successfully!"]);

            }

        }

        return redirect('home');

    }

    public function deletePrivilege($id){

        if (Auth::user()->canEditRole()){

            if($privilege = Privilege::whereId($id)->first()){
                $role = $privilege->role;
                $module = $privilege->module;
                $privilege->delete();

//            Activity Log
                $this->log->log('User Role has updated. Deleted permissions.');

                return redirect()->back()->with(['success'=>$module->name.' module deleted from '.$role->name.' successfully!.']);
            }

            return redirect()->back()->withErrors(['error'=>'Sorry. module cannot find !']);
        }

        return redirect('home');

    }

    public function create(){

        if (Auth::user()->canCreateRole()){
            $modules = Module::all();
            return view('role.create',compact('modules'));
        }

        return redirect('home');

    }

    public function store(Request $request){

        if (Auth::user()->canCreateRole()){

            $this->validate($request,[
                'name'=>'required|unique:role'
            ]);

            if ($request->name!=''){
                $role = new Role;
                $role->name = $request->name;
                $role->save();

                if($request->permissions){

                    foreach ($request->permissions as $module => $permissions){
                        if ($module = Module::where('name','=',$module)->first()){

                            if($permissions){
                                $privilege = new Privilege;
                                $privilege->module_id = $module->id;
                                $privilege->role_id = $role->id;
                                $privilege->save();

                                $privilege->permissions()->attach($permissions);
                                $privilege->update();
                            }

                        }

                    }

                }

//            Activity Log
                $this->log->log('New Role created.');

                return redirect()->back()->with(['success'=>$role->name.' role created successfully!.']);
            }
        }

        return redirect('home');

    }

    public function deleteRole($id){

        if (Auth::user()->canDeleteRole()){

            if ($role = Role::where('id','=',$id)->first()){

                if($role->name == 'User'){
                    return redirect()->back()->withErrors('Role \'User\' cannot delete.');
                }

                if(count($role->users)==0){
                    $role->delete();
                    return redirect()->back()->with(['success'=>$role->name.' role deleted successfully!.']);
                }elseif (count($role->users)>0){
                    if($roleUser = Role::where('name','=','User')->first()){

                        foreach ($role->users as $user){
                            $user->role_id = $roleUser->id;
                            $user->update();
                        }

                        $role->delete();

//            Activity Log
                        $this->log->log('Role deleted.');

                        return redirect()->back()->with(['success'=>'Role deleted successfully!.']);
                    }
                }
            }
        }

        return redirect('home');
    }

}
