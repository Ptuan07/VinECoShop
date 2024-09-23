<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = ['bannerName','ImageName','description'];
    protected $primaryKey = 'idBanner';
    protected $table = 'banner';

    // public function product(){
    //     return $this->hasMany('App\Models\Product');
    // }
}
