<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Foto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('photo.form')

                    <div class="mt-4">
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                            Update
                        </button>
                        <a href="{{ route('photos.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
