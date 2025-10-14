<?php

namespace App\Http\Controllers;

use App\Models\Thumbnail;
use Illuminate\Http\Request;

class KomoditasController extends Controller
{
    public function show(Thumbnail $thumbnail)
    {
        // Load photos yang terkait dengan thumbnail
        $thumbnail->load('photos');
        
        // Load semua thumbnails untuk navbar
        $thumbnails = Thumbnail::with('photos')->get();
        
        return view('komoditas', compact('thumbnail', 'thumbnails'));
    }
}