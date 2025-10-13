<?php

namespace App\Http\Controllers;

use App\Models\Thumbnail;
use App\Models\Thumbnail_images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThumbnailsController extends Controller
{
    public function index(){
        $thumbnails = Thumbnail::with('images')->latest()->get();
         return view('thumbnail.index', compact('thumbnails'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $thumbnail = Thumbnail::create([
            'title' => $request->title,
            'caption' => $request->caption,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('thumbnails', 'public');
                $thumbnail->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('thumbnails.index')->with('success', 'Thumbnail berhasil dibuat!');

    }

    public function show(Thumbnail $thumbnail)
    {
        $thumbnail->load('images');
        return view('thumbnail.show', compact('thumbnail'));
    }

     public function destroy(Thumbnail $thumbnail)
    {
        // Hapus semua file gambar di storage
        foreach ($thumbnail->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        // Hapus dari database
        $thumbnail->delete();

        return redirect()->route('thumbnails.index')->with('success', 'Thumbnail berhasil dihapus!');
    }

    public function edit(Thumbnail $thumbnail)
{
    $thumbnail->load('images');
    return view('thumbnail.edit', compact('thumbnail'));
}

public function create()
{
    return view('thumbnail.create');
}

/**
 * Update data thumbnail dan gambar-gambarnya.
 */
public function update(Request $request, Thumbnail $thumbnail)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'caption' => 'required|string',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'remove_images' => 'array',
        'remove_images.*' => 'integer',
    ]);

    // Update title dan caption
    $thumbnail->update([
        'title' => $request->title,
        'caption' => $request->caption,
    ]);

    // Hapus gambar yang dipilih untuk dihapus
    if ($request->has('remove_images')) {
        $imagesToRemove = Thumbnail_images::whereIn('id', $request->remove_images)->get();

        foreach ($imagesToRemove as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }
    }

    // Tambahkan gambar baru (jika ada)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('thumbnail', 'public');
            $thumbnail->images()->create(['image' => $path]);
        }
    }

    return redirect()->route('thumbnail.show', $thumbnail->id)
                     ->with('success', 'Thumbnail berhasil diperbarui!');
}
}
