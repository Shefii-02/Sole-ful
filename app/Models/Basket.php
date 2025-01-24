<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Basket extends Model
{
    /** @use HasFactory<\Database\Factories\BasketFactory> */
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];



    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
