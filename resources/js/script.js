// script.js - Complete JavaScript untuk Landing Page

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // 1. NAVBAR HIDE ON SCROLL
    // ============================================
    let prevScrollPos = window.pageYOffset;
    const navbar = document.getElementById("navbar");

    if (navbar) {
        window.addEventListener("scroll", function () {
            const currentScrollPos = window.pageYOffset;
            if (prevScrollPos > currentScrollPos) {
                navbar.style.top = "0";
            } else {
                navbar.style.top = "-100px";
            }
            prevScrollPos = currentScrollPos;
        });
    }

    // ============================================
    // 2. SCROLLSPY - ACTIVE NAVBAR
    // ============================================
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('nav ul li a');

    function updateActiveNav() {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 120;
            const sectionHeight = section.offsetHeight;
            
            if (window.pageYOffset >= sectionTop && 
                window.pageYOffset < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    }

    // Jalankan saat scroll
    if (sections.length > 0 && navLinks.length > 0) {
        window.addEventListener('scroll', updateActiveNav);
        updateActiveNav(); // Jalankan sekali saat load
    }

    // ============================================
    // 3. SMOOTH SCROLL NAVIGATION
    // ============================================
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                const offsetTop = targetSection.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });

                // Update active state setelah scroll
                setTimeout(() => {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }, 100);
            }
        });
    });

    // ============================================
    // 4. FADE IN EFFECT ON SCROLL
    // ============================================
    const fadeElements = document.querySelectorAll('.fade-in');

    if (fadeElements.length > 0) {
        const fadeObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        fadeObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.2 }
        );

        fadeElements.forEach((el) => fadeObserver.observe(el));
    }

    // ============================================
    // 5. LOKASI SECTION ANIMATION
    // ============================================
    const lokasiSection = document.querySelector('.lokasi');

    if (lokasiSection) {
        const lokasiObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        lokasiSection.classList.add('show');
                    }
                });
            },
            { threshold: 0.3 }
        );

        lokasiObserver.observe(lokasiSection);
    }

    // ============================================
    // 6. IMAGE TOGGLE (untuk halaman dengan .tahap)
    // ============================================
    const images = document.querySelectorAll('.image-toggle');

    images.forEach(image => {
        image.addEventListener('click', () => {
            const content = image.closest('.tahap').querySelector('.toggle-content');
            if (content) {
                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                } else {
                    content.style.display = 'none';
                }
            }
        });
    });

    // ============================================
    // 7. HAMBURGER MENU (Mobile Menu Toggle)
    // ============================================
    const hamburger = document.getElementById('hamburger');
    const navbarMenu = document.getElementById('navbar-menu');

    if (hamburger && navbarMenu) {
        hamburger.addEventListener('click', function() {
            navbarMenu.style.display = (navbarMenu.style.display === 'block') ? 'none' : 'block';
        });
    }

});