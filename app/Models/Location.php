<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'location';
    protected $primaryKey = 'idLocation';
    protected $fillable = ['idWareHouse','location','locationSlug','total_shelves', 'description'];


    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'idWareHouse', 'idWareHouse');
    }

    public function shelves()
    {
        return $this->hasMany(Shelves::class, 'idLocation', 'idLocation');
    }

    public function orderWarehouses()
    {
        return $this->hasMany(OrderWarehouse::class, 'idLocation', 'idLocation');
    }
}
