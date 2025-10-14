<?php

namespace App\Http\Controllers;

use App\Models\Thumbnail;
use App\Models\Thumbnail_images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThumbnailsController extends Controller
{
    public function index()
    {
        $thumbnails = Thumbnail::with('images')->latest()->get();
        return view('thumbnail.index', compact('thumbnails'));
    }

    public function create()
    {
        return view('thumbnail.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'description' => 'required|string',
            'background_image_cropped' => 'required|string',
            'images_cropped' => 'nullable|string', // JSON array base64
        ]);

        $thumbnailData = [
            'title' => $request->title,
            'caption' => $request->caption,
            'description' => $request->description,
        ];

        // Simpan background image (16:9)
        if ($request->background_image_cropped) {
            $bg = $request->background_image_cropped;
            $bg = preg_replace('/^data:image\/\w+;base64,/', '', $bg);
            $bg = str_replace(' ', '+', $bg);
            $bgName = 'thumbnails/' . uniqid() . '.png';
            Storage::disk('public')->put($bgName, base64_decode($bg));
            $thumbnailData['background_image'] = $bgName;
        }

        $thumbnail = Thumbnail::create($thumbnailData);

        // Simpan gambar tambahan (4:3)
        if ($request->images_cropped) {
            $imagesBase64 = json_decode($request->images_cropped, true); // array of base64
            foreach ($imagesBase64 as $imgBase64) {
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $imgBase64);
                $img = str_replace(' ', '+', $img);
                $imgName = 'thumbnails/' . uniqid() . '.png';
                Storage::disk('public')->put($imgName, base64_decode($img));
                $thumbnail->images()->create(['image' => $imgName]);
            }
        }

        return redirect()->route('thumbnails.index')->with('success', 'Thumbnail berhasil dibuat!');
    }

    public function show(Thumbnail $thumbnail)
    {
        $thumbnail->load('images');
        return view('thumbnail.show', compact('thumbnail'));
    }

    public function edit(Thumbnail $thumbnail)
    {
        $thumbnail->load('images');
        return view('thumbnail.edit', compact('thumbnail'));
    }

    public function update(Request $request, Thumbnail $thumbnail)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'description' => 'required|string',
            'background_image_cropped' => 'nullable|string',
            'images_cropped' => 'nullable|string', // JSON array base64
            'remove_images' => 'array',
            'remove_images.*' => 'integer',
        ]);

        $thumbnailData = [
            'title' => $request->title,
            'caption' => $request->caption,
            'description' => $request->description,
        ];

        // Update background image jika ada
        if ($request->background_image_cropped) {
            if ($thumbnail->background_image) {
                Storage::disk('public')->delete($thumbnail->background_image);
            }
            $bg = preg_replace('/^data:image\/\w+;base64,/', '', $request->background_image_cropped);
            $bg = str_replace(' ', '+', $bg);
            $bgName = 'thumbnails/' . uniqid() . '.png';
            Storage::disk('public')->put($bgName, base64_decode($bg));
            $thumbnailData['background_image'] = $bgName;
        }

        $thumbnail->update($thumbnailData);

        // Hapus gambar yang dipilih
        if ($request->remove_images) {
            $imagesToRemove = Thumbnail_images::whereIn('id', $request->remove_images)->get();
            foreach ($imagesToRemove as $img) {
                Storage::disk('public')->delete($img->image);
                $img->delete();
            }
        }

        // Tambah gambar baru (4:3)
        if ($request->images_cropped) {
            $imagesBase64 = json_decode($request->images_cropped, true);
            foreach ($imagesBase64 as $imgBase64) {
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $imgBase64);
                $img = str_replace(' ', '+', $img);
                $imgName = 'thumbnails/' . uniqid() . '.png';
                Storage::disk('public')->put($imgName, base64_decode($img));
                $thumbnail->images()->create(['image' => $imgName]);
            }
        }

        return redirect()->route('thumbnails.show', $thumbnail->id)
                         ->with('success', 'Thumbnail berhasil diperbarui!');
    }

    public function destroy(Thumbnail $thumbnail)
    {
        // Hapus semua file gambar di storage
        foreach ($thumbnail->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        if ($thumbnail->background_image) {
            Storage::disk('public')->delete($thumbnail->background_image);
        }

        $thumbnail->delete();

        return redirect()->route('thumbnails.index')->with('success', 'Thumbnail berhasil dihapus!');
    }
}
