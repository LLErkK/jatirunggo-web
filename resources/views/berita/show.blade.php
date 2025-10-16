<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ $article->title }}">
    <title>{{ $article->title }} - PTPN I Regional 3 Kebun Ngobo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/style.css'])
</head>
<body>

<header id="navbar">
    <div class="container">
        <div class="logo-title">
            <img src="{{ Vite::asset('resources/images/ptpni.png') }}" alt="Logo PTPN I">
            <h1>PTPN I Regional 3 Kebun Ngobo</h1>
        </div>
        <nav>
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="#komoditas">Komoditas</a></li>
                <li><a href="#tentang">Tentang Kami</a></li>
                <li><a href="#lokasi">Lokasi</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container berita-detail">
    <article class="berita-content">
        <h2 class="judul-berita">{{ $article->title }}</h2>
        <p class="meta">Tipe: {{ strtoupper($article->tipe) }} | {{ $article->created_at->format('d F Y') }}</p>

        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="featured-image">
        @endif

        <div class="isi-berita">
            {!! $article->article_content !!}
        </div>
    </article>

    <aside class="berita-lainnya">
        <h3>Berita Lainnya</h3>
        @foreach($otherArticles as $other)
            <a href="{{ route('berita.show', $other->id) }}" class="berita-item">
                @if($other->image)
                    <img src="{{ asset('storage/' . $other->image) }}" alt="{{ $other->title }}">
                @endif
                <div>
                    <h4>{{ $other->title }}</h4>
                    <p>{{ Str::limit(strip_tags($other->article_content), 60) }}</p>
                </div>
            </a>
        @endforeach
    </aside>
</main>

@include('layouts.footer')

<style>
.container {
    max-width: 1000px;
    margin: 40px auto;
    display: flex;
    gap: 30px;
}
.berita-content {
    flex: 3;
}
.berita-content img.featured-image {
    width: 100%;
    border-radius: 10px;
    margin: 20px 0;
}
.isi-berita {
    line-height: 1.8;
    text-align: justify;
}
.berita-lainnya {
    flex: 1;
}
.berita-lainnya .berita-item {
    display: flex;
    gap: 10px;
    text-decoration: none;
    color: black;
    margin-bottom: 15px;
}
.berita-lainnya .berita-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}
</style>

</body>
</html>
