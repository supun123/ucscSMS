<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:58:30 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $name
 * @property int $product_sub_category_id
 * @property int $product_type_id
 * @property string $code
 * @property string $description
 * @property string $image_url
 * @property int $product_status_id
 * @property string $product_code
 * @property string $asset_code
 * @property string $barcode
 * 
 * @property \App\Models\ProductStatus $product_status
 * @property \App\Models\ProductSubCategory $product_sub_category
 * @property \App\Models\ProductType $product_type
 * @property \Illuminate\Database\Eloquent\Collection $inventories
 * @property \Illuminate\Database\Eloquent\Collection $product_request_items
 * @property \Illuminate\Database\Eloquent\Collection $stock_request_items
 * @property \Illuminate\Database\Eloquent\Collection $suppliers
 *
 * @package App\Models
 */
class Product extends Eloquent
{
	protected $table = 'product';
	public $timestamps = false;

	protected $casts = [
		'product_sub_category_id' => 'int',
		'product_type_id' => 'int',
		'product_status_id' => 'int',
        'reorder_level' => 'int',
        'critical_reorder_level'=> 'int'
	];

	protected $fillable = [
		'name',
		'product_sub_category_id',
		'product_type_id',
		'code',
		'description',
		'image_url',
		'product_status_id',
		'product_code',
		'asset_code',
		'barcode',
        'reorder_level',
        'critical_reorder_level'
	];

	public function status()
	{
		return $this->belongsTo(\App\Models\ProductStatus::class,'product_status_id');
	}

	public function subCategory()
	{
		return $this->belongsTo(\App\Models\ProductSubCategory::class,'product_sub_category_id');
	}

	public function type()
	{
		return $this->belongsTo(\App\Models\ProductType::class,'product_type_id');
	}

	public function inventory()
	{
		return $this->hasMany(\App\Models\Inventory::class);
	}

	public function product_request_items()
	{
		return $this->hasMany(\App\Models\ProductRequestItem::class);
	}

	public function stock_request_items()
	{
		return $this->hasMany(\App\Models\StockRequestItem::class);
	}

	public function suppliers()
	{
		return $this->belongsToMany(\App\Models\Supplier::class, 'supplier_has_product');
	}
}
