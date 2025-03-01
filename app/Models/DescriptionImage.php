<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescriptionImage extends Model
{
    use HasFactory;

    protected $table = 'description_image';

    protected $fillable = [
        'image',
        'article_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
