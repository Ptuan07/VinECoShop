<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    protected $primaryKey = 'idDistrict';
    protected $casts = [
        'idDistrict' => 'string',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'idProvince');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'idDistrict');
    }

    public function addresses()
    {
        return $this->hasMany(AddressCustomer::class, 'idDistrict');
    }
}