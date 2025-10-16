<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <article class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
            <p class="text-gray-500 mb-2">Dipublikasikan pada {{ $article->created_at->format('d F Y') }}</p>
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-96 object-cover rounded-lg mb-6">
            <div class="prose max-w-none text-gray-800">
                {!! $article->content !!}
            </div>
        </article>

        <!-- Artikel Lainnya -->
        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-4">Artikel Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($otherArticles as $other)
                    <a href="{{ route('articles.detail', $other->id) }}" class="block bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
                        <img src="{{ asset('storage/' . $other->image) }}" alt="{{ $other->title }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2">{{ $other->title }}</h3>
                            <p class="text-gray-600 text-sm">{{ Str::limit(strip_tags($other->content), 80) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
