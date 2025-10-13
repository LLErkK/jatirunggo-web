<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Foto
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="thumbnail_id" class="block text-sm font-medium text-gray-700">Pilih Thumbnail</label>
                        <select name="thumbnail_id" id="thumbnail_id" class="form-control" required>
                            <option value="">-- Pilih Thumbnail --</option>
                            @foreach ($thumbnails as $thumbnail)
                                <option value="{{ $thumbnail->id }}">{{ $thumbnail->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label>Caption</label>
                        <textarea name="caption" class="form-control" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label>Upload Gambar</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
