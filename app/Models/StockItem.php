<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:56:21 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class StockItem
 * 
 * @property int $id
 * @property int $stock_id
 * @property int $stock_request_items_id
 * @property float $unit_price
 * @property int $quantity
 * @property float $tax
 * @property string $asset_code
 * @property string $barcode
 * 
 * @property \App\Models\Stock $stock
 * @property \App\Models\StockRequestItem $stock_request_item
 * @property \Illuminate\Database\Eloquent\Collection $product_issue_items
 *
 * @package App\Models
 */
class StockItem extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'stock_id' => 'int',
		'stock_request_items_id' => 'int',
		'unit_price' => 'float',
		'quantity' => 'int',
		'tax' => 'float'
	];

	protected $fillable = [
		'stock_id',
		'stock_request_items_id',
		'unit_price',
		'quantity',
		'tax',
		'asset_code',
		'barcode'
	];

	public function stock()
	{
		return $this->belongsTo(\App\Models\Stock::class);
	}

	public function stockRequestItem()
	{
		return $this->belongsTo(\App\Models\StockRequestItem::class, 'stock_request_items_id');
	}

	public function product_issue_items()
	{
		return $this->hasMany(\App\Models\ProductIssueItem::class, 'stock_items_id');
	}
}
