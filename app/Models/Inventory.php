<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 07:00:16 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Inventory
 * 
 * @property int $id
 * @property int $product_id
 * @property int $stock_id
 * @property int $quantity
 * 
 * @property \App\Models\Product $product
 * @property \App\Models\Stock $stock
 *
 * @package App\Models
 */
class Inventory extends Eloquent
{
	protected $table = 'inventory';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'stock_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'product_id',
		'stock_id',
		'quantity'
	];

	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class)->with('subCategory');
	}

	public function stock()
	{
		return $this->belongsTo(\App\Models\Stock::class);
	}

    public function unitPrice()
    {
        if ($stockItem = StockItem::where('stock_id','=',$this->stock_id)->first()){
            return $stockItem->unit_price;
        }
    }

    public function tax()
    {
        if ($stockItem = StockItem::where('stock_id','=',$this->stock_id)->first()){
            return $stockItem->tax;
        }
    }
}
