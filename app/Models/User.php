<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 11 Oct 2018 08:26:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * 
 * @property int $id
 * @property string $user_name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $is_active
 * @property int $role_id
 * @property int $employee_id
 * 
 * @property \App\Models\Employee $employee
 * @property \App\Models\Role $role
 *
 * @package App\Models
 */
class User extends Eloquent
{

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

	public function employee()
	{
		return $this->belongsTo(\App\Models\Employee::class,'employee_id')->withTrashed();
	}

	public function role()
	{
		return $this->belongsTo(\App\Models\Role::class);
	}
}
