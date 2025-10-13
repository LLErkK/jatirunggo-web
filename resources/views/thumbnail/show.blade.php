<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-4">{{ $thumbnail->title }}</h2>
        <p class="text-gray-700 mb-6">{{ $thumbnail->caption }}</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($thumbnail->images as $img)
                <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-48 object-cover rounded">
            @endforeach
        </div>

        <a href="{{ route('thumbnails.index') }}" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Kembali</a>
    </div>
</x-app-layout>
