<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    
    protected $fillable = [
        'title',
        'image',
        'description',
        'category',
        'sub_category',
        'description_image',
        'is_public',
    ];
}
