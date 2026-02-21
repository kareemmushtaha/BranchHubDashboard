<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Branch Hub - مساحة العمل المثالية في قطاع غزة')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'مساحة العمل المثالية في قطاع غزة - Branch Hub')">
    <meta name="keywords" content="@yield('meta_keywords', 'مساحة عمل, قطاع غزة, branch hub, coworking')">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">

    <!-- Font Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&family=Tektur:wght@400..900&display=swap" rel="stylesheet">

    <!-- Navbar CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Base Styles -->
    <style>
        * {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }

        :root {
            --primary-color: #1a1a1a;
            --accent-red: #dc2626;
            --accent-white: #ffffff;
            --secondary-color: #f8f9fa;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            line-height: 1.6;
            background: var(--white);
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: transparent;
        }

        /* Mobile-specific optimizations */
        @media (max-width: 768px) {
            body {
                font-size: 16px;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            input, select, textarea {
                font-size: 16px;
            }

            * {
                -webkit-overflow-scrolling: touch;
            }

            img {
                max-width: 100%;
                height: auto;
            }
        }

        /* Smooth Transitions */
        a {
            text-decoration: none;
            transition: all 0.3s ease;
        }

        /* Footer Styles */
        .footer {
            background: var(--primary-color);
            color: white;
            padding: 3rem 0 2rem;
            text-align: center;
            margin-top: 4rem;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--accent-red);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-text {
            opacity: 0.8;
            margin: 1rem 0;
        }

        .footer-logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 10px;
        }
    </style>

    <!-- Page-specific styles -->
    @yield('styles')
</head>
<body>
    <!-- Unified Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @if(!isset($hideFooter) || !$hideFooter)
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Branch Hub Logo">
                    <span class="orbitron-bold orbitron-text small">Branch Hub</span>
                </div>
                <p class="footer-text">
                    مساحة العمل المثالية في قطاع غزة<br>
                    جميع الحقوق محفوظة &copy; {{ date('Y') }}
                </p>

                <!-- Footer Contact Links (shown on landing page) -->

                <div class="mt-3">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="tel:+972592782897" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-telephone me-1"></i>
                            اتصل بنا
                        </a>
                        <a href="https://wa.me/972592782897" target="_blank" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-whatsapp me-1"></i>
                            واتساب
                        </a>
                        <a href="https://www.instagram.com/branchspaces/" target="_blank" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-instagram me-1"></i>
                            انستجرام
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Initialize AOS -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>

    <!-- Page-specific scripts -->
    @yield('scripts')
</body>
</html>
