<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'article_content' => 'required|string',
            'tipe'    => 'required|string',
            'image'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'content_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'title'   => $request->title,
            'article_content' => $request->article_content,
            'tipe'    => $request->tipe,
        ];

        // Upload gambar utama (thumbnail)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article = Article::create($data);

        // Upload gambar konten pelengkap (multiple)
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                $imagePath = $image->store('articles/content', 'public');
                $article->images()->create(['image' => $imagePath]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'article_content' => 'required|string',
            'tipe'    => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ]);

        $data = $request->only(['title', 'article_content', 'tipe']);

        // Update gambar utama jika ada upload baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        // Hapus gambar konten yang dipilih
        if ($request->remove_images) {
            $imagesToRemove = Article_images::whereIn('id', $request->remove_images)->get();
            foreach ($imagesToRemove as $img) {
                Storage::disk('public')->delete($img->image);
                $img->delete();
            }
        }

        // Upload gambar konten baru
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                $imagePath = $image->store('articles/content', 'public');
                $article->images()->create(['image' => $imagePath]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Hapus semua gambar konten
        foreach($article->images as $img){
            Storage::disk('public')->delete($img->image);
        }

        // Hapus gambar utama
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Display article for public view
     */
    public function publicShow($id)
    {
        $article = Article::with('images')->findOrFail($id);
        $otherArticles = Article::where('id', '!=', $id)->latest()->take(5)->get();

        return view('berita.show', compact('article', 'otherArticles'));
    }
}