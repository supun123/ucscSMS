<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:56:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class StockRequestItem
 * 
 * @property int $id
 * @property int $product_id
 * @property int $stock_request_id
 * @property int $quantity
 * 
 * @property \App\Models\Product $product
 * @property \App\Models\StockRequest $stock_request
 * @property \Illuminate\Database\Eloquent\Collection $stock_items
 *
 * @package App\Models
 */
class StockRequestItem extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'stock_request_id' => 'int',
		'quantity' => 'int'
	];

    protected $dates = [
        'last_received_date'
    ];

	protected $fillable = [
		'product_id',
		'stock_request_id',
		'quantity',
        'received_quantity',
        'last_received_date'
	];

	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class);
	}

	public function stock_request()
	{
		return $this->belongsTo(\App\Models\StockRequest::class);
	}

	public function stock_items()
	{
		return $this->hasMany(\App\Models\StockItem::class, 'stock_request_items_id');
	}
}
