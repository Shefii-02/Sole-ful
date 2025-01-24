<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;


    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function product_variation(){
        return $this->hasOne(ProductVariant::class,'id','product_variation_id');
    }
    

}
