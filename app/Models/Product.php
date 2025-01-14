<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];



    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function product_variation()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? '<span class="text-success"> Published </span>' : '<span class="text-danger"> Drafted </span>';
    }

    public function categories(){
        return $this->hasMany(ProductCategory::class);
    }

    public function option(){
        return $this->hasMany(Option::class);
    }


    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function bestSellProduct(){
        return $this->hasOne(BestSellProduct::class);
    }
    public function featuredProduct(){
        return $this->hasOne(FeaturedProduct::class);
    }


    public function getMainThumbImageAttribute()
    {
        return $this->images->where('type', 'Thumbnail')->first() 
            ?? $this->images->where('type', 'Main Image')->first() 
            ?? $this->images->where('type', 'Extra Image')->first();
    }
    

}
