<!-- Unified Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand" href="{{ route('branchhub.landing') }}">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Branch Hub Logo" class="logo-img">
            <span class="orbitron-bold orbitron-text small">Branch Hub</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('branchhub.landing') ? 'active' : '' }}" 
                       href="{{ route('branchhub.landing') }}">
                        الرئيسية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('branchhub.landing') }}#about">
                        عنا
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('branchhub.landing') }}#plans">
                        خطط الحجز
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('branchhub.landing') }}#audience">
                        مثالي للعمل
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('branchhub.landing') }}#location">
                        الموقع
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.courses.*') ? 'active' : '' }}" 
                       href="{{ route('public.courses.index') }}">
                        الأكاديمية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('branchhub.landing') }}#contact">
                        تواصل معنا
                    </a>
                </li>
            </ul>
            
            <!-- Action Buttons (shown on landing page) -->
            @if(request()->routeIs('branchhub.landing'))
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">تسجيل الدخول</a>
                <a href="{{ route('booking.form') }}" class="btn btn-danger btn-sm">احجز مقعدك</a>
            </div>
            @endif
        </div>
    </div>
</nav>

<!-- Navbar JavaScript - Scroll Effect -->
<script>
    // Initialize navbar scroll effect
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar-custom');
        
        if (navbar) {
            // Add fixed navbar class to body
            document.body.classList.add('has-fixed-navbar');
            
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    
                    // Only handle same-page anchors
                    if (href !== '#' && !href.includes('://')) {
                        const target = document.querySelector(href.split('#')[1] ? '#' + href.split('#')[1] : href);
                        
                        if (target) {
                            e.preventDefault();
                            const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                            window.scrollTo({
                                top: offsetTop,
                                behavior: 'smooth'
                            });
                            
                            // Close mobile menu if open
                            const navbarCollapse = document.getElementById('navbarNav');
                            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                                const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                                    toggle: false
                                });
                                bsCollapse.hide();
                            }
                        }
                    }
                });
            });
        }
    });
</script>
