<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Jul 2018 07:23:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Privilege
 * 
 * @property int $id
 * @property int $role_id
 * @property int $module_id
 * 
 * @property \App\Models\Module $module
 * @property \App\Models\Role $role
 * @property \Illuminate\Database\Eloquent\Collection $permissions
 *
 * @package App\Models
 */
class Privilege extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'module_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'module_id'
	];

	public function module()
	{
		return $this->belongsTo(\App\Models\Module::class);
	}

	public function role()
	{
		return $this->belongsTo(\App\Models\Role::class);
	}

	public function permissions()
	{
		return $this->belongsToMany(\App\Models\Permission::class, 'privileges_has_permissions', 'privileges_id', 'permissions_id');
	}
}
