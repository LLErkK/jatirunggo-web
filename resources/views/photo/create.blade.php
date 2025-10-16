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
                        @error('thumbnail_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Judul -->
                    <div class="mb-4">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" required>
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Caption -->
                    <div class="mb-4">
                        <label>Caption</label>
                        <textarea name="caption" class="form-control" required></textarea>
                        @error('caption')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Gambar -->
                    <div class="mb-4">
                        <label>Upload Gambar (maksimal 2 MB)</label>
                        <input type="file" id="imageInput" accept="image/*" class="form-control" required>
                        <input type="hidden" name="image" id="croppedImage">
                        <p class="text-gray-500 text-sm mt-1">Format: JPG, JPEG, PNG — Maksimal 2 MB</p>
                        <p id="fileError" class="text-red-600 text-sm mt-1" style="display:none;">Ukuran file melebihi 2 MB!</p>
                        @error('image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Area Preview & Crop -->
                    <div class="mb-4">
                        <img id="imagePreview" style="max-width:100%; display:none;" />
                    </div>

                    <!-- Tombol Simpan -->
                    <button type="submit" id="submitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded" disabled>
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
        const fileError = document.getElementById('fileError');
        const form = document.getElementById('photo-form');
        const submitBtn = document.getElementById('submitBtn');
        const hiddenInput = document.getElementById('croppedImage');

        imageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            // 🚫 Batasi ukuran 2 MB
            if (file.size > 2 * 1024 * 1024) {
                fileError.style.display = 'block';
                imageInput.value = '';
                imagePreview.style.display = 'none';
                if (cropper) cropper.destroy();
                submitBtn.disabled = true;
                return;
            } else {
                fileError.style.display = 'none';
            }

            // 🖼️ Preview & aktifkan cropper
            const reader = new FileReader();
            reader.onload = function (event) {
                imagePreview.src = event.target.result;
                imagePreview.style.display = 'block';
                if (cropper) cropper.destroy();

                cropper = new Cropper(imagePreview, {
                    aspectRatio: 4 / 3,
                    viewMode: 1,
                    autoCropArea: 1,
                    ready() {
                        submitBtn.disabled = false;
                    }
                });
            };
            reader.readAsDataURL(file);
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!cropper) {
                alert('Silakan upload dan crop foto terlebih dahulu.');
                return;
            }

            // 🪄 Crop jadi Blob
            cropper.getCroppedCanvas().toBlob(function (blob) {
                if (blob.size > 2 * 1024 * 1024) {
                    alert('Hasil crop melebihi 2 MB, crop ulang lebih kecil.');
                    return;
                }

                // Ubah blob ke Base64 agar bisa dikirim via hidden input
                const reader = new FileReader();
                reader.onloadend = function () {
                    hiddenInput.value = reader.result;
                    form.submit();
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg', 0.9);
        });
    </script>
</x-app-layout>
