<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = ['supplierName','ImageName','supplierSlug','phone','address','gmail', 'description'];
    protected $primaryKey = 'idSupplier';
    protected $table = 'supplier';

    // public function product(){
    //     return $this->hasMany('App\Models\Product');
    // }
}
