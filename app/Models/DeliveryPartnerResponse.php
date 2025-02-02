<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPartnerResponse extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'order_id',
        'dp_order_id',
        'shipper_order_id',
        'awb_number',
        'c_awb_number',
    ];
}
