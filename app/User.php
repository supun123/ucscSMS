<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $casts = [
        'is_active' => 'int',
        'role_id' => 'int',
        'employee_id' => 'int'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'user_name',
        'email',
        'password',
        'remember_token',
        'is_active',
        'role_id',
        'employee_id'
    ];

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class,'employee_id');
    }

    /**
     * @return bool
     */
    private function checkPrivilege(String $module_name, String $permission_name): bool
    {
        foreach ($this->role->privileges as $privilege) {

            $module = $privilege->module;

            if ($module->name == $module_name) {

                $permissions = $privilege->permissions;

                foreach ($permissions as $permission) {
                    if ($permission->name == $permission_name) {
                        return true;
                    }
                }

            }

        }

        return false;
    }

    public function canViewUser(){

        return $this->checkPrivilege('User','View');
    }

    public function canCreateUser(){

        return $this->checkPrivilege('User','Create');
    }

    public function canEditUser(){

        return $this->checkPrivilege('User','Edit');
    }

    public function canDeleteUser(){

        return $this->checkPrivilege('User','Delete');
    }

    public function canViewRole(){

        return $this->checkPrivilege('Role','View');
    }

    public function canCreateRole(){

        return $this->checkPrivilege('Role','Create');
    }

    public function canEditRole(){

        return $this->checkPrivilege('Role','Edit');
    }

    public function canDeleteRole(){

        return $this->checkPrivilege('Role','Delete');
    }

    public function canViewEmployee(){

        return $this->checkPrivilege('Employee','View');
    }

    public function canCreateEmployee(){

        return $this->checkPrivilege('Employee','Create');
    }

    public function canEditEmployee(){

        return $this->checkPrivilege('Employee','Edit');
    }

    public function canDeleteEmployee(){

        return $this->checkPrivilege('Employee','Delete');
    }


    public function canViewLog(){

        return $this->checkPrivilege('Log','View');
    }

    public function canViewSupplier(){

        return $this->checkPrivilege('Supplier','View');
    }

    public function canCreateSupplier(){

        return $this->checkPrivilege('Supplier','Create');
    }

    public function canEditSupplier(){

        return $this->checkPrivilege('Supplier','Edit');
    } 
    
    public function canViewProduct(){

        return $this->checkPrivilege('Product','View');
    }

    public function canCreateProduct(){

        return $this->checkPrivilege('Product','Create');
    }

    public function canEditProduct(){

        return $this->checkPrivilege('Product','Edit');
    }

    public function canViewProductRequest(){

        return $this->checkPrivilege('Product','View Product Request');
    }

    public function canCreateProductRequest(){

        return $this->checkPrivilege('Product','Create Product Request');
    }

    public function canApproveProductRequest(){

        return $this->checkPrivilege('Product','Approve Product Request');
    }

    public function canConfirmProductRequest(){

        return $this->checkPrivilege('Product','Confirm Product Request');
    }

    public function canIssueProducts(){

        return $this->checkPrivilege('Product','Issue Products');
    }

    public function canViewStock(){

        return $this->checkPrivilege('Stock','View');
    }

    public function canCreateStock(){

        return $this->checkPrivilege('Stock','Create');
    }

    public function canApproveStockRequest(){

        return $this->checkPrivilege('Stock','Approve Stock Request');
    }

    public function canCreateStockRequest(){

        return $this->checkPrivilege('Stock','Create Stock Request');
    }

    public function canViewStockRequest(){

        return $this->checkPrivilege('Stock','View Stock Request');
    }

    public function canDownloadStockRequest(){

        return $this->checkPrivilege('Stock','Download Stock Request');
    }

    public function canViewInventory(){

        return $this->checkPrivilege('Inventory','View');
    }

    public function canAdmin(){

        return $this->checkPrivilege('Admin','Admin');
    }
}
