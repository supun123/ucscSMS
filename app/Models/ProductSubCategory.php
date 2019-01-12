<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:59:29 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductSubCategory
 * 
 * @property int $id
 * @property string $name
 * @property int $product_category_id
 * 
 * @property \App\Models\ProductCategory $product_category
 * @property \Illuminate\Database\Eloquent\Collection $products
 *
 * @package App\Models
 */
class ProductSubCategory extends Eloquent
{
	protected $table = 'product_sub_category';
	public $timestamps = false;

	protected $casts = [
		'product_category_id' => 'int'
	];

	protected $fillable = [
		'name',
		'product_category_id'
	];

	public function category()
	{
		return $this->belongsTo(\App\Models\ProductCategory::class,'product_category_id','id');
	}

	public function products()
	{
		return $this->hasMany(\App\Models\Product::class);
	}
}
