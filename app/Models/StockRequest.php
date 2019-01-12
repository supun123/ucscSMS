<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 Oct 2018 08:46:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class StockRequest
 * 
 * @property int $id
 * @property string $stock_request_number
 * @property \Carbon\Carbon $date
 * @property int $requested_by
 * @property \Carbon\Carbon $approved_at
 * @property int $approved_by
 * 
 * @property \App\Models\Employee $employee
 * @property \Illuminate\Database\Eloquent\Collection $stocks
 * @property \Illuminate\Database\Eloquent\Collection $stock_request_items
 *
 * @package App\Models
 */
class StockRequest extends Eloquent
{
	protected $table = 'stock_request';
	public $timestamps = false;

	protected $casts = [
		'requested_by' => 'int',
		'approved_by' => 'int'
	];

	protected $dates = [
		'date',
		'approved_at',
        'updated_at',
        'completed_at'
	];

	protected $fillable = [
		'stock_request_number',
		'date',
		'requested_by',
		'approved_at',
		'approved_by',
        'updated_at',
        'completed_at'
	];

    public function requestedBy()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'approved_by');
    }

	public function stocks()
	{
		return $this->hasMany(\App\Models\Stock::class);
	}

    public function items()
    {
        return $this->hasMany(\App\Models\StockRequestItem::class);
    }

    public function scopeNotApproved($query)
    {
        return $query->where('approved_at','=',null);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved_at','!=',null);
    }

    public function scopeNotCompleted($query)
    {
        return $query->where('approved_at','!=',null)->where('completed_at','=',null);
    }
}
