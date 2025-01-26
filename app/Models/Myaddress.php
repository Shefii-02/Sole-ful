<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Myaddress extends Model
{
    //
    protected $fillable = ['user_id','name','address','postalcode','city','province','country','base'];
}
