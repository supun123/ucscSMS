<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 12 Nov 2018 16:10:01 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Log
 * 
 * @property int $id
 * @property int $log_type_id
 * @property \Carbon\Carbon $timestamp
 * @property string $message
 * @property int $users_id
 * 
 * @property \App\Models\LogType $log_type
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Log extends Eloquent
{
	protected $table = 'log';
	public $timestamps = false;

	protected $casts = [
		'log_type_id' => 'int',
		'users_id' => 'int'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'log_type_id',
		'timestamp',
		'message',
		'users_id'
	];

	public function log_type()
	{
		return $this->belongsTo(\App\Models\LogType::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'users_id')->withTrashed();
	}
}
