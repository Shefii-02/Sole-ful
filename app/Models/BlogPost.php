<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    /** @use HasFactory<\Database\Factories\BlogPostFactory> */
    use HasFactory;

    function getstatusHtmlAttribute(){
        return $this->status == 1 ? 'Active' : 'In active';
    }

    function category(){
        return $this->hasOne(BlogCategory::class, 'id', 'category_id');
    }
}
