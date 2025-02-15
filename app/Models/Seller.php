<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    /** @use HasFactory<\Database\Factories\SellerFactory> */
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];



    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
