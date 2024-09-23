<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    use HasFactory;
    protected $table = 'warehouse';
    protected $primaryKey = 'idWareHouse';
    protected $fillable = [ ];


    public function locations()
    {
        return $this->hasMany(Location::class, 'idWareHouse', 'idWareHouse');
    }

    public function orderWarehouses()
    {
        return $this->hasMany(OrderWarehouse::class, 'idWareHouse', 'idWareHouse');
    }
}
