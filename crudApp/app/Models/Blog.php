<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // laravel assume que as tabelas sao plural se colocar singular tem que fazer isso 
    protected $table = "blog";
    
    protected $fillable = [
    "title",
    "description",
    "banner_image",
    "user_id"
    ];
}
