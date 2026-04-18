<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    protected $fillable = [
        "name",
        "email",
        "gender"
    ];
}
