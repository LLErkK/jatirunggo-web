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

                    <!-- Preview & Crop -->
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
                    aspectRatio: 4 / 3,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        });

        form.addEventListener('submit', function(e) {
            if (!cropper) return;

            e.preventDefault();

            // Crop & kompres menjadi JPEG kualitas 0.7
            cropper.getCroppedCanvas().toBlob(function(blob) {
                const formData = new FormData(form);

                formData.delete('image');
                formData.append('image', blob, 'cropped.jpg');

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert('Foto berhasil disimpan!');
                        window.location.href = "{{ route('photos.index') }}";
                    } else {
                        alert('Gagal menyimpan foto.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan.');
                });
            }, 'image/jpeg', 0.7); // 70% quality
        });
    </script>
</x-app-layout>
