<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $fillable = ['code','value','value_type','max_count','cur_count','min_sales','start_time','end_time','availability','min_sale','status'];

    
}
