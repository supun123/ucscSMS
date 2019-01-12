<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 08:18:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SupplierAddress
 * 
 * @property int $id
 * @property int $supplier_id
 * @property string $number
 * @property string $street_1
 * @property string $street_2
 * @property string $city
 * 
 * @property \App\Models\Supplier $supplier
 *
 * @package App\Models
 */
class SupplierAddress extends Eloquent
{
	protected $table = 'supplier_address';
	public $timestamps = false;

	protected $casts = [
		'supplier_id' => 'int'
	];

	protected $fillable = [
		'supplier_id',
		'number',
		'street_1',
		'street_2',
		'city'
	];

	public function supplier()
	{
		return $this->belongsTo(\App\Models\Supplier::class);
	}
}
