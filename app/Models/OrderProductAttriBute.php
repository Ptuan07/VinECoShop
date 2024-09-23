<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductAttriBute extends Model
{
    public $timestamp = false;
    public $incrementing = false;
    protected $fillable = ['idProduct','idDetails','idAttrValue','Quantity', 'Price'];
    protected $primaryKey = ['idProAttr'];
    protected $table = 'order_product_attribute';
}
