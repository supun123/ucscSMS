<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Jul 2018 07:23:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PrivilegesHasPermission
 * 
 * @property int $privileges_id
 * @property int $permissions_id
 * 
 * @property \App\Models\Permission $permission
 * @property \App\Models\Privilege $privilege
 *
 * @package App\Models
 */
class PrivilegesHasPermission extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'privileges_id' => 'int',
		'permissions_id' => 'int'
	];

	public function permission()
	{
		return $this->belongsTo(\App\Models\Permission::class, 'permissions_id');
	}

	public function privilege()
	{
		return $this->belongsTo(\App\Models\Privilege::class, 'privileges_id');
	}
}
