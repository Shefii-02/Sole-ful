<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;
    protected $fillable = ['code','value','value_type','max_count','cur_count','min_sales','start_time','end_time','availability','min_sale','status'];

    
}
