<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Edit Thumbnail</h2>

        <form action="{{ route('thumbnail.update', $thumbnail->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-2">Judul</label>
                <input type="text" name="title" value="{{ $thumbnail->title }}" class="w-full border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">Caption</label>
                <textarea name="caption" class="w-full border-gray-300 rounded" required>{{ $thumbnail->caption }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block font-medium mb-2">Gambar Saat Ini</label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($thumbnail->images as $img)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-32 object-cover rounded">
                            <label class="absolute top-1 right-1 bg-white bg-opacity-70 rounded p-1 text-sm">
                                <input type="checkbox" name="remove_images[]" value="{{ $img->id }}"> Hapus
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">Tambah Gambar Baru (opsional)</label>
                <input type="file" name="images[]" multiple class="w-full border-gray-300 rounded">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui</button>
                <a href="{{ route('thumbnail.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
</x-app-layout>
