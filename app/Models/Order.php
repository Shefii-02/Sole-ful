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

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type','billing');
    }

    public function deliveryAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type','delivery');
    }


    public function DeliveryPartnerResponse(){
        return $this->hasOne(DeliveryPartnerResponse::class);
    }

    
    public function payments()
    {
        return $this->hasOne(Payment::class);
    }

    public function basket()
    {
        return $this->hasOne('App\Models\Basket','id','basket_id');
    }
    

}
