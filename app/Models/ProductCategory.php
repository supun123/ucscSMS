<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:59:42 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductCategory
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $product_sub_categories
 *
 * @package App\Models
 */
class ProductCategory extends Eloquent
{
	protected $table = 'product_category';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function product_sub_categories()
	{
		return $this->hasMany(\App\Models\ProductSubCategory::class);
	}
}
