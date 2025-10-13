<x-app-layout>
    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Tambah Thumbnail</h2>

        <form action="{{ route('thumbnails.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded p-6">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-2">Judul</label>
                <input type="text" name="title" class="w-full border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">Caption</label>
                <textarea name="caption" class="w-full border-gray-300 rounded" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">Gambar (bisa lebih dari satu)</label>
                <input type="file" name="images[]" multiple class="w-full border-gray-300 rounded">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
                <a href="{{ route('thumbnails.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
</x-app-layout>
