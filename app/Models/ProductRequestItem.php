<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:55:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductRequestItem
 * 
 * @property int $id
 * @property int $product_request_id
 * @property int $product_id
 * @property int $quantity
 * 
 * @property \App\Models\Product $product
 * @property \App\Models\ProductRequest $product_request
 * @property \Illuminate\Database\Eloquent\Collection $product_issue_items
 *
 * @package App\Models
 */
class ProductRequestItem extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'product_request_id' => 'int',
		'product_id' => 'int',
		'quantity' => 'int'
	];

    protected $dates = [
        'last_received_date'
    ];

	protected $fillable = [
		'product_request_id',
		'product_id',
		'quantity',
        'last_received_date'
	];

	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class);
	}

	public function product_request()
	{
		return $this->belongsTo(\App\Models\ProductRequest::class);
	}

	public function product_issue_items()
	{
		return $this->hasMany(\App\Models\ProductIssueItem::class, 'product_request_items_id');
	}
}
