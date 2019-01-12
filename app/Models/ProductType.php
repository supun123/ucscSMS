<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 07:00:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductType
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $products
 *
 * @package App\Models
 */
class ProductType extends Eloquent
{
	protected $table = 'product_type';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function products()
	{
		return $this->hasMany(\App\Models\Product::class);
	}
}
