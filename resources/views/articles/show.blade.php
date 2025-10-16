<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <p class="text-gray-500 mb-3">Tipe: {{ $article->tipe }}</p>

                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" class="rounded-lg mb-4 max-h-96">
                @endif

                <p class="text-gray-700 whitespace-pre-line">{{ $article->article_content }}</p>

                <div class="mt-6">
                    <a href="{{ route('articles.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
