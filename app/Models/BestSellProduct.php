<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestSellProduct extends Model
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory;

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
