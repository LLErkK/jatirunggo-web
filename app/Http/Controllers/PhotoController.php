<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Tampilkan daftar foto.
     */
    public function index()
    {
        $photos = Photo::latest()->paginate(10);
        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Tampilkan form tambah foto.
     */
    public function create()
    {
        return view('admin.photos.create');
    }

    /**
     * Simpan foto baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tema' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload file ke storage/public/photos
        $path = $request->file('image')->store('photos', 'public');

        Photo::create([
            'tema' => $request->tema,
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
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Update data foto.
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'tema' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'tema' => $request->tema,
            'title' => $request->title,
            'caption' => $request->caption,
        ];

        // Jika ada gambar baru, hapus yang lama
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
        Storage::disk('public')->delete($photo->image);
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Foto berhasil dihapus!');
    }
}
