<?php

namespace App\Models;

use App\Casts\SafeContent;
use App\Enums\BaseStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Advertisement extends Model
{
    protected $table = 'advertisement';


    protected $fillable = [
        'image',
        'redirection',
        'status',
        'order',
    ];

    
}
