<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Nov 2018 08:50:24 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class NatureOfBusiness
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class NatureOfBusiness extends Eloquent
{
	protected $table = 'nature_of_business';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];
}
