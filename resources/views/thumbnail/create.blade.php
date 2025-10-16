<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah Thumbnail Baru</h1>

        <form action="{{ route('thumbnails.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Judul -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="title" class="w-full border-gray-300 rounded p-2" required>
            </div>

            <!-- Caption -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Caption</label>
                <input type="text" name="caption" class="w-full border-gray-300 rounded p-2" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded p-2" required></textarea>
            </div>

            <!-- Background Image -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Background Image (maks 2MB)</label>
                <input type="file" name="background_image" accept="image/*" class="w-full border-gray-300 rounded p-2" required onchange="validateFileSize(this)">
            </div>

            <!-- Gambar Tambahan -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Gambar Tambahan (bisa lebih dari satu, maks 2MB per gambar)</label>
                <input type="file" name="images[]" accept="image/*" class="w-full border-gray-300 rounded p-2" multiple onchange="validateMultipleFileSize(this)">
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>

    <script>
    function validateFileSize(input) {
        const file = input.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            alert("Ukuran file maksimal 2MB!");
            input.value = "";
        }
    }

    function validateMultipleFileSize(input) {
        for (let i = 0; i < input.files.length; i++) {
            if (input.files[i].size > 5 * 1024 * 1024) {
                alert("Setiap gambar maksimal 2MB!");
                input.value = "";
                break;
            }
        }
    }
    </script>
</x-app-layout>
