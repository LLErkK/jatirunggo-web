<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumbnail_images extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumbnail_id',
        'image',
    ];

    public function thumbnail()
    {
        return $this->belongsTo(Thumbnail::class, 'thumbnail_id');
    }
}
