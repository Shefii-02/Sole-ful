<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;


    public function address()
    {
        return $this->hasMany(OrderAddress::class);
    }


    public function basket()
    {
        return $this->hasOne('App\Models\Basket','id','basket_id');
    }
    

}
