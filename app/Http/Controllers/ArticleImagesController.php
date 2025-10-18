<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class ArticleImagesController extends Controller
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'image'
    ];
    public function article()
    {
        return $this->belongsTo(Article::class,'article_id');
    }
}
