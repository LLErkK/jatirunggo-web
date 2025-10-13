<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Daftar Thumbnail</h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('thumbnails.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
            + Tambah Thumbnail
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($thumbnails as $thumb)
                <div class="bg-white rounded-lg shadow p-4">
                    @if ($thumb->images->count())
                        <img src="{{ asset('storage/' . $thumb->images->first()->image) }}" class="w-full h-48 object-cover rounded mb-3">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded mb-3 text-gray-500">Tidak ada gambar</div>
                    @endif

                    <h3 class="text-lg font-semibold">{{ $thumb->title }}</h3>
                    <p class="text-gray-600 mb-3">{{ $thumb->caption }}</p>

                    <div class="flex gap-2">
                        <a href="{{ route('thumbnails.show', $thumb->id) }}" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 text-sm">Lihat</a>
                        <a href="{{ route('thumbnails.edit', $thumb->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">Edit</a>

                        <form action="{{ route('thumbnails.destroy', $thumb->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
