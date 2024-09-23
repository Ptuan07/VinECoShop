<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressCustomer extends Model
{
    public $timestamp = false;
    protected $fillable = ['idCustomer','PhoneNumber','CustomerName','Address','idProvince','idDistrict','idWard'];
    protected $primaryKey = 'idAddress';
    protected $table = 'addresscustomer';

    protected $casts = [
        'idProvince' => 'string',
        'idDistrict' => 'string',
        'idWard' => 'string',
    ];
    public function province()
    {
        return $this->belongsTo(Province::class, 'idProvince');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'idDistrict');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'idWard');
    }
}
