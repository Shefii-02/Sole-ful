<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use HasFactory;



    public function variationkey() {
        return $this->hasMany('App\Models\VariationKey','variation_id','id');
    } 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function images()
    {
        return $this->belongsToMany(ProductImage::class, 'variation_images', 'variation_id', 'picture_id');
    }

    public function variationImages()
    {
        return $this->belongsTo(VariationImage::class);
    }
}
