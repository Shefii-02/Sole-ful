<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 'response_msg',
        'merchantOrderId',
        'basket_id',
        'order_id',
        'transaction_id',
        'reference_id',
        'payment_status',
        'processing_at',
        'amount',
        'payment_method',
        'utr',
        'card_type',
        'arn',
        'pg_authorization_code',
        'pg_transaction_id',
        'bank_transaction_id',
        'bank_id',
        'pg_service_transaction_id'
    ];
}
