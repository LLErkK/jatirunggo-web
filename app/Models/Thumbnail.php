<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'caption',
        'description',
        'background_image',
    ];

    public function images()
    {
        return $this->hasMany(Thumbnail_images::class, 'thumbnail_id');
    }

    // Tambahkan relasi ke photos
    public function photos()
    {
        return $this->hasMany(Photo::class, 'thumbnail_id');
    }
}