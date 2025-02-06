<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryPincode extends Model
{
    //

    protected $fillable = [
        'pincode',
        'hub_code',
        'city',
        'fm',
        'lm',
        'cod',
        'province',
        'district',
        'latitude',
        'longitude',
        'state',
        'update_status'
    ];
}
