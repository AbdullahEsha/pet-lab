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
        'description_image',
        'category',
        'sub_category',
        'is_public',
    ];

    // Define the relationship with the DescriptionImage model
    // in the description_image table, the article_id column is used to store the id of the article that the image is associated with
    public function descriptionImages()
    {
        return $this->hasMany(DescriptionImage::class);
    }
}
