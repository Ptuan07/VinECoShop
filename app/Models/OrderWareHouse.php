<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWareHouse extends Model
{
    use HasFactory;
    protected $table = 'order_warehouse';

    protected $primaryKey = 'idOrderWarehouse';
    protected $fillable = [
        'idDetails',
        'idWareHouse',
        'idLocation',
        'idShelves',
    ];

    // Quan hệ với PurchaseOrderDetail
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'idWareHouse', 'idWareHouse');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'idLocation', 'idLocation');
    }

    public function shelves()
    {
        return $this->belongsTo(Shelves::class, 'idShelves', 'idShelves');
    }

    public function purchaseOrderDetail()
    {
        return $this->belongsTo(PurchaseOrderDetails::class, 'idDetails', 'idDetails');
    }
}
