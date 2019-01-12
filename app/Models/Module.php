<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Jul 2018 07:23:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Module
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $permissions
 * @property \Illuminate\Database\Eloquent\Collection $privileges
 *
 * @package App\Models
 */
class Module extends Eloquent
{
	protected $table = 'module';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function permissions()
	{
		return $this->belongsToMany(\App\Models\Permission::class, 'module_has_permissions', 'module_id', 'permissions_id');
	}

	public function privileges()
	{
		return $this->hasMany(\App\Models\Privilege::class);
	}
}
