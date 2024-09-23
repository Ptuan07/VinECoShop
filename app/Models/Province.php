<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'idProvince';
    protected $casts = [
        'idProvince' => 'string',
    ];

    public function districts()
    {
        return $this->hasMany(District::class, 'idProvince');
    }

    public function addresses()
    {
        return $this->hasMany(AddressCustomer::class, 'idProvince');
    }
}