<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $thumbnail->title }} - PTPN I Regional 3 Kebun Ngobo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/komoditas.css'])
   
</head>
<body>
    <!-- Header -->
    <header id="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div class="logo-title" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ Vite::asset('resources/images/ptpni.png') }}" alt="Logo PTPN I" style="height: 50px;">
                <h1>PTPN I Regional 3 Kebun Ngobo</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    @foreach($thumbnails as $thumb)
                        <li class="{{ $thumbnail->id == $thumb->id ? 'active' : '' }}">
                            <a href="{{ route('komoditas.show', $thumb->id) }}">
                                {{ $thumb->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>
<!-- Hero Section -->
<section class="hero" 
         @if($thumbnail->background_image)
             style="background-image: url('{{ asset('storage/' . $thumbnail->background_image) }}'); 
                    background-size: cover; 
                    background-position: center; 
                    background-repeat: no-repeat;"
         @endif
>
    <div class="container" style="padding: 80px 20px; color: white; text-shadow: 1px 1px 5px rgba(0,0,0,0.7);">
        <h2 class="text-4xl font-bold mb-4">{{ $thumbnail->title }}</h2>
        <p class="text-lg">{{ $thumbnail->description }}</p>
    </div>
</section>



    <!-- Content Sections -->
    @foreach($thumbnail->photos as $index => $photo)
        <section id="{{ Str::slug($photo->title) }}" class="content-section">
            <div class="tahap" style="flex-direction: {{ $index % 2 == 0 ? 'row' : 'row-reverse' }};">
                <div class="tahap-img">
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
                </div>
                <div class="tahap-text">
                    <h3>{{ $index + 1 }}. {{ $photo->title }}</h3>
                    <p>{{ $photo->caption }}</p>
                </div>
            </div>
        </section>
    @endforeach

    <!-- Footer -->
    <div style="width: 100%; margin-top: 50px;">
        @include('layouts.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll untuk anchor # di halaman ini
            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', function(e){
                    const href = this.getAttribute('href');
                    const target = document.querySelector(href);
                    if(target){
                        e.preventDefault();
                        target.scrollIntoView({behavior: 'smooth'});
                    }
                });
            });
        });
    </script>
</body>
</html>
