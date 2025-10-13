<?php

namespace App\Http\Controllers;

use App\Models\Thumbnail;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $thumbnails = Thumbnail::latest()->get();
        return view('landing', compact('thumbnails'));
    }
}
