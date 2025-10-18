<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Artikel') }}
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

                <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="w-full border border-gray-300 rounded-lg p-2" value="{{ old('title', $article->title) }}" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Tipe <span class="text-red-500">*</span></label>
                        <input type="text" name="tipe" class="w-full border border-gray-300 rounded-lg p-2" value="{{ old('tipe', $article->tipe) }}" required>
                        <p class="text-sm text-gray-500 mt-1">Contoh: Berita, Kegiatan, Pengumuman, dll</p>
                        @error('tipe')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">📸 Gambar Utama / Thumbnail</label>
                        @if($article->image)
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border">
                                <p class="text-sm text-gray-600 mb-2 font-medium">Gambar saat ini:</p>
                                <img src="{{ asset('storage/' . $article->image) }}" class="h-40 rounded border shadow" alt="Current thumbnail">
                            </div>
                        @endif
                        <p class="text-sm text-gray-600 mb-2">Upload gambar baru untuk mengganti thumbnail</p>
                        <input type="file" name="image" id="mainImage" class="w-full border border-gray-300 rounded-lg p-2" accept="image/*">
                        
                        <!-- Preview Gambar Baru -->
                        <div id="mainImagePreview" class="mt-3 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview gambar baru:</p>
                            <img id="previewImg" src="" class="h-40 rounded border shadow">
                        </div>
                        
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Isi Artikel <span class="text-red-500">*</span></label>
                        <textarea id="editor" name="article_content" rows="10" class="w-full border border-gray-300 rounded-lg p-2" required>{!! old('article_content', $article->article_content) !!}</textarea>
                        @error('article_content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Existing Content Images -->
                    @if($article->images && $article->images->count() > 0)
                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            🖼️ Gambar Pelengkap yang Ada ({{ $article->images->count() }} gambar)
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($article->images as $img)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $img->image) }}" 
                                         class="w-full h-32 object-cover rounded border shadow-sm">
                                    <div class="absolute top-2 right-2">
                                        <label class="flex items-center bg-red-500 text-white px-2 py-1 rounded cursor-pointer hover:bg-red-600 shadow-lg transition">
                                            <input type="checkbox" name="remove_images[]" value="{{ $img->id }}" class="mr-1">
                                            <span class="text-xs font-medium">🗑️ Hapus</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-600 mt-3">
                                ℹ️ Centang gambar yang ingin dihapus
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Add New Content Images -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            ➕ Tambah Gambar Pelengkap Baru (Opsional)
                        </label>
                        <p class="text-sm text-gray-600 mb-2">Upload foto-foto tambahan untuk melengkapi artikel</p>
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                            <input type="file" 
                                   name="content_images[]" 
                                   id="contentImages" 
                                   class="hidden" 
                                   accept="image/*" 
                                   multiple
                                   onchange="previewContentImages(this)">
                            
                            <label for="contentImages" class="cursor-pointer">
                                <div class="text-gray-400 mb-2">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <p class="text-gray-600">Klik untuk upload gambar baru</p>
                                <p class="text-sm text-gray-500 mt-1">atau drag & drop gambar disini</p>
                                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max: 2MB per gambar)</p>
                            </label>
                        </div>

                        <!-- Preview Grid for New Images -->
                        <div id="contentImagesPreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden"></div>
                        
                        @error('content_images')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('articles.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                            ← Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            💾 Update Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CKEditor Script --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        let editorInstance;

        // Preview Gambar Utama Baru
        document.getElementById('mainImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('previewImg').src = event.target.result;
                    document.getElementById('mainImagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Preview Content Images
        function previewContentImages(input) {
            const previewContainer = document.getElementById('contentImagesPreview');
            previewContainer.innerHTML = '';
            
            if (input.files && input.files.length > 0) {
                previewContainer.classList.remove('hidden');
                
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded border shadow">
                            <div class="absolute top-2 right-2">
                                <button type="button" 
                                        onclick="removeNewImage(${index})" 
                                        class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 shadow-lg">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            <div class="absolute bottom-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                                Baru ${index + 1}
                            </div>
                        `;
                        previewContainer.appendChild(div);
                    }
                    
                    reader.readAsDataURL(file);
                });
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        // Remove New Image
        function removeNewImage(index) {
            const input = document.getElementById('contentImages');
            const dt = new DataTransfer();
            
            Array.from(input.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            
            input.files = dt.files;
            previewContentImages(input);
        }

        // Drag & Drop
        const dropZone = document.querySelector('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-blue-400', 'bg-blue-50');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-blue-400', 'bg-blue-50');
            });
        });

        dropZone.addEventListener('drop', function(e) {
            const input = document.getElementById('contentImages');
            input.files = e.dataTransfer.files;
            previewContentImages(input);
        });

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            })
            .then(editor => {
                editorInstance = editor;
                console.log('✅ CKEditor loaded');
            })
            .catch(error => {
                console.error('❌ CKEditor error:', error);
            });

        // Handle form submit
        document.querySelector('#editForm').addEventListener('submit', function(e) {
            if (editorInstance) {
                const data = editorInstance.getData();
                document.querySelector('#editor').value = data;
                console.log('✅ Form updating...');
            }
        });
    </script>
</x-app-layout>