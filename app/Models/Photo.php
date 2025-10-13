<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['thumbnail_id', 'title', 'caption', 'image'];

    public function thumbnail()
    {
        return $this->belongsTo(Thumbnail::class);
    }
}
