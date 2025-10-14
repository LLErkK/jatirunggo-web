<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="PTPN I Regional 3 Kebun Ngobo - Perkebunan karet, lokasi, kontak, dan informasi lengkap.">
    <title>PTPN I Regional 3 Kebun Ngobo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/style.css'])
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
                    <li><a href="#home" class="active">Beranda</a></li>
                    <li><a href="#komoditas">Komoditas</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#lokasi">Lokasi</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Beranda -->
    <section id="home" class="hero">
        <div class="container">
            <div class="visi-misi-wrapper">
                <!-- Visi -->
                <div class="visi-section">
                    <h2>Visi</h2>
                    <p>"Menjadi perusahaan agribisnis nasional yang tangguh dan berdaya saing kelas dunia serta berkontribusi secara berkesinambungan bagi kemajuan bangsa".</p>
                </div>

                <!-- Misi -->
                <div class="misi-section">
                    <h2>Misi</h2>
                    <p>Menghasilkan produk yang berkualitas tinggi bagi pelanggan.</p>
                    <p>Membentuk kapabilitas proses kerja yang unggul melalui perbaikan dan inovasi berkelanjutan dengan tata kelola perusahaan yang baik.</p>
                    <p>Mengembangkan organisasi dan budaya yang prima serta SDM yang kompeten dan sejahtera dalam merealisasi potensi setiap insani.</p>
                    <p>Melakukan optimalisasi pemanfaatan aset untuk memberikan imbal hasil terbaik.</p>
                    <p>Turut serta dalam meningkatkan kesejahteraan masyarakat dan menjaga kelestarian lingkungan untuk kebaikan generasi masa depan.</p>
                </div>
            </div>
        </div>
    </section>

<!-- Update bagian komoditas di resources/views/landing.blade.php -->

<section id="komoditas" class="komoditas">
    <h2>Komoditas</h2>

    <div class="grid">
        @foreach ($thumbnails as $thumbnail)
            <a href="{{ route('komoditas.show', $thumbnail->id) }}" class="card-link">
                <div class="card">
                    <h3>{{ $thumbnail->title }}</h3>
                    <p>{{ $thumbnail->caption }}</p>

                    <div class="image-grid">
                        @foreach ($thumbnail->images->take(4) as $img)
                            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $thumbnail->title }}">
                        @endforeach
                    </div>
                    
                
                </div>
            </a>
        @endforeach
    </div>
</section>
    <!-- Tentang Kami -->
    <section id="tentang" class="tentang fade-in">
        <div class="container">
            <h2>Tentang Kami</h2>
            <p>Terletak di kawasan Desa Wringin Putih, Kecamatan Bergas, Kabupaten Semarang, Jawa Tengah, Kebun Ngobo 
                merupakan salah satu unit usaha milik PT Perkebunan Nusantara I (PTPN I) Regional 3, sebuah perusahaan BUMN yang 
                bergerak di bidang perkebunan dan pengolahan hasil agrikultur seperti karet, kopi, teh, dan gula. 
                PTPN I berdiri sejak tahun 1996 melalui penggabungan beberapa perusahaan perkebunan negara, dan berkantor pusat di Semarang.
            </p>    

            <p>
                Kebun Ngobo dikelola sebagai unit kebun yang fokus pada budidaya komoditas seperti karet dan kopi. 
                Berdasarkan informasi dari PTPN I Regional 3, kebun ini merupakan bagian dari lokasi operasional utama perusahaan 
                di wilayah Jawa Tengah khususnya kedekatannya dengan Getas dan Jollong.
            </p>

            <p>
                Selain fungsi agrikultur, PTPN I Regional 3 juga mengembangkan kawasan Kebun Ngobo sebagai bagian dari agrowisata, 
                selaras dengan konsep agrotourism yang dikembangkan di lokasi-lokasi seperti Kampoeng Kopi Banaran. 
            </p>
        </div>
    </section>

    <!-- Lokasi -->
    <section id="lokasi" class="lokasi">
        <div class="container">
            <h2>Lokasi</h2>
            <div class="map-wrapper"> 
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.6746066578103!2d110.44439919999999!3d-7.163564500000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7085c42197150d%3A0x36364c0e39150e3a!2sKantor%20Induk%20PTPN%20IX%20Kebun%20Ngobo!5e0!3m2!1sid!2sid!4v1757379249724!5m2!1sid!2sid" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="kontak">
        <div class="container">
            <h2>Kontak Kami</h2>
            <div class="kontak-info">
                <p><i class="fas fa-envelope"></i> <a href="mailto:ngobo.ptpn09@gmail.com">ngobo.ptpn09@gmail.com</a></p>
                <p><i class="fas fa-phone"></i> <a href="tel:+62298522658">(0298) 522 658</a></p>
                <p><i class="fab fa-facebook"></i> <a href="https://www.facebook.com/share/14K4JYwAQ1U/" target="_blank">Kebun Ngobo PTPN 9</a></p>
                <p><i class="fab fa-instagram"></i> <a href="https://www.instagram.com/kebunngobo.ptpn1reg3/" target="_blank">@kebunngobo.ptpn1reg3</a></p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <div style="width: 100%; border: none; margin-top: 50px;">
        @include('layouts.footer')
    </div>

    <script src="@vite(['resources/js/script.js'])"></script>
</body>
</html>