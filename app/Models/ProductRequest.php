<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:52:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductRequest
 * 
 * @property int $id
 * @property int $product_request_number
 * @property \Carbon\Carbon $date
 * @property \Carbon\Carbon $requested_at
 * @property int $requested_by
 * @property \Carbon\Carbon $approved_at
 * @property int $approved_by
 * @property \Carbon\Carbon $confirmed_at
 * @property int $confirmed_by
 * 
 * @property \App\Models\Employee $employee
 * @property \Illuminate\Database\Eloquent\Collection $product_issues
 * @property \Illuminate\Database\Eloquent\Collection $product_request_items
 *
 * @package App\Models
 */
class ProductRequest extends Eloquent
{
	protected $table = 'product_request';
	public $timestamps = false;

	protected $casts = [
		'requested_by' => 'int',
		'approved_by' => 'int',
		'confirmed_by' => 'int',
        'divisional_head_id' => 'int',
        'requested_division_id' => 'int'
	];

	protected $dates = [
		'date',
		'requested_at',
		'approved_at',
		'confirmed_at',
        'last_issued_at',
        'completed_at'
	];

	protected $fillable = [
		'product_request_number',
		'date',
		'requested_at',
		'requested_by',
		'approved_at',
		'approved_by',
		'confirmed_at',
		'confirmed_by',
        'last_issued_at',
        'completed_at',
        'divisional_head_id',
        'requested_division_id'
	];

	public function requestedBy()
	{
		return $this->belongsTo(\App\Models\Employee::class, 'requested_by');
	}

    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'approved_by');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'confirmed_by');
    }

	public function product_issues()
	{
		return $this->hasMany(\App\Models\ProductIssue::class);
	}

	public function items()
	{
		return $this->hasMany(\App\Models\ProductRequestItem::class);
	}
}
