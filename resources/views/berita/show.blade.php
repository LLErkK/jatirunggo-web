<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<style>
/* Reset & Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background: #f8f9fa;
}

/* Breadcrumb */
.breadcrumb-container {
    background: white;
    border-bottom: 1px solid #e2e8f0;
    padding: 15px 0;
    margin-top: 80px;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #64748b;
    flex-wrap: wrap;
}

.breadcrumb a {
    color: #e67e22;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb a:hover {
    color: #d35400;
}

.breadcrumb .separator {
    color: #cbd5e1;
}

.breadcrumb .current {
    color: #2c3e50;
    font-weight: 500;
}

/* Main Container */
.berita-detail-wrapper {
    padding: 40px 0 60px;
}

.container-detail {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 40px;
}

/* Main Article */
.main-article {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.article-header {
    margin-bottom: 30px;
}

.article-category {
    display: inline-block;
    background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
    color: white;
    padding: 6px 18px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.article-title {
    font-size: 36px;
    font-weight: 800;
    color: #2c3e50;
    line-height: 1.3;
    margin-bottom: 20px;
}

.article-meta {
    display: flex;
    gap: 25px;
    padding: 15px 0;
    border-top: 2px solid #e2e8f0;
    border-bottom: 2px solid #e2e8f0;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #64748b;
}

.meta-item i {
    color: #e67e22;
    font-size: 16px;
}

/* Featured Image */
.featured-image-container {
    margin: 30px 0;
    border-radius: 12px;
    overflow: hidden;
}

.featured-image {
    width: 100%;
    height: auto;
    display: block;
    max-height: 500px;
    object-fit: cover;
}

.featured-image-container figcaption {
    padding: 12px;
    background: #f1f5f9;
    color: #64748b;
    font-size: 13px;
    font-style: italic;
    text-align: center;
}

/* Article Body */
.article-body {
    font-size: 17px;
    line-height: 1.8;
    color: #334155;
    margin: 30px 0;
}

.article-body p {
    margin-bottom: 20px;
    text-align: justify;
}

.article-body h2,
.article-body h3 {
    color: #2c3e50;
    margin-top: 30px;
    margin-bottom: 15px;
    font-weight: 700;
}

.article-body h2 {
    font-size: 28px;
}

.article-body h3 {
    font-size: 22px;
}

.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
}

.article-body ul,
.article-body ol {
    margin: 20px 0 20px 30px;
}

.article-body li {
    margin-bottom: 10px;
}

.article-body blockquote {
    border-left: 4px solid #e67e22;
    padding-left: 20px;
    margin: 25px 0;
    font-style: italic;
    color: #475569;
    background: #f8fafc;
    padding: 15px 20px;
    border-radius: 0 8px 8px 0;
}

/* Article Footer */
.article-footer {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #e2e8f0;
}

.share-section h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    color: #2c3e50;
    margin-bottom: 15px;
}

.share-section h4 i {
    color: #e67e22;
}

.share-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.share-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.share-btn.facebook {
    background: #1877f2;
    color: white;
}

.share-btn.twitter {
    background: #1da1f2;
    color: white;
}

.share-btn.whatsapp {
    background: #25d366;
    color: white;
}

.share-btn.copy {
    background: #64748b;
    color: white;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Sidebar */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.sidebar-widget {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.widget-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 20px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 3px solid #e67e22;
}

.widget-title i {
    color: #e67e22;
}

/* Latest Articles Widget */
.latest-articles {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.latest-article-item {
    display: flex;
    gap: 15px;
    text-decoration: none;
    color: inherit;
    padding: 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.latest-article-item:hover {
    background: #f8fafc;
    transform: translateX(5px);
}

.latest-article-image {
    flex-shrink: 0;
    width: 90px;
    height: 90px;
    border-radius: 8px;
    overflow: hidden;
}

.latest-article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.latest-article-content h4 {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.4;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.latest-article-date {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #64748b;
}

.latest-article-date i {
    color: #e67e22;
}

/* Categories Widget */
.categories-list {
    list-style: none;
}

.categories-list li {
    border-bottom: 1px solid #e2e8f0;
}

.categories-list li:last-child {
    border-bottom: none;
}

.categories-list a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    text-decoration: none;
    color: #475569;
    font-size: 15px;
    transition: all 0.3s ease;
}

.categories-list a:hover {
    color: #e67e22;
    padding-left: 8px;
}

.categories-list a i {
    font-size: 10px;
    color: #e67e22;
    margin-right: 10px;
}

.categories-list a span {
    background: #e2e8f0;
    color: #64748b;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 968px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .main-article {
        padding: 25px;
    }
    
    .article-title {
        font-size: 28px;
    }
    
    .article-meta {
        flex-wrap: wrap;
        gap: 15px;
    }
}

@media (max-width: 640px) {
    .breadcrumb-container {
        margin-top: 70px;
    }
    
    .main-article {
        padding: 20px;
    }
    
    .article-title {
        font-size: 24px;
    }
    
    .article-body {
        font-size: 16px;
    }
    
    .share-buttons {
        flex-direction: column;
    }
    
    .share-btn {
        width: 100%;
        justify-content: center;
    }
    
    .sidebar-widget {
        padding: 20px;
    }
}
</style>

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