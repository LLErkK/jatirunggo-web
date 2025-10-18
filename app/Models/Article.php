<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'article_content',
        'image',
        'tipe',
    ];

    public function images()
    {
        return $this->hasMany(Article_images::class,'article_id');
    }
}
