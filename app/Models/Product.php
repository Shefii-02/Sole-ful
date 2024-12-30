<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public function seller()
{
    return $this->belongsTo(Seller::class);
}

public function variants()
{
    return $this->hasMany(ProductVariant::class);
}

    
}
