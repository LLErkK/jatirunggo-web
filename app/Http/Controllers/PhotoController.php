<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Tampilkan daftar foto.
     */
    public function index()
    {
        // Tampilkan semua foto dengan thumbnail-nya
        $photos = Photo::with('thumbnail')->latest()->paginate(10);
        return view('photo.index', compact('photos'));
    }

    /**
     * Tampilkan form tambah foto.
     */
    public function create()
    {
        // Ambil semua thumbnail untuk dropdown
        $thumbnails = Thumbnail::all();
        return view('photo.create', compact('thumbnails'));
    }

    /**
     * Simpan foto baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'thumbnail_id' => 'required|exists:thumbnails,id',
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload file ke storage/public/photos
        $path = $request->file('image')->store('photos', 'public');

        Photo::create([
            'thumbnail_id' => $request->thumbnail_id,
            'title' => $request->title,
            'caption' => $request->caption,
            'image' => $path,
        ]);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit foto.
     */
    public function edit(Photo $photo)
    {
        $thumbnails = Thumbnail::all();
        return view('photo.edit', compact('photo', 'thumbnails'));
    }

    /**
     * Update data foto.
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'thumbnail_id' => 'required|exists:thumbnails,id',
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'thumbnail_id' => $request->thumbnail_id,
            'title' => $request->title,
            'caption' => $request->caption,
        ];

        // Jika ada gambar baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($photo->image);
            $data['image'] = $request->file('image')->store('photos', 'public');
        }

        $photo->update($data);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil diperbarui!');
    }

    /**
     * Hapus foto.
     */
    public function destroy(Photo $photo)
    {
        if ($photo->image && Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Foto berhasil dihapus!');
    }
}
