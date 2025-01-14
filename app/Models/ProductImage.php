<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory;

    function variation_image() {
        return $this->hasMany('App\Models\VariationImage','picture_id');
    }
    function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
