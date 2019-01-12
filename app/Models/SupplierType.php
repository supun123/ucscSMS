<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Sep 2018 08:18:19 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SupplierType
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $suppliers
 *
 * @package App\Models
 */
class SupplierType extends Eloquent
{
	protected $table = 'supplier_type';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function suppliers()
	{
		return $this->belongsToMany(\App\Models\Supplier::class, 'supplier_has_supplier_type');
	}
}
