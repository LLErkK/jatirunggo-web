<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ Str::limit(strip_tags($article->article_content), 160) }}">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->article_content), 160) }}">
    <meta property="og:image" content="{{ asset('storage/' . $article->image) }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <title>{{ $article->title }} - PTPN I Regional 3 Kebun Ngobo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/style.css'])
    @vite(['resources/css/article.css'])
    
    <style>
        /* Additional styles for article content images */
        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: block;
        }

        .article-body figure {
            margin: 2rem 0;
        }

        .article-body figure img {
            margin: 0;
        }

        .article-body figcaption {
            text-align: center;
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
            font-style: italic;
        }

        /* Responsive images in content */
        @media (max-width: 768px) {
            .article-body img {
                margin: 1rem 0;
            }
        }

        /* Image gallery style if multiple images */
        .article-body .image-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .article-body .image-row img {
            margin: 0;
        }

        /* Loading state */
        .article-body img[loading="lazy"] {
            background: #f0f0f0;
        }

        /* Lightbox effect on hover */
        .article-body img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .article-body img:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        /* Content Images Gallery Section */
        .content-images-section {
            margin: 2rem 0;
            padding: 2rem;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .content-images-section h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .content-image-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .content-image-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .content-image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        /* Image Modal/Lightbox */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            align-items: center;
            justify-content: center;
        }

        .image-modal.active {
            display: flex;
        }

        .image-modal img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            box-shadow: 0 0 40px rgba(255, 255, 255, 0.1);
        }

        .image-modal-close {
            position: absolute;
            top: 20px;
            right: 40px;
            font-size: 40px;
            color: white;
            cursor: pointer;
            transition: color 0.3s;
        }

        .image-modal-close:hover {
            color: #ddd;
        }
    </style>
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
                    </div>
                </div>

                <!-- Featured Image (Thumbnail) -->
                @if($article->image)
                <figure class="featured-image-container">
                    <img src="{{ asset('storage/' . $article->image) }}" 
                         alt="{{ $article->title }}" 
                         class="featured-image"
                         loading="eager">
                    <figcaption>{{ $article->title }}</figcaption>
                </figure>
                @endif

                <!-- Article Content -->
                <div class="article-body">
                    {!! $article->article_content !!}
                </div>

                <!-- Content Images Gallery (if exists) -->
                @if($article->images && $article->images->count() > 0)
                <div class="content-images-section">
                    <h3>
                        <i class="fas fa-images"></i>
                        Galeri Foto ({{ $article->images->count() }})
                    </h3>
                    <div class="content-images-grid">
                        @foreach($article->images as $index => $img)
                        <div class="content-image-item" onclick="openImageModal('{{ asset('storage/' . $img->image) }}')">
                            <img src="{{ asset('storage/' . $img->image) }}" 
                                 alt="Gambar {{ $index + 1 }}"
                                 loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Article Footer -->
                <div class="article-footer">
                    <div class="share-section">
                        <h4><i class="fas fa-share-alt"></i> Bagikan Artikel</h4>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" 
                               class="share-btn facebook"
                               rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" 
                               target="_blank" 
                               class="share-btn twitter"
                               rel="noopener noreferrer">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" 
                               target="_blank" 
                               class="share-btn whatsapp"
                               rel="noopener noreferrer">
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
                        @forelse($otherArticles as $other)
                        <a href="{{ route('berita.show', $other->id) }}" class="latest-article-item">
                            @if($other->image)
                            <div class="latest-article-image">
                                <img src="{{ asset('storage/' . $other->image) }}" 
                                     alt="{{ $other->title }}"
                                     loading="lazy">
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
                        @empty
                        <p style="text-align: center; color: #999; padding: 1rem;">
                            Belum ada artikel lain
                        </p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>

<!-- Image Modal/Lightbox -->
<div class="image-modal" id="imageModal" onclick="closeImageModal()">
    <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
    <img src="" alt="Preview" id="modalImage">
</div>

@include('layouts.footer')

<script>
// Copy Link Function
function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        // Create toast notification
        const toast = document.createElement('div');
        toast.textContent = '✓ Link berhasil disalin!';
        toast.style.cssText = 'position:fixed;bottom:20px;right:20px;background:#10b981;color:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.1);z-index:10000;animation:slideIn 0.3s ease;';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }).catch(() => {
        alert('Gagal menyalin link');
    });
}

// Image Modal Functions
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    modal.classList.add('active');
    modalImg.src = imageSrc;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Make article content images clickable for lightbox
document.addEventListener('DOMContentLoaded', function() {
    const articleImages = document.querySelectorAll('.article-body img');
    articleImages.forEach(img => {
        // Skip if already in gallery section
        if (!img.closest('.content-images-section')) {
            img.style.cursor = 'pointer';
            img.addEventListener('click', function() {
                openImageModal(this.src);
            });
        }
    });
});
</script>

</body>
</html>