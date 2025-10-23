<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'image' => 'required|string', // base64 string dari cropper.js
        ]);

        // 🔹 Simpan gambar base64 ke storage
        $path = $this->saveBase64Image($request->image, 'photos');

        // 🔹 Simpan ke database
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
            'image' => 'nullable|string', // base64 string (optional)
        ]);

        $data = [
            'thumbnail_id' => $request->thumbnail_id,
            'title' => $request->title,
            'caption' => $request->caption,
        ];

        // Jika user mengganti gambar
        if (!empty($request->image)) {
            // Hapus file lama jika ada
            if ($photo->image && Storage::disk('public')->exists($photo->image)) {
                Storage::disk('public')->delete($photo->image);
            }

            $data['image'] = $this->saveBase64Image($request->image, 'photos');
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

    /**
     * 🧠 Helper untuk menyimpan gambar base64 ke storage/public
     */
    private function saveBase64Image(string $base64Data, string $directory): string
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
            $extension = strtolower($type[1]); // jpg, jpeg, png
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            $base64Data = str_replace(' ', '+', $base64Data);
            $imageData = base64_decode($base64Data);

            if ($imageData === false) {
                throw new \Exception('Gagal decode gambar base64');
            }

            $fileName = Str::uuid() . '.' . $extension;
            $filePath = $directory . '/' . $fileName;

            Storage::disk('public')->put($filePath, $imageData);

            return $filePath;
        }

        throw new \Exception('Format gambar base64 tidak valid');
    }
}
