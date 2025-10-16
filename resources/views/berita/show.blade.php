<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $article->title }}">
    <title>{{ $article->title }} - PTPN I Regional 3 Kebun Ngobo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/style.css'])
    @vite(['resources/css/article.css'])
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
                <li><a href="/#komoditas">Komoditas</a></li>
                <li><a href="/#tentang">Tentang Kami</a></li>
                <li><a href="/#lokasi">Lokasi</a></li>
                <li><a href="/#kontak">Kontak</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Breadcrumb -->
<div class="breadcrumb-container">
    <div class="container-detail">
        <nav class="breadcrumb">
            <a href="/"><i class="fas fa-home"></i> Beranda</a>
            <span class="separator">/</span>
            <a href="/#artikel">Artikel</a>
            <span class="separator">/</span>
            <span class="current">{{ Str::limit($article->title, 50) }}</span>
        </nav>
    </div>
</div>

<main class="berita-detail-wrapper">
    <div class="container-detail">
        <div class="content-grid">
            <!-- Main Article Content -->
            <article class="main-article">
                <!-- Article Header -->
                <div class="article-header">
                    <span class="article-category">{{ strtoupper($article->tipe) }}</span>
                    <h1 class="article-title">{{ $article->title }}</h1>
                    
                    <div class="article-meta">
                        <div class="meta-item">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ $article->created_at->format('d F Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="far fa-clock"></i>
                            <span>{{ $article->created_at->format('H:i') }} WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="far fa-eye"></i>
                            <span>{{ rand(100, 999) }} views</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($article->image)
                <figure class="featured-image-container">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="featured-image">
                    <figcaption>{{ $article->title }}</figcaption>
                </figure>
                @endif

                <!-- Article Content -->
                <div class="article-body">
                    {!! $article->article_content !!}
                </div>

                <!-- Article Footer -->
                <div class="article-footer">
                    <div class="share-section">
                        <h4><i class="fas fa-share-alt"></i> Bagikan Artikel</h4>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" class="share-btn twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" class="share-btn whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button onclick="copyLink()" class="share-btn copy">
                                <i class="fas fa-link"></i> Salin Link
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="sidebar">
                <!-- Latest Articles -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">
                        <i class="fas fa-newspaper"></i>
                        Kegiatan Terbaru
                    </h3>
                    <div class="latest-articles">
                        @foreach($otherArticles as $other)
                        <a href="{{ route('berita.show', $other->id) }}" class="latest-article-item">
                            @if($other->image)
                            <div class="latest-article-image">
                                <img src="{{ asset('storage/' . $other->image) }}" alt="{{ $other->title }}">
                            </div>
                            @endif
                            <div class="latest-article-content">
                                <h4>{{ Str::limit($other->title, 60) }}</h4>
                                <p class="latest-article-date">
                                    <i class="far fa-calendar"></i>
                                    {{ $other->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </aside>
        </div>
    </div>
</main>

@include('layouts.footer')



<script>
function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Link berhasil disalin!');
    }).catch(() => {
        alert('Gagal menyalin link');
    });
}
</script>

</body>
</html>