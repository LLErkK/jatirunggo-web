<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Artikel') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium">Judul</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg" value="{{ old('title', $article->title) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Isi Artikel</label>
                        <textarea id="editor" name="article_content" rows="6" class="w-full border-gray-300 rounded-lg" required>{{ old('article_content', $article->article_content) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tipe</label>
                        <input type="text" name="tipe" class="w-full border-gray-300 rounded-lg" value="{{ old('tipe', $article->tipe) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Gambar</label>
                        @if($article->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $article->image) }}" class="h-32 rounded">
                            </div>
                        @endif
                        <input type="file" name="image" class="w-full border-gray-300 rounded-lg" accept="image/*">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('articles.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">Kembali</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tambahkan CKEditor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
    </script>
</x-app-layout>
