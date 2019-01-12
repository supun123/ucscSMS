<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:59:11 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductStatus
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $products
 *
 * @package App\Models
 */
class ProductStatus extends Eloquent
{
	protected $table = 'product_status';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function products()
	{
		return $this->hasMany(\App\Models\Product::class);
	}
}
