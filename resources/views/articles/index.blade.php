<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Artikel') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-green-600 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-end mb-4">
                    <a href="{{ route('articles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        + Tambah Artikel
                    </a>
                </div>

                <table class="min-w-full border text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border">No</th>
                            <th class="px-3 py-2 border">Judul</th>
                            <th class="px-3 py-2 border">Tipe</th>
                            <th class="px-3 py-2 border">Gambar</th>
                            <th class="px-3 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articles as $article)
                            <tr>
                                <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-3 py-2">{{ $article->title }}</td>
                                <td class="border px-3 py-2">{{ $article->tipe }}</td>
                                <td class="border px-3 py-2">
                                    @if ($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}" class="h-16 rounded">
                                    @else
                                        <em>Tidak ada</em>
                                    @endif
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:underline">Lihat</a> |
                                    <a href="{{ route('articles.edit', $article->id) }}" class="text-yellow-600 hover:underline">Edit</a> |
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-gray-500">Belum ada artikel</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
