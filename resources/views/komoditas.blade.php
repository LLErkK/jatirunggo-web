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
        <div class="container">
            <div class="logo-title">
                <img src="{{ Vite::asset('resources/images/ptpni.png') }}" alt="Logo PTPN I">
                <h1>PTPN I Regional 3 Kebun Ngobo</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    @foreach($thumbnails as $thumb)
                        <li class="{{ $thumb->photos->isNotEmpty() ? 'dropdown' : '' }}">
                            <a href="{{ route('komoditas.show', $thumb->id) }}" 
                               class="{{ $thumbnail->id == $thumb->id ? 'active' : '' }}">
                                {{ $thumb->title }}
                            </a>
                            
                            @if($thumb->photos->isNotEmpty() && $thumbnail->id == $thumb->id)
                                <ul class="dropdown-content">
                                    @foreach($thumb->photos as $photo)
                                        <li>
                                            <a href="#{{ Str::slug($photo->title) }}">{{ $photo->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>{{ $thumbnail->title }}</h2>
            <p>{{ $thumbnail->caption }}</p>
        </div>
    </section>

    <!-- Content Sections -->
    @foreach($thumbnail->photos as $index => $photo)
        <section id="{{ Str::slug($photo->title) }}" class="content-section">
            <div class="tahap">
                @if($index % 2 == 0)
                    <!-- Image Left -->
                    <div class="tahap-img">
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
                    </div>
                    <div class="tahap-text">
                        <h3>{{ $index + 1 }}. {{ $photo->title }}</h3>
                        <p>{{ $photo->caption }}</p>
                    </div>
                @else
                    <!-- Image Right -->
                    <div class="tahap-text">
                        <h3>{{ $index + 1 }}. {{ $photo->title }}</h3>
                        <p>{{ $photo->caption }}</p>
                    </div>
                    <div class="tahap-img">
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
                    </div>
                @endif
            </div>
        </section>
    @endforeach

    <!-- Footer -->
    <div style="width: 100%; border: none; margin-top: 50px;">
        @include('layouts.footer')
    </div>

    <script src="@vite(['resources/js/script.js'])"></script>
</body>
</html>