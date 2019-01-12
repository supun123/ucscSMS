<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 06:22:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Employee
 * 
 * @property int $id
 * @property string $emp_id
 * @property int $title_id
 * @property string $initials
 * @property string $last_name
 * @property string $full_name
 * @property \Carbon\Carbon $date_of_birth
 * @property string $nic
 * @property int $gender_id
 * @property int $marital_status_id
 * @property string $address
 * @property string $mobile
 * @property string $land
 * @property string $email
 * @property int $designation_id
 * @property \Carbon\Carbon $date_of_join
 * @property string $img_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $users_id
 * @property int $division_id
 * 
 * @property \App\Models\Designation $designation
 * @property \App\Models\Division $division
 * @property \App\Models\Gender $gender
 * @property \App\Models\MaritalStatus $marital_status
 * @property \App\Models\Title $title
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $divisions
 * @property \Illuminate\Database\Eloquent\Collection $product_issues
 * @property \Illuminate\Database\Eloquent\Collection $product_requests
 * @property \Illuminate\Database\Eloquent\Collection $stock_requests
 *
 * @package App\Models
 */
class Employee extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'employee';

	protected $casts = [
		'title_id' => 'int',
		'gender_id' => 'int',
		'marital_status_id' => 'int',
		'designation_id' => 'int',
		'division_id' => 'int'
	];

	protected $dates = [
		'date_of_birth',
		'date_of_join'
	];

	protected $fillable = [
		'emp_id',
		'title_id',
		'initials',
		'last_name',
		'full_name',
		'date_of_birth',
		'nic',
		'gender_id',
		'marital_status_id',
		'address',
		'mobile',
		'land',
		'email',
		'designation_id',
		'date_of_join',
		'img_url',
		'division_id'
	];

    public function user()
    {
        return $this->hasOne(\App\Models\User::class);
    }

	public function designation()
	{
		return $this->belongsTo(\App\Models\Designation::class);
	}

	public function division()
	{
		return $this->belongsTo(\App\Models\Division::class);
	}

	public function gender()
	{
		return $this->belongsTo(\App\Models\Gender::class);
	}

	public function marital_status()
	{
		return $this->belongsTo(\App\Models\MaritalStatus::class);
	}

	public function title()
	{
		return $this->belongsTo(\App\Models\Title::class);
	}

	public function divisions()
	{
		return $this->hasMany(\App\Models\Division::class, 'head_employee_id');
	}

	public function products_issued()
	{
		return $this->hasMany(\App\Models\ProductIssue::class, 'issued_by');
	}

    public function product_requests()
    {
        return $this->hasMany(\App\Models\ProductRequest::class, 'requested_by');
    }

    public function product_requests_approved()
    {
        return $this->hasMany(\App\Models\ProductRequest::class, 'approved_by');
    }

	public function product_requests_confirmed()
	{
		return $this->hasMany(\App\Models\ProductRequest::class, 'confirmed_by');
	}

    public function stock_requests()
    {
        return $this->hasMany(\App\Models\StockRequest::class, 'requested_by');
    }

	public function stock_requests_approved()
	{
		return $this->hasMany(\App\Models\StockRequest::class, 'approved_by');
	}

    public function scopeNotUsers($query){
        return $query->whereNotIn('id',function($query) {

            $query->select('employee_id')->from('users');

        });
    }

    public function getShortNameAttribute(){
        return $this->title->name.' '.$this->initials." ".$this->last_name;
    }
}
