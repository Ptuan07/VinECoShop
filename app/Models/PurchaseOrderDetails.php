<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetails extends Model
{
    use HasFactory;
    protected $table = 'purchaseorderdetails';
    protected $primaryKey = 'idDetails';
    protected $fillable = ['idPurchaseOrder ','idProduct  ','expiryDate','quantity', 'unitPrice', 'idWareHouse ','idLocation ','idShelves ','description'];

    public function purchasrorder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'idPurchaseOrder');
    }

    public function orderWarehouses()
    {
        return $this->hasMany(OrderWarehouse::class, 'idDetails', 'idDetails');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProduct', 'idProduct');
    }
}
