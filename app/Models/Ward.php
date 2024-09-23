<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'ward';
    protected $primaryKey = 'idWard';

    protected $casts = [
        'idWard' => 'string',
    ];
    public function district()
    {
        return $this->belongsTo(District::class, 'idDistrict');
    }

    public function addresses()
    {
        return $this->hasMany(AddressCustomer::class, 'idWard');
    }
}