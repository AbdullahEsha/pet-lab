<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    protected $table = 'managements';
    
    protected $fillable = [
        'role',
        'committee',
        'emp_name',
        'details',
        'image'
    ];
}
