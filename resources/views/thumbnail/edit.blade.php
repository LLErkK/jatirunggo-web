<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Edit Thumbnail</h1>

        <form id="thumbnailForm" action="{{ route('thumbnails.update', $thumbnail->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="title" value="{{ $thumbnail->title }}" class="w-full border-gray-300 rounded p-2" required>
            </div>

            <!-- Caption -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Caption</label>
                <input type="text" name="caption" value="{{ $thumbnail->caption }}" class="w-full border-gray-300 rounded p-2" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded p-2" required>{{ $thumbnail->description }}</textarea>
            </div>

            <!-- Background Image Current -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Background Image Saat Ini</label>
                <img src="{{ asset('storage/' . $thumbnail->background_image) }}" class="max-w-md border mb-2">
                <p class="text-sm text-gray-600 mb-4">Upload gambar baru jika ingin mengubah (Rasio 16:9)</p>
                
                <input type="file" id="backgroundInput" accept="image/*" class="mb-2">
                <div id="backgroundPreview" class="hidden">
                    <img id="backgroundImage" style="max-width: 100%;">
                    <button type="button" onclick="cropBackground()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Crop Image</button>
                </div>
                <div id="backgroundResult" class="mt-4 hidden">
                    <p class="text-green-600 mb-2">✓ Background image baru sudah di-crop</p>
                    <img id="backgroundCropped" style="max-width: 400px; border: 2px solid #10b981;">
                </div>
                <input type="hidden" name="background_image_cropped" id="backgroundCroppedData">
            </div>

            <!-- Gambar Tambahan Current -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Tambahan Saat Ini</label>
                @if($thumbnail->images->count() > 0)
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        @foreach($thumbnail->images as $img)
                            <div class="border rounded p-2">
                                <img src="{{ asset('storage/' . $img->image) }}" class="w-full mb-2">
                                <label class="flex items-center text-sm">
                                    <input type="checkbox" name="remove_images[]" value="{{ $img->id }}" class="mr-2">
                                    Hapus gambar ini
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 mb-4">Belum ada gambar tambahan</p>
                @endif

                <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Gambar Baru (Rasio 4:3) - Opsional</label>
                <input type="file" id="additionalInput" accept="image/*" multiple class="mb-2">
                <div id="additionalPreview" class="hidden">
                    <img id="additionalImage" style="max-width: 100%;">
                    <button type="button" onclick="cropAdditional()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Crop Image</button>
                </div>
                <div id="additionalResults" class="mt-4 grid grid-cols-3 gap-4"></div>
                <input type="hidden" name="images_cropped" id="additionalCroppedData">
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('thumbnails.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>

    <!-- Cropper.js CSS & JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        let backgroundCropper = null;
        let additionalCropper = null;
        let additionalFiles = [];
        let currentAdditionalIndex = 0;
        let croppedAdditionalImages = [];

        // Background Image Handler
        document.getElementById('backgroundInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    e.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.getElementById('backgroundImage');
                    img.src = event.target.result;
                    document.getElementById('backgroundPreview').classList.remove('hidden');
                    document.getElementById('backgroundResult').classList.add('hidden');
                    
                    if (backgroundCropper) {
                        backgroundCropper.destroy();
                    }
                    
                    backgroundCropper = new Cropper(img, {
                        aspectRatio: 16 / 9,
                        viewMode: 1,
                        autoCropArea: 1,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        function cropBackground() {
            if (!backgroundCropper) return;

            const canvas = backgroundCropper.getCroppedCanvas({
                width: 1600,
                height: 900,
            });

            canvas.toBlob(function(blob) {
                const reader = new FileReader();
                reader.onloadend = function() {
                    document.getElementById('backgroundCroppedData').value = reader.result;
                    document.getElementById('backgroundCropped').src = reader.result;
                    document.getElementById('backgroundResult').classList.remove('hidden');
                    document.getElementById('backgroundPreview').classList.add('hidden');
                    
                    if (backgroundCropper) {
                        backgroundCropper.destroy();
                        backgroundCropper = null;
                    }
                };
                reader.readAsDataURL(blob);
            });
        }

        // Additional Images Handler
        document.getElementById('additionalInput').addEventListener('change', function(e) {
            additionalFiles = Array.from(e.target.files);
            croppedAdditionalImages = [];
            currentAdditionalIndex = 0;
            document.getElementById('additionalResults').innerHTML = '';
            
            if (additionalFiles.length > 0) {
                // Validasi ukuran
                for (let file of additionalFiles) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Setiap gambar maksimal 2MB!');
                        e.target.value = '';
                        additionalFiles = [];
                        return;
                    }
                }
                loadNextAdditionalImage();
            }
        });

        function loadNextAdditionalImage() {
            if (currentAdditionalIndex >= additionalFiles.length) {
                // Semua gambar sudah di-crop
                document.getElementById('additionalPreview').classList.add('hidden');
                document.getElementById('additionalCroppedData').value = JSON.stringify(croppedAdditionalImages);
                return;
            }

            const file = additionalFiles[currentAdditionalIndex];
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.getElementById('additionalImage');
                img.src = event.target.result;
                document.getElementById('additionalPreview').classList.remove('hidden');
                
                if (additionalCropper) {
                    additionalCropper.destroy();
                }
                
                additionalCropper = new Cropper(img, {
                    aspectRatio: 4 / 3,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        }

        function cropAdditional() {
            if (!additionalCropper) return;

            const canvas = additionalCropper.getCroppedCanvas({
                width: 800,
                height: 600,
            });

            canvas.toBlob(function(blob) {
                const reader = new FileReader();
                reader.onloadend = function() {
                    croppedAdditionalImages.push(reader.result);
                    
                    // Tampilkan hasil crop
                    const resultsDiv = document.getElementById('additionalResults');
                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'border-2 border-green-500 rounded p-2';
                    imgDiv.innerHTML = `
                        <img src="${reader.result}" class="w-full">
                        <p class="text-sm text-center mt-1">Gambar ${currentAdditionalIndex + 1}</p>
                    `;
                    resultsDiv.appendChild(imgDiv);
                    
                    // Lanjut ke gambar berikutnya
                    currentAdditionalIndex++;
                    
                    if (additionalCropper) {
                        additionalCropper.destroy();
                        additionalCropper = null;
                    }
                    
                    loadNextAdditionalImage();
                };
                reader.readAsDataURL(blob);
            });
        }
    </script>
</x-app-layout>