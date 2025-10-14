<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::with('thumbnail')->latest()->paginate(10);
        return view('photo.index', compact('photos'));
    }

    public function create()
    {
        $thumbnails = Thumbnail::all();
        return view('photo.create', compact('thumbnails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'thumbnail_id' => 'required|exists:thumbnails,id',
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:20000', // 20 MB
        ]);

        $path = $request->file('image')->store('photos', 'public');

        Photo::create([
            'thumbnail_id' => $request->thumbnail_id,
            'title' => $request->title,
            'caption' => $request->caption,
            'image' => $path,
        ]);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil ditambahkan!');
    }

    public function edit(Photo $photo)
    {
        $thumbnails = Thumbnail::all();
        return view('photo.edit', compact('photo', 'thumbnails'));
    }

    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'thumbnail_id' => 'required|exists:thumbnails,id',
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:20000', // 20 MB
        ]);

        $data = [
            'thumbnail_id' => $request->thumbnail_id,
            'title' => $request->title,
            'caption' => $request->caption,
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($photo->image);
            $data['image'] = $request->file('image')->store('photos', 'public');
        }

        $photo->update($data);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil diperbarui!');
    }

    public function destroy(Photo $photo)
    {
        if ($photo->image && Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Foto berhasil dihapus!');
    }
}
