<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:55:34 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductIssueItem
 *
 * @property int $id
 * @property int $product_issue_id
 * @property int $product_request_items_id
 * @property int $stock_items_id
 * @property int $quantity
 *
 * @property \App\Models\ProductIssue $product_issue
 * @property \App\Models\ProductRequestItem $product_request_item
 * @property \App\Models\StockItem $stock_item
 *
 * @package App\Models
 */
class ProductIssueItem extends Eloquent
{
    public $timestamps = false;

    protected $casts = [
        'product_issue_id' => 'int',
        'product_request_items_id' => 'int',
        'stock_items_id' => 'int',
        'quantity' => 'int',
		'price' => 'float',
		'tax' => 'float'
    ];

    protected $fillable = [
        'product_issue_id',
        'product_request_items_id',
        'stock_items_id',
        'quantity',
		'price',
		'tax'
    ];

    public function product_issue()
    {
        return $this->belongsTo(\App\Models\ProductIssue::class);
    }

    public function product_request_item()
    {
        return $this->belongsTo(\App\Models\ProductRequestItem::class, 'product_request_items_id');
    }

    public function stock_item()
    {
        return $this->belongsTo(\App\Models\StockItem::class, 'stock_items_id');
    }

//    public function stocks()
//    {
//        return $this->belongsToMany(\App\Models\Stock::class, 'product_issue_items_stocks', 'product_issue_items_id')
//            ->withPivot('id', 'quantity');
//    }

    public function stocks()
    {
        return $this->belongsToMany(\App\Models\ProductIssueItemsStock::class);
    }
}
