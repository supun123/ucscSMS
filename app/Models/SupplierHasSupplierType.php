<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 18 Sep 2018 06:08:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SupplierHasSupplierType
 * 
 * @property int $supplier_id
 * @property int $supplier_type_id
 * 
 * @property \App\Models\Supplier $supplier
 * @property \App\Models\SupplierType $supplier_type
 *
 * @package App\Models
 */
class SupplierHasSupplierType extends Eloquent
{
	protected $table = 'supplier_has_supplier_type';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'supplier_id' => 'int',
		'supplier_type_id' => 'int'
	];

	public function supplier()
	{
		return $this->belongsTo(\App\Models\Supplier::class);
	}

	public function supplier_type()
	{
		return $this->belongsTo(\App\Models\SupplierType::class);
	}
}
