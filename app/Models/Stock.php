<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 Oct 2018 08:45:45 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Stock
 * 
 * @property int $id
 * @property string $stock_number
 * @property string $invoice_number
 * @property \Carbon\Carbon $date
 * @property int $supplier_id
 * @property int $stock_request_id
 * 
 * @property \App\Models\StockRequest $stock_request
 * @property \App\Models\Supplier $supplier
 * @property \Illuminate\Database\Eloquent\Collection $inventories
 * @property \Illuminate\Database\Eloquent\Collection $stock_items
 *
 * @package App\Models
 */
class Stock extends Eloquent
{
	protected $table = 'stock';
	public $timestamps = false;

	protected $casts = [
		'supplier_id' => 'int',
		'stock_request_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'stock_number',
		'invoice_number',
		'date',
		'supplier_id',
		'stock_request_id',
        'created_by'
	];

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'created_by');
    }

	public function stockRequest()
	{
		return $this->belongsTo(\App\Models\StockRequest::class);
	}

	public function supplier()
	{
		return $this->belongsTo(\App\Models\Supplier::class);
	}

	public function inventories()
	{
		return $this->hasMany(\App\Models\Inventory::class);
	}

	public function items()
	{
		return $this->hasMany(\App\Models\StockItem::class);
	}
}
