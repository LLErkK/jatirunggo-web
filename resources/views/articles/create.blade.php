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
                        <label class="block font-medium mb-2">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="title" class="w-full border border-gray-300 rounded-lg p-2" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Tipe <span class="text-red-500">*</span></label>
                        <input type="text" name="tipe" class="w-full border border-gray-300 rounded-lg p-2" value="{{ old('tipe') }}" required>
                        <p class="text-sm text-gray-500 mt-1">Contoh: Berita, Kegiatan, Pengumuman, dll</p>
                        @error('tipe')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            📸 Gambar Utama / Thumbnail <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-2">Gambar ini akan ditampilkan sebagai cover/thumbnail artikel</p>
                        <input type="file" name="image" id="mainImage" class="w-full border border-gray-300 rounded-lg p-2" accept="image/*" required>
                        
                        <!-- Preview Gambar Utama -->
                        <div id="mainImagePreview" class="mt-3 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img id="previewImg" src="" class="h-40 rounded border shadow">
                        </div>
                        
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Isi Artikel <span class="text-red-500">*</span></label>
                        <textarea id="editor" name="article_content" rows="6" class="w-full border border-gray-300 rounded-lg p-2">{{ old('article_content') }}</textarea>
                        @error('article_content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            🖼️ Gambar Pelengkap Konten (Opsional)
                        </label>
                        <p class="text-sm text-gray-600 mb-2">Upload foto-foto tambahan untuk melengkapi artikel (bisa lebih dari 1)</p>
                        
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
                                <p class="text-gray-600">Klik untuk upload gambar</p>
                                <p class="text-sm text-gray-500 mt-1">atau drag & drop gambar disini</p>
                                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Max: 2MB per gambar)</p>
                            </label>
                        </div>

                        <!-- Preview Grid -->
                        <div id="contentImagesPreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden"></div>
                        
                        @error('content_images')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('articles.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                            ← Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            💾 Simpan Artikel
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

        // Jalankan setelah DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 DOM Ready, initializing...');

            // Preview Gambar Utama
            const mainImageInput = document.getElementById('mainImage');
            if (mainImageInput) {
                mainImageInput.addEventListener('change', function(e) {
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
            }

            // Drag & Drop Setup
            const dropZone = document.querySelector('.border-dashed');
            if (dropZone) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }, false);
                });

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
                    if (input) {
                        input.files = e.dataTransfer.files;
                        previewContentImages(input);
                    }
                });
            }

            // Initialize CKEditor
            const editorElement = document.querySelector('#editor');
            if (editorElement) {
                ClassicEditor
                    .create(editorElement, {
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
            }

            // FORM SUBMIT HANDLER
            const form = document.getElementById('articleForm');
            if (form) {
                console.log('✅ Form found, registering submit handler');
                
                form.addEventListener('submit', function(e) {
                    console.log('🔥 SUBMIT CLICKED!');
                    
                    // Sync CKEditor jika ada
                    if (editorInstance) {
                        try {
                            const data = editorInstance.getData();
                            const editorTextarea = document.querySelector('#editor');
                            editorTextarea.value = data;
                            console.log('✅ CKEditor synced');
                            
                            // Validasi konten tidak kosong
                            if (!data.trim() || data.trim() === '<p>&nbsp;</p>' || data.trim() === '<p></p>') {
                                e.preventDefault();
                                alert('⚠️ Isi artikel tidak boleh kosong!');
                                return false;
                            }
                        } catch (err) {
                            console.error('⚠️ CKEditor sync error:', err);
                        }
                    }
                    
                    // Log form data untuk debug
                    const formData = new FormData(form);
                    console.log('📦 Form data:');
                    for (let [key, value] of formData.entries()) {
                        if (value instanceof File) {
                            console.log(key + ':', value.name);
                        } else {
                            console.log(key + ':', value.substring(0, 50));
                        }
                    }
                    
                    // Biarkan form submit secara normal
                    console.log('✅ Submitting form...');
                    return true;
                });
                
                console.log('✅ Submit handler registered');
            } else {
                console.error('❌ Form not found!');
            }
        });

        // Preview Content Images - Global function
        function previewContentImages(input) {
            const previewContainer = document.getElementById('contentImagesPreview');
            if (!previewContainer) return;
            
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
                                        onclick="removeImage(${index})" 
                                        class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 shadow-lg">
                                    ×
                                </button>
                            </div>
                            <div class="absolute bottom-2 left-2 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded">
                                ${index + 1}
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

        // Remove Image - Global function
        function removeImage(index) {
            const input = document.getElementById('contentImages');
            if (!input) return;
            
            const dt = new DataTransfer();
            
            Array.from(input.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            
            input.files = dt.files;
            previewContentImages(input);
        }
    </script>
</x-app-layout>