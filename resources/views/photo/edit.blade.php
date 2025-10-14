<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Foto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="photo-form" action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Pilih Thumbnail -->
                    <div class="mb-4">
                        <label for="thumbnail_id" class="block text-sm font-medium text-gray-700">Pilih Thumbnail</label>
                        <select name="thumbnail_id" id="thumbnail_id" class="form-control" required>
                            <option value="">-- Pilih Thumbnail --</option>
                            @foreach ($thumbnails as $thumb)
                                <option value="{{ $thumb->id }}" {{ $photo->thumbnail_id == $thumb->id ? 'selected' : '' }}>
                                    {{ $thumb->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Judul -->
                    <div class="mb-4">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ $photo->title }}" required>
                    </div>

                    <!-- Caption -->
                    <div class="mb-4">
                        <label>Caption</label>
                        <textarea name="caption" class="form-control" required>{{ $photo->caption }}</textarea>
                    </div>

                    <!-- Upload Gambar & Cropper -->
                    <div class="mb-4">
                        <label>Upload Gambar Baru (opsional)</label>
                        <input type="file" id="imageInput" accept="image/*" class="form-control">
                    </div>

                    <!-- Preview / Crop -->
                    <div class="mb-4">
                        <img id="imagePreview" src="{{ asset('storage/' . $photo->image) }}" style="max-width:100%;" />
                    </div>

                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        Update
                    </button>
                    <a href="{{ route('photos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Kembali
                    </a>
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

                if (cropper) cropper.destroy();
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 3 / 4,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        });

        form.addEventListener('submit', function(e) {
            // Hanya lakukan crop jika user upload file baru
            if (imageInput.files.length > 0 && cropper) {
                e.preventDefault();

                cropper.getCroppedCanvas().toBlob(function(blob) {
                    const formData = new FormData(form);

                    // hapus input file asli
                    formData.delete('image');
                    // tambahkan blob crop
                    formData.append('image', blob, 'cropped.jpg');

                    // kirim via fetch
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                        }
                    })
                    .then(res => {
                        if(res.ok) {
                            alert('Foto berhasil diperbarui!');
                            window.location.reload();
                        } else {
                            alert('Gagal update foto');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan');
                    });
                });
            }
        });
    </script>
</x-app-layout>
