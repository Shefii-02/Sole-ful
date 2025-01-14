<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    /** @use HasFactory<\Database\Factories\SizeFactory> */
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];



    protected $fillable = ['size_value','size_code','display_order'];

    
    	
    

}
