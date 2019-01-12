<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Jul 2018 07:23:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MaritalStatus
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $employees
 *
 * @package App\Models
 */
class MaritalStatus extends Eloquent
{
	protected $table = 'marital_status';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function employees()
	{
		return $this->hasMany(\App\Models\Employee::class);
	}
}
