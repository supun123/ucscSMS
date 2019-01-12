<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:51:38 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProductIssue
 * 
 * @property int $id
 * @property int $product_request_id
 * @property \Carbon\Carbon $issued_at
 * @property int $issued_by
 * 
 * @property \App\Models\Employee $employee
 * @property \App\Models\ProductRequest $product_request
 * @property \Illuminate\Database\Eloquent\Collection $product_issue_items
 *
 * @package App\Models
 */
class ProductIssue extends Eloquent
{
	protected $table = 'product_issue';
	public $timestamps = false;

	protected $casts = [
		'product_request_id' => 'int',
		'issued_by' => 'int'
	];

	protected $dates = [
		'issued_at'
	];

	protected $fillable = [
		'product_request_id',
		'issued_at',
		'issued_by'
	];

	public function issuedBy()
	{
		return $this->belongsTo(\App\Models\Employee::class, 'issued_by');
	}

	public function product_request()
	{
		return $this->belongsTo(\App\Models\ProductRequest::class);
	}

	public function product_issue_items()
	{
		return $this->hasMany(\App\Models\ProductIssueItem::class);
	}
}
