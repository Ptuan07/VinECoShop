<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelves extends Model
{
    use HasFactory;
    protected $table = 'shelves';
    protected $primaryKey = 'idShelves';
    protected $fillable = ['idLocation','shelf_number','status','description'];


    public function location()
    {
        return $this->belongsTo(Location::class, 'idLocation', 'idLocation');
    }

    public function orderWarehouses()
    {
        return $this->hasMany(OrderWarehouse::class, 'idShelves', 'idShelves');
    }
}
