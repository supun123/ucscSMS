<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 25 Oct 2018 07:58:04 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductIssueItemsStock
 * 
 * @property int $id
 * @property int $product_issue_items_id
 * @property int $stock_id
 * @property int $quantity
 * 
 * @property \App\Models\ProductIssueItem $product_issue_item
 * @property \App\Models\Stock $stock
 *
 * @package App\Models
 */
class ProductIssueItemsStock extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'product_issue_items_id' => 'int',
		'stock_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'product_issue_items_id',
		'stock_id',
		'quantity'
	];

	public function product_issue_item()
	{
		return $this->belongsTo(\App\Models\ProductIssueItem::class, 'product_issue_items_id');
	}

	public function stock()
	{
		return $this->belongsTo(\App\Models\Stock::class);
	}
}
