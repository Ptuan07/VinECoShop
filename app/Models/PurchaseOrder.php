<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'purchaseorder';
    protected $primaryKey = 'idPurchaseOrder';
    protected $fillable = ['idPurchaseOrder ','idSupplier ','orderDate','receiveDate', 'totalPrice', 'createdBy','updatedBy','status','description'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'idSupplier', 'idSupplier');
    }
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'createdBy', 'idAdmin');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updatedBy', 'idAdmin');
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseOrderDetails::class, 'idDetails');
    }
}
