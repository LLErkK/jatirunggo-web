<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Background Image -->
        @if($thumbnail->background_image)
            <div class="mb-4">
                <h3 class="text-lg font-medium mb-2">Background Image</h3>
                <div class="rounded overflow-hidden border">
                    <img src="{{ asset('storage/' . $thumbnail->background_image) }}" class="w-full h-64 object-cover">
                </div>
            </div>
        @endif

        <!-- Title -->
        <div class="mb-4">
            <h3 class="text-lg font-medium mb-1">Title</h3>
            <p class="text-gray-800">{{ $thumbnail->title }}</p>
        </div>

        <!-- Caption -->
        <div class="mb-4">
            <h3 class="text-lg font-medium mb-1">Caption</h3>
            <p class="text-gray-700">{{ $thumbnail->caption }}</p>
        </div>

        <!-- Description -->
        @if($thumbnail->description)
            <div class="mb-4">
                <h3 class="text-lg font-medium mb-1">Description</h3>
                <p class="text-gray-700">{{ $thumbnail->description }}</p>
            </div>
        @endif

        <!-- Gambar tambahan -->
        @if($thumbnail->images->count() > 0)
            <div class="mb-4">
                <h3 class="text-lg font-medium mb-2">Additional Images</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($thumbnail->images as $img)
                        <div class="border rounded overflow-hidden">
                            <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-48 object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tombol kembali -->
        <a href="{{ route('thumbnails.index') }}" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Kembali</a>
    </div>
</x-app-layout>
