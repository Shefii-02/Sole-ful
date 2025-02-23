<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Myaddress extends Model
{
    //
    protected $fillable = ['user_id','name','email','mobile','address','pincode','locality','state','country','base'];
}
