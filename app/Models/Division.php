<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:22:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Division
 * 
 * @property int $id
 * @property string $name
 * @property int $head_employee_id
 * 
 * @property \App\Models\Employee $employee
 * @property \Illuminate\Database\Eloquent\Collection $employees
 *
 * @package App\Models
 */
class Division extends Eloquent
{
	protected $table = 'division';
	public $timestamps = false;

	protected $casts = [
		'head_employee_id' => 'int'
	];

	protected $fillable = [
		'name',
		'head_employee_id'
	];

	public function head()
	{
		return $this->belongsTo(\App\Models\Employee::class, 'head_employee_id')->withTrashed();
	}

	public function employees()
	{
		return $this->hasMany(\App\Models\Employee::class);
	}

	public function completedProductRequests()
	{
		return $this->hasMany(\App\Models\ProductRequest::class,'requested_division_id')->where('completed_at','!=',null);
	}
}
