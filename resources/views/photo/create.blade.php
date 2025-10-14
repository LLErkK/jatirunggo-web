<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Foto
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form id="photo-form" action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Pilih Thumbnail -->
                    <div class="mb-4">
                        <label for="thumbnail_id" class="block text-sm font-medium text-gray-700">Pilih Thumbnail</label>
                        <select name="thumbnail_id" id="thumbnail_id" class="form-control" required>
                            <option value="">-- Pilih Thumbnail --</option>
                            @foreach ($thumbnails as $thumbnail)
                                <option value="{{ $thumbnail->id }}">{{ $thumbnail->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Judul -->
                    <div class="mb-4">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <!-- Caption -->
                    <div class="mb-4">
                        <label>Caption</label>
                        <textarea name="caption" class="form-control" required></textarea>
                    </div>

                    <!-- Upload Gambar & Cropper -->
                    <div class="mb-4">
                        <label>Upload Gambar</label>
                        <input type="file" id="imageInput" accept="image/*" class="form-control" required>
                    </div>

                    <!-- Tempat preview & crop -->
                    <div class="mb-4">
                        <img id="imagePreview" style="max-width: 100%; display: none;">
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Cropper.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        let cropper;
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const form = document.getElementById('photo-form');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                imagePreview.style.display = 'block';

                if (cropper) cropper.destroy();
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 4/3, // rasio 4:3
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        });

        form.addEventListener('submit', function(e) {
            if (!cropper) return; // fallback: submit normal jika cropper tidak aktif

            e.preventDefault(); // hentikan submit default

            cropper.getCroppedCanvas().toBlob(function(blob) {
                // Buat file baru dari blob hasil crop
                const dt = new DataTransfer();
                dt.items.add(new File([blob], 'cropped.jpg', { type: 'image/jpeg' }));

                // Ganti file input asli dengan hasil crop
                imageInput.files = dt.files;

                // Submit form normal
                form.submit();
            }, 'image/jpeg', 0.9); // kualitas JPEG 90%
        });
    </script>
</x-app-layout>
