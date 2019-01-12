<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 12 Nov 2018 16:10:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LogType
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $logs
 *
 * @package App\Models
 */
class LogType extends Eloquent
{
	protected $table = 'log_type';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function logs()
	{
		return $this->hasMany(\App\Models\Log::class);
	}
}
