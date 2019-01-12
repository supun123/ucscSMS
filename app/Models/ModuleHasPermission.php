<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Jul 2018 07:23:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ModuleHasPermission
 * 
 * @property int $module_id
 * @property int $permissions_id
 * 
 * @property \App\Models\Module $module
 * @property \App\Models\Permission $permission
 *
 * @package App\Models
 */
class ModuleHasPermission extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'module_id' => 'int',
		'permissions_id' => 'int'
	];

	public function module()
	{
		return $this->belongsTo(\App\Models\Module::class);
	}

	public function permission()
	{
		return $this->belongsTo(\App\Models\Permission::class, 'permissions_id');
	}
}
