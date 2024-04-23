<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;
     protected $fillable = [
        'postion',
        'emp_name',
        'details',
        'image',
    ];
}
