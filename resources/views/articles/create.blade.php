<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Artikel') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Judul</label>
                        <input type="text" name="title" class="w-full border border-gray-300 rounded-lg p-2" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Isi Artikel</label>
                        <textarea id="editor" name="article_content" rows="6" class="w-full border border-gray-300 rounded-lg p-2">{{ old('article_content') }}</textarea>
                        @error('article_content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Tipe</label>
                        <input type="text" name="tipe" class="w-full border border-gray-300 rounded-lg p-2" value="{{ old('tipe') }}" required>
                        @error('tipe')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Gambar (opsional)</label>
                        <input type="file" name="image" class="w-full border border-gray-300 rounded-lg p-2" accept="image/*">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('articles.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">Kembali</a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CKEditor Script --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        let editorInstance;

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editorInstance = editor;
                console.log('✅ CKEditor loaded');
            })
            .catch(error => {
                console.error('❌ CKEditor error:', error);
            });

        // Handle form submit - sync CKEditor data to textarea
        document.querySelector('#articleForm').addEventListener('submit', function(e) {
            console.log('📝 Form submitting...');
            
            if (editorInstance) {
                // Get data from CKEditor
                const data = editorInstance.getData();
                
                // Set to hidden textarea
                document.querySelector('#editor').value = data;
                
                console.log('✅ Editor data synced:', data.substring(0, 50) + '...');
            } else {
                console.warn('⚠️ Editor not initialized yet');
            }
        });
    </script>
</x-app-layout>