<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Oct 2018 07:12:21 +0000.
 */

namespace App\Models;


use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Supplier
 * 
 * @property int $id
 * @property string $doc_no
 * @property string $reciept_no
 * @property string $company_name
 * @property string $phone_1
 * @property string $phone_2
 * @property string $fax_1
 * @property string $fax_2
 * @property string $email
 * @property string $business_reg_no
 * @property \Carbon\Carbon $business_reg_date
 * @property string $vat_no
 * @property string $nature_of_business
 * @property string $contact_person
 * @property string $remark
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $stocks
 * @property \Illuminate\Database\Eloquent\Collection $supplier_addresses
 * @property \Illuminate\Database\Eloquent\Collection $products
 *
 * @package App\Models
 */
class Supplier extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'supplier';

    protected $casts = [
        'is_active' => 'int'
    ];

	protected $dates = [
		'business_reg_date'
	];

	protected $fillable = [
		'doc_no',
		'reciept_no',
		'company_name',
		'phone_1',
		'phone_2',
		'fax_1',
		'fax_2',
		'email',
		'business_reg_no',
		'business_reg_date',
		'vat_no',
		'nature_of_business',
		'contact_person',
		'remark',
        'is_active'
	];

	public function stocks()
	{
		return $this->hasMany(\App\Models\Stock::class);
	}

	public function supplier_addresses()
	{
		return $this->hasMany(\App\Models\SupplierAddress::class);
	}

    public function natureOfBusiness()
    {
        return $this->hasone(\App\Models\NatureOfBusiness::class);
    }

	public function products()
	{
		return $this->belongsToMany(\App\Models\Product::class, 'supplier_has_product');
	}
}
