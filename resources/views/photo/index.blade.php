<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Foto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-end mb-3">
                    <a href="{{ route('photos.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                       + Tambah Foto
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">No</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Judul</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Caption</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Gambar</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($photos as $photo)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $photo->title }}</td>
                                <td class="px-4 py-2">{{ Str::limit($photo->caption, 50) }}</td>
                                <td class="px-4 py-2">
                                    <img src="{{ asset('storage/' . $photo->image) }}" class="w-24 rounded shadow">
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('photos.edit', $photo->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                                    <form action="{{ route('photos.destroy', $photo->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-gray-500">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $photos->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
