<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Hub - مساحة العمل المثالية في قطاع غزة</title>
    
    <!-- Font Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <!-- Orbitron and Tektur Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&family=Tektur:wght@400..900&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        /* Orbitron Font Classes */
        /* Usage: <span class="orbitron-bold">Text</span> */
        .orbitron-bold {
            font-family: "Orbitron", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
        }
        
        /* Usage: <span class="orbitron-heavy">Text</span> */
        .orbitron-heavy {
            font-family: "Orbitron", sans-serif;
            font-optical-sizing: auto;
            font-weight: 900;
            font-style: normal;
        }
        
        /* Usage: <span class="orbitron-medium">Text</span> */
        .orbitron-medium {
            font-family: "Orbitron", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }
        
        /* Tektur Font Classes */
        /* Usage: <span class="tektur-bold">Text</span> */
        .tektur-bold {
            font-family: "Tektur", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }
        
        /* Usage: <span class="tektur-heavy">Text</span> */
        .tektur-heavy {
            font-family: "Tektur", sans-serif;
            font-optical-sizing: auto;
            font-weight: 900;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }
        
        /* Usage: <span class="tektur-medium">Text</span> */
        .tektur-medium {
            font-family: "Tektur", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }
        
        :root {
            --primary-color: #1a1a1a; /* أسود من اللوجو */
            --accent-red: #dc2626; /* أحمر من اللوجو */
            --accent-white: #ffffff; /* أبيض من اللوجو */
            --secondary-color: #f8f9fa;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --success-color: #10b981;
            --warning-color: #f59e0b;
        }
        
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            line-height: 1.6;
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
            
            /* Prevent zoom on input focus */
            input, select, textarea {
                font-size: 16px;
            }
            
            /* Improve scrolling performance */
            * {
                -webkit-overflow-scrolling: touch;
            }
            
            /* Optimize images */
            img {
                max-width: 100%;
                height: auto;
            }
        }
        
        /* Navigation */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
        }
        
        .logo-img {
            width: 40px;
            height: 40px;
            margin-left: 10px;
            border-radius: 50%;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--accent-red) !important;
        }
        
        /* Hero Section - Modern Dark Design */
        .hero-section {
            background: 
                radial-gradient(circle at 20% 80%, rgba(220, 38, 38, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(138, 43, 226, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="%23ffffff" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>'),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="glow1" cx="50%" cy="50%"><stop offset="0%" stop-color="%23dc2626" stop-opacity="0.2"/><stop offset="100%" stop-color="%23dc2626" stop-opacity="0"/></radialGradient><radialGradient id="glow2" cx="50%" cy="50%"><stop offset="0%" stop-color="%2300ffff" stop-opacity="0.15"/><stop offset="100%" stop-color="%2300ffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="150" fill="url(%23glow1)"/><circle cx="800" cy="300" r="200" fill="url(%23glow2)"/><circle cx="400" cy="700" r="180" fill="url(%23glow1)"/></svg>');
            opacity: 0.4;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }
        
        .hero-title {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            color: #ffffff;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            position: relative;
        }
        
        .hero-title::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, transparent, rgba(220, 38, 38, 0.1), transparent);
            border-radius: 20px;
            z-index: -1;
            animation: titleGlow 3s ease-in-out infinite;
        }
        
        @keyframes titleGlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.02); }
        }
        
        /* Enhanced Font Styles */
        .orbitron-text {
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(220, 38, 38, 0.2);
            transition: all 0.3s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            font-display: swap;
        }
        
        .orbitron-text:hover {
            text-shadow: 0 0 20px rgba(220, 38, 38, 0.4);
            transform: scale(1.02);
        }
        
        .orbitron-text.large {
            font-size: 4rem;
        }
        
        .orbitron-text.medium {
            font-size: 2.5rem;
        }
        
        .orbitron-text.small {
            font-size: 1.3rem;
            padding: 0 0.5rem;
        }
        
        /* Tektur Text Styles */
        .tektur-text {
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(220, 38, 38, 0.2);
            transition: all 0.3s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            font-display: swap;
        }
        
        .tektur-text:hover {
            text-shadow: 0 0 20px rgba(220, 38, 38, 0.4);
            transform: scale(1.02);
        }
        
        .tektur-text.large {
            font-size: 4rem;
        }
        
        .tektur-text.medium {
            font-size: 2.5rem;
        }
        
        .tektur-text.small {
            font-size: 1.8rem;
        }
        
        /* Force Orbitron font loading */
        @font-face {
            font-family: 'Orbitron';
            font-display: swap;
        }
        
        /* Additional specificity for Orbitron */
        span.orbitron-text,
        .orbitron-text span,
        h1 .orbitron-text,
        .navbar-brand .orbitron-text,
        .footer-logo .orbitron-text {
            font-family: "Orbitron", monospace !important;
            font-weight: inherit !important;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            opacity: 0.95;
            font-weight: 500;
            max-width: 600px;
            color: #f8f9fa;
        }
        
        .hero-description {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
            line-height: 1.8;
            color: #e9ecef;
            max-width: 700px;
            font-weight: 400;
        }
        
        .hero-cta-text {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.85;
            line-height: 1.7;
            color: #d1d5db;
            max-width: 680px;
            font-style: italic;
        }
        
        .hero-location {
            display: flex;
            align-items: center;
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
            opacity: 0.8;
        }
        
        .hero-location i {
            color: var(--accent-red);
            margin-left: 0.5rem;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        
        .btn-hero {
            padding: 1.2rem 3rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary-hero {
            background: var(--accent-red);
            color: var(--accent-white);
            border-color: var(--accent-red);
        }
        
        .btn-primary-hero:hover {
            background: transparent;
            color: var(--accent-red);
            border-color: var(--accent-red);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(220, 38, 38, 0.3);
        }
        
        .btn-outline-hero {
            background: transparent;
            color: var(--accent-white);
            border-color: var(--accent-white);
        }
        
        .btn-outline-hero:hover {
            background: var(--accent-white);
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 255, 255, 0.3);
        }
        
        /* About Section */
        .about-section {
            padding: 6rem 0;
            background: var(--secondary-color);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title h2 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }
        
        .section-title p {
            font-size: 1.3rem;
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto;
        }
        
        .about-content {
            display: flex;
            align-items: center;
            gap: 4rem;
        }
        
        .about-text {
            flex: 1;
        }
        
        .about-text h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }
        
        .about-text p {
            font-size: 1.1rem;
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }
        
        .about-features {
            list-style: none;
            padding: 0;
        }
        
        .about-features li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: var(--text-dark);
        }
        
        .about-features i {
            color: var(--accent-red);
            margin-left: 1rem;
            font-size: 1.2rem;
        }
        
        .about-image {
            flex: 1;
            text-align: center;
        }
        
        .about-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Booking Plans Section */
        .plans-section {
            padding: 6rem 0;
            background: var(--accent-white);
        }
        
        .plan-card {
            background: var(--accent-white);
            border-radius: 25px;
            padding: 3rem 2.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            height: 100%;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .plan-card.smart-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--accent-red), var(--primary-color));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .plan-card:hover::before {
            transform: scaleX(1);
        }
        
        .plan-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--accent-red);
        }
        
        .plan-card.featured {
            border-color: var(--accent-red);
            transform: scale(1.05);
        }
        
        .plan-card.featured::before {
            transform: scaleX(1);
        }
        
        .plan-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-red), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
        }
        
        .plan-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .plan-price {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent-red);
            margin-bottom: 0.5rem;
        }
        
        .plan-period {
            color: var(--text-light);
            margin-bottom: 2rem;
        }
        
        .plan-features {
            list-style: none;
            padding: 0;
            margin-bottom: 2.5rem;
        }
        
        .plan-features li {
            padding: 0.5rem 0;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .plan-features i {
            color: var(--success-color);
            margin-left: 0.5rem;
        }
        
        .btn-plan {
            background: var(--accent-red);
            color: var(--accent-white);
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            z-index: 10;
            cursor: pointer;
        }
        
        .btn-plan:hover {
            background: var(--primary-color);
            color: var(--accent-white);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
        }
        
        /* Target Audience Section */
        .audience-section {
            padding: 6rem 0;
            background: var(--secondary-color);
        }
        
        .audience-card {
            background: var(--accent-white);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .audience-card.smart-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .audience-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .audience-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-red), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
            transition: all 0.3s ease;
        }
        
        .audience-card:hover .audience-icon {
            transform: scale(1.1);
            box-shadow: 0 15px 35px rgba(220, 38, 38, 0.5);
        }
        
        
        .audience-card h4 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .audience-card p {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 0;
        }
        
        /* Location Section */
        .location-section {
            padding: 6rem 0;
            background: var(--accent-white);
        }
        
        .location-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .location-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2rem;
        }
        
        .location-content p {
            font-size: 1.2rem;
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 2rem;
        }
        
        .location-info {
            background: var(--secondary-color);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
        }
        
        .location-info h4 {
            color: var(--accent-red);
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, #2d2d2d 100%);
            color: white;
            text-align: center;
        }
        
        .cta-content h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }
        
        .cta-content p {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Footer */
        .footer {
            background: var(--primary-color);
            color: white;
            padding: 3rem 0 2rem;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer-logo {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--accent-red);
        }
        
        .footer-text {
            opacity: 0.8;
            margin-bottom: 0;
        }
        
        /* Responsive Design */
        
        /* Large Mobile and Small Tablets */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
                line-height: 1.2;
                margin-bottom: 1.5rem;
                text-align: center;
                padding: 0 1rem;
            }
            
            .orbitron-text.large {
                font-size: 2.5rem;
            }
            
            .orbitron-text.medium {
                font-size: 1.8rem;
            }
            
            .orbitron-text.small {
                font-size: 1rem;
                padding: 0 0.3rem;
            }
            
            .tektur-text.large {
                font-size: 2.5rem;
            }
            
            .tektur-text.medium {
                font-size: 1.8rem;
            }
            
            .tektur-text.small {
                font-size: 1.2rem;
            }
            
            .btn-custom {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .contact-info {
                padding: 1.5rem;
                margin-top: 1.5rem;
            }
            
            .contact-item {
                padding: 0.8rem;
                margin-bottom: 1rem;
            }
            
            .contact-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                margin-left: 0.8rem;
            }
            
            .contact-details h5 {
                font-size: 1rem;
            }
            
            .contact-details p {
                font-size: 0.85rem;
            }
            
            .contact-card {
                padding: 2rem 1.5rem;
            }
            
            .contact-card .contact-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .contact-additional {
                padding: 2rem;
                margin-top: 2rem;
            }
            
            .contact-additional h3 {
                font-size: 1.3rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
                margin-bottom: 1.5rem;
                text-align: center;
                color: var(--accent-red);
                font-weight: 600;
                padding: 0 1rem;
            }
            
            .hero-description {
                font-size: 0.95rem;
                line-height: 1.6;
                margin-bottom: 1.5rem;
                text-align: center;
                padding: 0 1rem;
            }
            
            .hero-cta-text {
                font-size: 0.9rem;
                line-height: 1.5;
                margin-bottom: 1.5rem;
                text-align: center;
                padding: 0 1rem;
                color: #666;
                font-style: italic;
            }
            
            .hero-location {
                margin-bottom: 2rem;
                font-size: 0.9rem;
                text-align: center;
                padding: 0 1rem;
            }
            
            .hero-location i {
                color: var(--accent-red);
                margin-left: 0.5rem;
            }
            
            .ai-features-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                margin-top: 2rem;
            }
            
            .ai-feature-card {
                padding: 1rem;
                text-align: center;
            }
            
            .ai-feature-text {
                font-size: 0.8rem;
                margin-top: 0.5rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
                padding: 0 1rem;
            }
            
            .btn-hero {
                width: 100%;
                max-width: 300px;
                padding: 1rem 2rem;
                font-size: 1rem;
                border-radius: 50px;
                font-weight: 600;
                text-align: center;
                transition: all 0.3s ease;
            }
            
            .btn-hero:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }
            
            .about-content {
                flex-direction: column;
                gap: 2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .plan-card.featured {
                transform: none;
            }
            
            /* Hero Section Mobile Improvements */
            .hero-section {
                padding: 3rem 0;
                min-height: auto;
            }
            
            .hero-content {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .ai-workspace-icon {
                margin-bottom: 1.5rem;
            }
            
            .ai-workspace-icon i {
                font-size: 3rem !important;
            }
        }
        
        /* Small Mobile Devices */
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
                line-height: 1.1;
                text-align: center;
                padding: 0 0.5rem;
            }
            
            .orbitron-text.large {
                font-size: 2rem;
            }
            
            .orbitron-text.medium {
                font-size: 1.5rem;
            }
            
            .tektur-text.large {
                font-size: 2rem;
            }
            
            .tektur-text.medium {
                font-size: 1.5rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
                text-align: center;
                color: var(--accent-red);
                font-weight: 600;
                padding: 0 0.5rem;
            }
            
            .hero-description {
                font-size: 0.9rem;
                text-align: center;
                padding: 0 0.5rem;
                line-height: 1.5;
            }
            
            .hero-cta-text {
                font-size: 0.85rem;
                text-align: center;
                padding: 0 0.5rem;
                color: #666;
                font-style: italic;
            }
            
            .hero-location {
                font-size: 0.85rem;
                text-align: center;
                padding: 0 0.5rem;
            }
            
            .hero-location i {
                color: var(--accent-red);
                margin-left: 0.5rem;
            }
            
            .ai-features-grid {
                grid-template-columns: 1fr;
                gap: 0.8rem;
            }
            
            .ai-feature-card {
                padding: 0.8rem;
            }
            
            .ai-feature-text {
                font-size: 0.75rem;
            }
            
            .btn-hero {
                max-width: 100%;
                padding: 0.75rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .section-title p {
                font-size: 0.9rem;
            }
            
            /* About Section Mobile */
            .about-text h3 {
                font-size: 1.5rem;
                margin-top: 2.5rem;
                margin-bottom: 1.5rem;
                text-align: center;
                position: relative;
                padding-top: 1.5rem;
                padding-bottom: 1rem;
            }
            
            .about-text h3::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background: linear-gradient(135deg, var(--accent-red), #ff6b6b);
                border-radius: 2px;
            }
            
            .about-text p {
                font-size: 0.9rem;
                line-height: 1.6;
                margin-bottom: 2rem;
                text-align: justify;
            }
            
            .about-features {
                padding-right: 0;
                margin-top: 1.5rem;
            }
            
            .about-features li {
                font-size: 0.85rem;
                margin-bottom: 0.8rem;
                padding: 0.5rem 0;
                display: flex;
                align-items: center;
            }
            
            .about-features li i {
                margin-left: 0.8rem;
                color: var(--accent-red);
                font-size: 1rem;
            }
            
            /* Contact Section Mobile */
            .contact-card {
                padding: 1.5rem 1rem;
            }
            
            .contact-additional {
                padding: 1.5rem 1rem;
            }
            
            /* Hero Section Small Mobile */
            .hero-section {
                padding: 2rem 0;
            }
            
            .hero-content {
                padding: 0 1rem;
            }
            
            .ai-workspace-icon i {
                font-size: 2.5rem !important;
            }
            
            .ai-element i {
                font-size: 2rem !important;
            }
        }
        
        /* Extra Small Mobile Devices */
        @media (max-width: 375px) {
            .hero-title {
                font-size: 1.8rem;
                text-align: center;
                padding: 0 0.5rem;
            }
            
            .orbitron-text.large {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 0.95rem;
                text-align: center;
                color: var(--accent-red);
                font-weight: 600;
                padding: 0 0.5rem;
            }
            
            .hero-description {
                font-size: 0.85rem;
                text-align: center;
                padding: 0 0.5rem;
                line-height: 1.5;
            }
            
            .hero-cta-text {
                font-size: 0.8rem;
                text-align: center;
                padding: 0 0.5rem;
                color: #666;
                font-style: italic;
            }
            
            .btn-hero {
                padding: 0.7rem 1rem;
                font-size: 0.85rem;
            }
            
            .section-title h2 {
                font-size: 1.6rem;
            }
            
            .ai-workspace-icon i {
                font-size: 2rem !important;
            }
            
            .ai-element i {
                font-size: 1.5rem !important;
            }
        }
        
        /* Ultra Small Mobile Devices (iPhone SE, etc.) */
        @media (max-width: 320px) {
            .hero-title {
                font-size: 1.6rem;
                line-height: 1.1;
                text-align: center;
                padding: 0 0.5rem;
            }
            
            .orbitron-text.large {
                font-size: 1.6rem;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
                text-align: center;
                color: var(--accent-red);
                font-weight: 600;
                padding: 0 0.5rem;
            }
            
            .hero-description {
                font-size: 0.8rem;
                line-height: 1.5;
                text-align: center;
                padding: 0 0.5rem;
            }
            
            .hero-cta-text {
                font-size: 0.75rem;
                line-height: 1.4;
                text-align: center;
                padding: 0 0.5rem;
                color: #666;
                font-style: italic;
            }
            
            .hero-location {
                font-size: 0.8rem;
                text-align: center;
                padding: 0 0.5rem;
            }
            
            .hero-location i {
                color: var(--accent-red);
                margin-left: 0.5rem;
            }
            
            .btn-hero {
                padding: 0.6rem 0.8rem;
                font-size: 0.8rem;
                max-width: 100%;
            }
            
            .section-title h2 {
                font-size: 1.4rem;
            }
            
            .section-title p {
                font-size: 0.8rem;
            }
            
            .ai-workspace-icon i {
                font-size: 1.8rem !important;
            }
            
            .ai-element i {
                font-size: 1.3rem !important;
            }
            
            .ai-feature-text {
                font-size: 0.7rem;
            }
            
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            .hero-content {
                padding: 0 0.5rem;
            }
            
            /* Plans Section Ultra Small */
            .plans-grid {
                gap: 1rem;
            }
            
            .plan-card {
                padding: 1rem;
            }
            
            .plan-card h3 {
                font-size: 1.1rem;
            }
            
            .plan-price {
                font-size: 1.8rem;
            }
            
            .plan-features li {
                font-size: 0.8rem;
            }
            
            .plan-button {
                padding: 0.7rem 1rem;
                font-size: 0.85rem;
            }
            
            /* Contact Section Ultra Small */
            .contact-card {
                padding: 1rem;
            }
            
            .contact-card h5 {
                font-size: 1rem;
            }
            
            .contact-card p {
                font-size: 0.8rem;
            }
            
            .contact-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            /* About Section Ultra Small */
            .about-text h3 {
                font-size: 1.3rem;
                margin-top: 2rem;
                margin-bottom: 1.2rem;
                text-align: center;
                padding-top: 1.2rem;
                padding-bottom: 0.8rem;
            }
            
            .about-text h3::after {
                width: 50px;
                height: 2px;
            }
            
            .about-text p {
                font-size: 0.8rem;
                line-height: 1.5;
                margin-bottom: 1.5rem;
                text-align: justify;
            }
            
            .about-features {
                margin-top: 1.2rem;
            }
            
            .about-features li {
                font-size: 0.75rem;
                margin-bottom: 0.6rem;
                padding: 0.4rem 0;
            }
            
            .about-features li i {
                margin-left: 0.6rem;
                font-size: 0.9rem;
            }
        }
        
        /* Large Mobile Devices (iPhone Plus, etc.) */
        @media (min-width: 414px) and (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
                text-align: center;
                padding: 0 1rem;
            }
            
            .orbitron-text.large {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
                text-align: center;
                color: var(--accent-red);
                font-weight: 600;
                padding: 0 1rem;
            }
            
            .hero-description {
                font-size: 1rem;
                text-align: center;
                padding: 0 1rem;
                line-height: 1.6;
            }
            
            .hero-cta-text {
                font-size: 0.95rem;
                text-align: center;
                padding: 0 1rem;
                color: #666;
                font-style: italic;
            }
            
            .ai-features-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.2rem;
            }
            
            .ai-feature-card {
                padding: 1.2rem;
            }
            
            .ai-feature-text {
                font-size: 0.85rem;
            }
            
            .btn-hero {
                max-width: 320px;
                padding: 0.9rem 1.8rem;
                font-size: 1rem;
            }
            
            .section-title h2 {
                font-size: 2.2rem;
            }
            
            .ai-workspace-icon i {
                font-size: 3.5rem !important;
            }
            
            .ai-element i {
                font-size: 2.2rem !important;
            }
            
            /* About Section Large Mobile */
            .about-text h3 {
                font-size: 1.7rem;
                margin-top: 3rem;
                margin-bottom: 1.8rem;
                text-align: center;
                padding-top: 1.8rem;
                padding-bottom: 1.2rem;
            }
            
            .about-text h3::after {
                width: 70px;
                height: 3px;
            }
            
            .about-text p {
                font-size: 1rem;
                line-height: 1.7;
                margin-bottom: 2.2rem;
            }
            
            .about-features {
                margin-top: 1.8rem;
            }
            
            .about-features li {
                font-size: 0.9rem;
                margin-bottom: 0.9rem;
                padding: 0.6rem 0;
            }
            
            .about-features li i {
                margin-left: 1rem;
                font-size: 1.1rem;
            }
        }
        
        /* Tablet Portrait */
        @media (min-width: 768px) and (max-width: 1024px) and (orientation: portrait) {
            .hero-title {
                font-size: 3.2rem;
                text-align: center;
                padding: 0 1.5rem;
            }
            
            .orbitron-text.large {
                font-size: 3.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.4rem;
                text-align: center;
                color: var(--accent-red);
                font-weight: 600;
                padding: 0 1.5rem;
            }
            
            .hero-description {
                font-size: 1.1rem;
                text-align: center;
                padding: 0 1.5rem;
                line-height: 1.6;
            }
            
            .hero-cta-text {
                font-size: 1rem;
                text-align: center;
                padding: 0 1.5rem;
                color: #666;
                font-style: italic;
            }
            
            .ai-features-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
            
            .ai-feature-card {
                padding: 1.5rem;
            }
            
            .ai-feature-text {
                font-size: 0.9rem;
            }
            
            .btn-hero {
                max-width: 350px;
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }
            
            .section-title h2 {
                font-size: 2.5rem;
            }
            
            .ai-workspace-icon i {
                font-size: 4rem !important;
            }
            
            .ai-element i {
                font-size: 2.5rem !important;
            }
            
            /* Plans Section Tablet Portrait */
            .plans-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
            
            .plan-card {
                padding: 2rem;
            }
            
            .plan-card h3 {
                font-size: 1.5rem;
            }
            
            .plan-price {
                font-size: 2.5rem;
            }
            
            .plan-features li {
                font-size: 1rem;
            }
            
            .plan-button {
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }
            
            /* Contact Section Tablet Portrait */
            .contact-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
            
            .contact-card {
                padding: 2rem;
            }
            
            .contact-card h5 {
                font-size: 1.3rem;
            }
            
            .contact-card p {
                font-size: 1rem;
            }
            
            .contact-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            /* About Section Tablet Portrait */
            .about-text h3 {
                font-size: 2rem;
                margin-top: 3.5rem;
                margin-bottom: 2rem;
                text-align: center;
                padding-top: 2rem;
                padding-bottom: 1.5rem;
            }
            
            .about-text h3::after {
                width: 80px;
                height: 4px;
            }
            
            .about-text p {
                font-size: 1.1rem;
                line-height: 1.8;
                margin-bottom: 2.5rem;
            }
            
            .about-features {
                margin-top: 2rem;
            }
            
            .about-features li {
                font-size: 1rem;
                margin-bottom: 1rem;
                padding: 0.7rem 0;
            }
            
            .about-features li i {
                margin-left: 1.2rem;
                font-size: 1.2rem;
            }
        }
        
        /* Tablet Landscape */
        @media (min-width: 1024px) and (max-width: 1366px) and (orientation: landscape) {
            .hero-title {
                font-size: 3.5rem;
                text-align: center;
                padding: 0 2rem;
            }
            
            .orbitron-text.large {
                font-size: 3.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.5rem;
                text-align: center;
                color: var(--accent-red);
                font-weight: 600;
                padding: 0 2rem;
            }
            
            .hero-description {
                font-size: 1.2rem;
                text-align: center;
                padding: 0 2rem;
                line-height: 1.6;
            }
            
            .hero-cta-text {
                font-size: 1.1rem;
                text-align: center;
                padding: 0 2rem;
                color: #666;
                font-style: italic;
            }
            
            .ai-features-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 2rem;
            }
            
            .ai-feature-card {
                padding: 2rem;
            }
            
            .ai-feature-text {
                font-size: 1rem;
            }
            
            .btn-hero {
                max-width: 400px;
                padding: 1.2rem 2.5rem;
                font-size: 1.2rem;
            }
            
            .section-title h2 {
                font-size: 3rem;
            }
            
            .ai-workspace-icon i {
                font-size: 5rem !important;
            }
            
            .ai-element i {
                font-size: 3rem !important;
            }
            
            /* Plans Section Tablet Landscape */
            .plans-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 2.5rem;
            }
            
            .plan-card {
                padding: 2.5rem;
            }
            
            .plan-card h3 {
                font-size: 1.6rem;
            }
            
            .plan-price {
                font-size: 3rem;
            }
            
            .plan-features li {
                font-size: 1.1rem;
            }
            
            .plan-button {
                padding: 1.2rem 2.5rem;
                font-size: 1.2rem;
            }
            
            /* Contact Section Tablet Landscape */
            .contact-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 2.5rem;
            }
            
            .contact-card {
                padding: 2.5rem;
            }
            
            .contact-card h5 {
                font-size: 1.4rem;
            }
            
            .contact-card p {
                font-size: 1.1rem;
            }
            
            .contact-icon {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }
            
            /* About Section Tablet Landscape */
            .about-text h3 {
                font-size: 2.2rem;
                margin-top: 4rem;
                margin-bottom: 2.2rem;
                text-align: center;
                padding-top: 2.2rem;
                padding-bottom: 1.8rem;
            }
            
            .about-text h3::after {
                width: 90px;
                height: 4px;
            }
            
            .about-text p {
                font-size: 1.2rem;
                line-height: 1.8;
                margin-bottom: 2.8rem;
            }
            
            .about-features {
                margin-top: 2.2rem;
            }
            
            .about-features li {
                font-size: 1.1rem;
                margin-bottom: 1.1rem;
                padding: 0.8rem 0;
            }
            
            .about-features li i {
                margin-left: 1.4rem;
                font-size: 1.3rem;
            }
        }
        
        /* Mobile Navigation Optimizations */
        @media (max-width: 768px) {
            .navbar-custom {
                padding: 0.5rem 0;
            }
            
            .navbar-brand {
                font-size: 1.4rem;
            }
            
            .logo-img {
                width: 35px;
                height: 35px;
            }
            
            .navbar-toggler {
                border: none;
                padding: 0.25rem 0.5rem;
            }
            
            .navbar-toggler:focus {
                box-shadow: none;
            }
            
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                margin-top: 1rem;
                padding: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }
            
            .navbar-nav {
                text-align: center;
            }
            
            .nav-link {
                padding: 0.75rem 1rem;
                font-size: 1rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }
            
            .nav-link:last-child {
                border-bottom: none;
            }
            
            .nav-link:hover {
                background-color: rgba(220, 38, 38, 0.1);
                border-radius: 0.25rem;
            }
        }
        
        /* Mobile Performance Optimizations */
        @media (max-width: 768px) {
            /* Reduce animations on mobile for better performance */
            .tech-bg,
            .ai-neural-network,
            .data-stream,
            .circuit-overlay {
                animation-duration: 8s;
            }
            
            /* Optimize floating animations */
            .floating {
                animation-duration: 8s;
            }
            
            /* Reduce tech pulse frequency */
            .tech-pulse {
                animation-duration: 8s;
            }
            
            /* Optimize hero background */
            .hero-bg {
                background-attachment: scroll;
            }
            
            /* Improve touch targets */
            .btn-hero,
            .btn-custom,
            .nav-link {
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Optimize images */
            .about-image img {
                max-width: 100%;
                height: auto;
            }
            
            /* Improve spacing */
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            /* Optimize text readability */
            .hero-description,
            .hero-cta-text,
            .about-text p {
                text-align: justify;
                hyphens: auto;
            }
            
            /* Plans Section Mobile */
            .plans-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                margin-top: 2rem;
            }
            
            .plan-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .plan-card h3 {
                font-size: 1.3rem;
                margin-bottom: 1rem;
            }
            
            .plan-price {
                font-size: 2rem;
                margin-bottom: 1rem;
            }
            
            .plan-features {
                margin-bottom: 1.5rem;
            }
            
            .plan-features li {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }
            
            .plan-button {
                width: 100%;
                padding: 0.8rem 1.5rem;
                font-size: 0.95rem;
            }
            
            /* Contact Section Mobile */
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .contact-card {
                padding: 1.5rem;
                text-align: center;
            }
            
            .contact-card h5 {
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }
            
            .contact-card p {
                font-size: 0.9rem;
            }
            
            .contact-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
                margin: 0 auto 1rem;
            }
            
            /* Footer Mobile */
            .footer-content {
                text-align: center;
                padding: 2rem 1rem;
            }
            
            .footer-logo {
                margin-bottom: 1rem;
            }
            
            .footer-text {
                font-size: 0.9rem;
                line-height: 1.6;
            }
            
            /* Typography Mobile Optimizations */
            .hero-title,
            .orbitron-text.large {
                word-break: keep-all;
                hyphens: none;
            }
            
            .hero-description,
            .hero-cta-text,
            .about-text p {
                word-spacing: 0.1em;
                letter-spacing: 0.02em;
            }
            
            /* Button Mobile Optimizations */
            .btn-hero,
            .btn-custom,
            .plan-button {
                border-radius: 0.5rem;
                font-weight: 600;
                text-transform: none;
                letter-spacing: 0.02em;
                transition: all 0.3s ease;
            }
            
            .btn-hero:hover,
            .btn-custom:hover,
            .plan-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }
            
            .btn-hero:active,
            .btn-custom:active,
            .plan-button:active {
                transform: translateY(0);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            
            /* Card Mobile Optimizations */
            .plan-card,
            .contact-card,
            .ai-feature-card {
                border-radius: 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
            }
            
            .plan-card:hover,
            .contact-card:hover,
            .ai-feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            }
            
            /* Section Spacing Mobile */
            .hero-section,
            .about-section,
            .plans-section,
            .contact-section {
                padding: 3rem 0;
            }
            
            .about-section {
                padding-top: 4rem;
                padding-bottom: 4rem;
            }
            
            .section-title {
                margin-bottom: 3rem;
            }
            
            /* About Section General Mobile Improvements */
            .about-content {
                flex-direction: column;
                gap: 3rem;
                align-items: center;
                padding-top: 2rem;
            }
            
            .about-text {
                order: 1;
                text-align: center;
                max-width: 100%;
                position: relative;
            }
            
            .about-text::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100px;
                height: 2px;
                background: linear-gradient(90deg, transparent, var(--accent-red), transparent);
                opacity: 0.3;
            }
            
            .about-image {
                order: 2;
                max-width: 100%;
                margin-top: 1rem;
            }
            
            .about-image img {
                border-radius: 1rem;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            }
            
            /* Form Mobile Optimizations */
            .form-control,
            .form-select {
                border-radius: 0.5rem;
                padding: 0.8rem 1rem;
                font-size: 1rem;
                border: 2px solid #e5e7eb;
                transition: all 0.3s ease;
            }
            
            .form-control:focus,
            .form-select:focus {
                border-color: var(--accent-red);
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }
            
            /* Loading States Mobile */
            .loading {
                opacity: 0.7;
                pointer-events: none;
            }
            
            .loading::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 20px;
                height: 20px;
                margin: -10px 0 0 -10px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid var(--accent-red);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        }
        
        /* Mobile Landscape Orientation */
        @media (max-width: 768px) and (orientation: landscape) {
            .hero-section {
                padding: 2rem 0;
                min-height: auto;
            }
            
            .hero-title {
                font-size: 2rem;
                margin-bottom: 0.5rem;
            }
            
            .hero-description {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }
            
            .hero-cta-text {
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }
            
            .ai-features-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 0.5rem;
            }
            
            .ai-feature-card {
                padding: 0.5rem;
            }
            
            .ai-feature-text {
                font-size: 0.7rem;
            }
        }
        
        /* Tech Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes techPulse {
            0%, 100% { 
                opacity: 0.4;
                transform: scale(1);
            }
            50% { 
                opacity: 0.7;
                transform: scale(1.02);
            }
        }
        
        @keyframes dataFlow {
            0% { 
                transform: translateX(-100px);
                opacity: 0;
            }
            50% { 
                opacity: 0.4;
            }
            100% { 
                transform: translateX(100vw);
                opacity: 0;
            }
        }
        
        @keyframes aiGlow {
            0%, 100% { 
                box-shadow: 0 0 15px rgba(220, 38, 38, 0.2);
            }
            50% { 
                box-shadow: 0 0 25px rgba(220, 38, 38, 0.4), 0 0 35px rgba(220, 38, 38, 0.2);
            }
        }
        
        @keyframes circuitPath {
            0% { 
                stroke-dashoffset: 1000;
                opacity: 0;
            }
            50% { 
                opacity: 0.8;
            }
            100% { 
                stroke-dashoffset: 0;
                opacity: 0;
            }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        .tech-pulse {
            animation: techPulse 6s ease-in-out infinite;
        }
        
        .ai-glow {
            animation: gentleHorizontal 8s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }
        
        @keyframes gentleHorizontal {
            0%, 100% { 
                transform: translateX(0px); 
            }
            50% { 
                transform: translateX(15px); 
            }
        }
        
        /* Logo with Moving Lines */
        .logo-with-lines {
            position: relative;
            display: inline-block;
        }
        
        .moving-lines {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            pointer-events: none;
        }
        
        .line {
            position: absolute;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.6), transparent);
            border-radius: 2px;
            opacity: 0.7;
        }
        
        .line-1 {
            width: 60px;
            height: 2px;
            top: 20px;
            left: 30px;
            animation: lineMove1 6s ease-in-out infinite;
        }
        
        .line-2 {
            width: 2px;
            height: 60px;
            top: 30px;
            right: 20px;
            background: linear-gradient(180deg, transparent, rgba(0, 255, 255, 0.6), transparent);
            animation: lineMove2 8s ease-in-out infinite;
        }
        
        .line-3 {
            width: 50px;
            height: 2px;
            bottom: 25px;
            left: 35px;
            background: linear-gradient(90deg, transparent, rgba(138, 43, 226, 0.6), transparent);
            animation: lineMove3 7s ease-in-out infinite;
        }
        
        .line-4 {
            width: 2px;
            height: 45px;
            top: 37px;
            left: 15px;
            background: linear-gradient(180deg, transparent, rgba(220, 38, 38, 0.4), transparent);
            animation: lineMove4 9s ease-in-out infinite;
        }
        
        @keyframes lineMove1 {
            0%, 100% { 
                transform: translateX(0px);
                opacity: 0.3;
            }
            50% { 
                transform: translateX(10px);
                opacity: 0.8;
            }
        }
        
        @keyframes lineMove2 {
            0%, 100% { 
                transform: translateY(0px);
                opacity: 0.3;
            }
            50% { 
                transform: translateY(-8px);
                opacity: 0.8;
            }
        }
        
        @keyframes lineMove3 {
            0%, 100% { 
                transform: translateX(0px);
                opacity: 0.3;
            }
            50% { 
                transform: translateX(-8px);
                opacity: 0.8;
            }
        }
        
        @keyframes lineMove4 {
            0%, 100% { 
                transform: translateY(0px);
                opacity: 0.3;
            }
            50% { 
                transform: translateY(6px);
                opacity: 0.8;
            }
        }
        
        
        /* Advanced AI Tech Background Elements */
        .tech-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
        }
        
        .ai-neural-network {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><linearGradient id="neural" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="%23dc2626" stop-opacity="0.3"/><stop offset="50%" stop-color="%2300ffff" stop-opacity="0.2"/><stop offset="100%" stop-color="%238a2be2" stop-opacity="0.3"/></linearGradient></defs><path d="M100,100 Q300,50 500,150 T900,100" stroke="url(%23neural)" stroke-width="2" fill="none" opacity="0.6"/><path d="M100,300 Q400,250 700,350 T900,300" stroke="url(%23neural)" stroke-width="1.5" fill="none" opacity="0.4"/><path d="M100,500 Q200,450 400,550 T800,500" stroke="url(%23neural)" stroke-width="1" fill="none" opacity="0.3"/><circle cx="100" cy="100" r="3" fill="%23dc2626" opacity="0.8"/><circle cx="500" cy="150" r="3" fill="%2300ffff" opacity="0.8"/><circle cx="900" cy="100" r="3" fill="%238a2be2" opacity="0.8"/></svg>');
            animation: neuralFlow 20s linear infinite;
            opacity: 0.3;
        }
        
        @keyframes neuralFlow {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(100px); }
        }
        
        .data-stream {
            position: absolute;
            width: 2px;
            height: 100px;
            background: linear-gradient(to bottom, transparent, var(--accent-red), transparent);
            animation: dataFlow 12s linear infinite;
            opacity: 0.3;
        }
        
        .data-stream:nth-child(1) {
            top: 20%;
            animation-delay: 0s;
        }
        
        .data-stream:nth-child(2) {
            top: 40%;
            animation-delay: 2s;
        }
        
        .data-stream:nth-child(3) {
            top: 60%;
            animation-delay: 4s;
        }
        
        .data-stream:nth-child(4) {
            top: 80%;
            animation-delay: 6s;
        }
        
        /* Circuit Pattern */
        .circuit-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.05;
            background-image: 
                linear-gradient(90deg, transparent 98%, var(--accent-red) 100%),
                linear-gradient(0deg, transparent 98%, var(--accent-red) 100%);
            background-size: 50px 50px;
            animation: techPulse 8s ease-in-out infinite;
        }
        
        /* Advanced AI Elements */
        .ai-element {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .ai-element::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(220, 38, 38, 0.3), rgba(0, 255, 255, 0.2), rgba(138, 43, 226, 0.3), transparent);
            animation: rotate 15s linear infinite;
            opacity: 0.1;
        }
        
        .ai-element::after {
            content: '';
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            animation: aiPulse 3s ease-in-out infinite;
        }
        
        .ai-element:hover::before {
            opacity: 0.2;
        }
        
        .ai-element:hover::after {
            opacity: 0.4;
        }
        
        @keyframes aiPulse {
            0%, 100% { transform: scale(1); opacity: 0; }
            50% { transform: scale(1.1); opacity: 0.3; }
        }
        
        /* AI Workspace Icon */
        .ai-workspace-icon {
            position: relative;
            display: inline-block;
        }
        
        .ai-connection-dots {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
        }
        
        .ai-connection-dots .dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background: linear-gradient(45deg, #dc2626, #00ffff);
            border-radius: 50%;
            animation: dotPulse 2s ease-in-out infinite;
        }
        
        .ai-connection-dots .dot:nth-child(1) {
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation-delay: 0s;
        }
        
        .ai-connection-dots .dot:nth-child(2) {
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            animation-delay: 0.5s;
        }
        
        .ai-connection-dots .dot:nth-child(3) {
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation-delay: 1s;
        }
        
        @keyframes dotPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.5); }
        }
        
        /* AI Features Grid */
        .ai-features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .ai-feature-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .ai-feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(220, 38, 38, 0.3);
        }
        
        .ai-feature-text {
            color: #ffffff;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Smart Hover Effects */
        .smart-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .smart-hover:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 15px 30px rgba(220, 38, 38, 0.15);
        }
        
        .smart-hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(220, 38, 38, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        
        .smart-hover:hover::after {
            opacity: 0;
        }
        
        /* Custom Button Styles */
        .btn-custom {
            background: linear-gradient(135deg, var(--accent-red), #b91c1c);
            border: 2px solid var(--accent-red);
            color: var(--accent-white);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
        }
        
        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-custom:hover {
            background: linear-gradient(135deg, #b91c1c, var(--accent-red));
            border-color: #b91c1c;
            color: var(--accent-white);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }
        
        .btn-custom:hover::before {
            left: 100%;
        }
        
        .btn-custom:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }
        
        .btn-custom i {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .btn-custom:hover i {
            transform: scale(1.1);
        }
        
        /* Alternative Button Styles */
        .btn-custom-outline {
            background: transparent;
            border: 2px solid var(--accent-red);
            color: var(--accent-red);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-custom-outline:hover {
            background: var(--accent-red);
            color: var(--accent-white);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }
        
        .btn-custom-outline i {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .btn-custom-outline:hover i {
            transform: scale(1.1);
        }
        
        /* Contact Info Styles */
        .contact-info {
            background: var(--secondary-color);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--accent-white);
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .contact-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-red);
        }
        
        .contact-item:last-child {
            margin-bottom: 0;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--accent-red), #b91c1c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 1rem;
            color: white;
            font-size: 1.2rem;
        }
        
        .contact-details h5 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .contact-details p {
            color: var(--text-light);
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .contact-link {
            color: var(--accent-red);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .contact-link:hover {
            color: #b91c1c;
        }
        
        /* Contact Section Styles */
        .contact-section {
            padding: 6rem 0;
            background: var(--secondary-color);
        }
        
        .contact-card {
            background: var(--accent-white);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--accent-red), var(--primary-color));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .contact-card:hover::before {
            transform: scaleX(1);
        }
        
        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--accent-red);
        }
        
        .contact-card .contact-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-red), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            transition: transform 0.3s ease;
        }
        
        .contact-card:hover .contact-icon {
            transform: scale(1.1);
        }
        
        .contact-card h4 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .contact-card p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .contact-card .contact-link {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: var(--accent-red);
            color: var(--accent-white);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .contact-card .contact-link:hover {
            background: var(--primary-color);
            color: var(--accent-white);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
        }
        
        /* Additional Contact Info */
        .contact-additional {
            margin-top: 4rem;
            padding: 3rem;
            background: var(--accent-white);
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .contact-additional h3 {
            color: var(--accent-red);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .working-hours {
            margin-bottom: 2rem;
        }
        
        .hours-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--secondary-color);
        }
        
        .hours-item:last-child {
            border-bottom: none;
        }
        
        .hours-item .day {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .hours-item .time {
            color: var(--accent-red);
            font-weight: 600;
        }
        
        .location-text {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .location-text i {
            color: var(--accent-red);
        }
        
        /* Advanced Hero Icon Styles */
        .hero-icon-container {
            position: relative;
            display: inline-block;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }
        
        .hero-icon-main {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            color: white;
            z-index: 3;
            animation: heroIconPulse 3s ease-in-out infinite;
        }
        
        .hero-icon-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 180px;
            height: 180px;
            border: 2px solid rgba(220, 38, 38, 0.3);
            border-radius: 50%;
            animation: heroIconRotate 8s linear infinite;
        }
        
        .hero-icon-ring::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border: 2px solid transparent;
            border-top: 2px solid var(--accent-red);
            border-radius: 50%;
            animation: heroIconRotate 4s linear infinite reverse;
        }
        
        .hero-icon-dots {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 220px;
            height: 220px;
        }
        
        .hero-icon-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--accent-red);
            border-radius: 50%;
            animation: heroIconDots 6s ease-in-out infinite;
        }
        
        .hero-icon-dot:nth-child(1) {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            animation-delay: 0s;
        }
        
        .hero-icon-dot:nth-child(2) {
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            animation-delay: 1s;
        }
        
        .hero-icon-dot:nth-child(3) {
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            animation-delay: 2s;
        }
        
        .hero-icon-dot:nth-child(4) {
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            animation-delay: 3s;
        }
        
        @keyframes heroIconPulse {
            0%, 100% { 
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.8;
            }
            50% { 
                transform: translate(-50%, -50%) scale(1.1);
                opacity: 1;
            }
        }
        
        @keyframes heroIconRotate {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        @keyframes heroIconDots {
            0%, 100% { 
                opacity: 0.3;
                transform: scale(1);
            }
            50% { 
                opacity: 1;
                transform: scale(1.5);
            }
        }
        
        /* Alternative: Modern Tech Grid */
        .tech-grid-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto;
            background: 
                linear-gradient(90deg, rgba(220, 38, 38, 0.1) 1px, transparent 1px),
                linear-gradient(180deg, rgba(220, 38, 38, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            border-radius: 20px;
            overflow: hidden;
        }
        
        .tech-grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(220, 38, 38, 0.1), transparent);
            animation: techGridFlow 4s ease-in-out infinite;
        }
        
        .tech-grid-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            color: white;
            z-index: 2;
        }
        
        @keyframes techGridFlow {
            0%, 100% { 
                transform: translateX(-100%);
                opacity: 0;
            }
            50% { 
                opacity: 1;
            }
            100% { 
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        /* Alternative: Floating Elements */
        .floating-elements {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }
        
        .floating-element {
            position: absolute;
            width: 40px;
            height: 40px;
            background: rgba(220, 38, 38, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            animation: floatingElements 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            top: 20%;
            left: 20%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            top: 20%;
            right: 20%;
            animation-delay: 1.5s;
        }
        
        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 3s;
        }
        
        .floating-element:nth-child(4) {
            bottom: 20%;
            right: 20%;
            animation-delay: 4.5s;
        }
        
        .floating-element:nth-child(5) {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            font-size: 2rem;
            background: rgba(220, 38, 38, 0.3);
            animation: floatingElements 4s ease-in-out infinite;
        }
        
        @keyframes floatingElements {
            0%, 100% { 
                transform: translateY(0px) scale(1);
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-20px) scale(1.1);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Branch Hub Logo" class="logo-img">
                <span class="orbitron-bold orbitron-text small">Branch Hub</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">عنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#plans">خطط الحجز</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#audience">مثالي للعمل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#location">الموقع</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">تواصل معنا</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-outline-dark me-2">تسجيل الدخول</a>
                    <a href="{{ route('booking.form') }}" class="btn btn-danger">احجز مقعدك</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg"></div>
        
        <!-- Advanced AI Tech Background Elements -->
        <div class="tech-bg">
            <div class="ai-neural-network"></div>
            <div class="data-stream"></div>
            <div class="data-stream"></div>
            <div class="data-stream"></div>
            <div class="data-stream"></div>
            <div class="circuit-overlay"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                       
                        <h1 class="hero-title tech-pulse" style="margin-top: 100px;">
                            <span class="orbitron-heavy orbitron-text large">Branch Hub</span>
                        </h1>
                        <p class="hero-subtitle">
                            مساحة العمل الرائدة في قطاع غزة
                        </p>
                        <p class="hero-description">
                            في Branch Hub، نؤمن بأن البيئة المناسبة هي أساس النجاح. لذلك صممنا مساحة عمل متكاملة 
                            توفر لك كل ما تحتاجه للتركيز والإنتاجية العالية.
                        </p>
                        <p class="hero-cta-text">
                            إذا كنت مستعداً لرفع مستوى عملك إلى آفاق جديدة، تواصل مع Branch Hub اليوم 
                            لترى كيف يمكننا مساعدتك في تحقيق أهدافك.
                        </p>
                        <div class="hero-location">
                            <i class="bi bi-geo-alt-fill tech-pulse"></i>
                            <span>قطاع غزة، فلسطين</span>
                        </div>
                        <div class="hero-buttons">
                            <a href="{{ route('booking.form') }}" class="btn-hero btn-primary-hero smart-hover">
                                احجز مقعدك الآن
                            </a>
                            <a href="#about" class="btn-hero btn-outline-hero smart-hover">
                                تعرف علينا أكثر
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                    <div class="text-center">
                        <!-- Modern AI Workspace Icon -->
                        <div class="floating ai-element mb-4">
                            <div class="ai-workspace-icon">
                                <i class="bi bi-laptop text-white" style="font-size: 4rem;"></i>
                                <div class="ai-connection-dots">
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Advanced AI Tech Features -->
                        <div class="ai-features-grid">
                            <div class="ai-feature-card">
                                <div class="ai-element">
                                    <i class="bi bi-cpu-fill text-white" style="font-size: 2.5rem;"></i>
                                </div>
                                <span class="ai-feature-text">خدمات ذكية</span>
                            </div>
                            <div class="ai-feature-card">
                                <div class="ai-element">
                                    <i class="bi bi-wifi text-white" style="font-size: 2.5rem;"></i>
                                </div>
                                <span class="ai-feature-text">إنترنت فائق</span>
                            </div>
                            <div class="ai-feature-card">
                                <div class="ai-element">
                                    <i class="bi bi-lightning-charge-fill text-white" style="font-size: 2.5rem;"></i>
                                </div>
                                <span class="ai-feature-text">طاقة عالية</span>
                            </div>
                            <div class="ai-feature-card">
                                <div class="ai-element">
                                    <i class="bi bi-shield-check text-white" style="font-size: 2.5rem;"></i>
                                </div>
                                <span class="ai-feature-text">أمان متقدم</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>عن Branch Hub</h2>
                <p>مساحة عمل متطورة مصممة خصيصاً لتناسب احتياجاتك المهنية</p>
            </div>
            
            <div class="about-content" data-aos="fade-up" data-aos-delay="200">
                <div class="about-text" >
                    <h3>لماذا Branch Hub؟</h3>
                    <p>
                        في Branch Hub، نؤمن بأن البيئة المناسبة هي أساس النجاح. لذلك صممنا مساحة عمل متكاملة 
                        توفر لك كل ما تحتاجه للتركيز والإنتاجية. من الطلاب الذين يبحثون عن مكان هادئ للدراسة، 
                        إلى رواد الأعمال الذين يحتاجون لمساحة احترافية، والفريلانسرز الذين يريدون بيئة عمل مريحة.
                    </p>
                    <ul class="about-features">
                        <li><i class="bi bi-wifi"></i>إنترنت عالي السرعة مجاني</li>
                        <li><i class="bi bi-lightbulb"></i>إضاءة طبيعية وصناعية مثالية</li>
                        <li><i class="bi bi-thermometer-half"></i>تكييف هواء مريح على مدار الساعة</li>
                        <li><i class="bi bi-cup-hot"></i>مشروبات ساخنة وباردة متاحة</li>
                        <li><i class="bi bi-shield-check"></i>أمان وخصوصية مضمونة</li>
                        <li><i class="bi bi-people"></i>مجتمع عمل إيجابي ومحفز</li>
                    </ul>
                </div>
                <div class="about-image">
                    <img src="{{ asset('images/space.jpeg') }}" alt="Branch Hub Workspace" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Plans Section -->
    <section id="plans" class="plans-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>خطط الحجز</h2>
                <p>اختر الخطة التي تناسب احتياجاتك وميزانيتك</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="plan-card smart-hover">
                        <div class="plan-icon tech-pulse">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <h3 class="plan-title">حجز يومي</h3>
                        <!-- <div class="plan-price">30₪</div> -->
                        <div class="plan-period">لليوم الواحد</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle"></i> 8 ساعات عمل يومية
                    </li>
                            <li><i class="bi bi-check-circle"></i>إنترنت عالي السرعة</li>
                            <li><i class="bi bi-check-circle"></i>مشروب ساخن مجاني</li>
                             <li><i class="bi bi-check-circle"></i>خدمة عملاء 24/8</li>
                        </ul>
                        <a href="{{ route('booking.form') }}" class="btn-plan">احجز الآن</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="plan-card featured smart-hover">
                        <div class="plan-icon tech-pulse ai-glow">
                            <i class="bi bi-calendar-week"></i>
                        </div>
                        <h3 class="plan-title">حجز أسبوعي</h3>
                        <!-- <div class="plan-price">150₪</div> -->
                        <div class="plan-period">للأسبوع (6 أيام)</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle"></i>وصول غير محدود</li>
                            <li><i class="bi bi-check-circle"></i>إنترنت عالي السرعة</li>
                            <li><i class="bi bi-check-circle"></i>مقعد مخصص</li>
                            <li><i class="bi bi-check-circle"></i>خدمة عملاء متميزة</li>
                        </ul>
                        <a href="{{ route('booking.form') }}" class="btn-plan">احجز الآن</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="plan-card smart-hover">
                        <div class="plan-icon tech-pulse">
                            <i class="bi bi-calendar-month"></i>
                        </div>
                        <h3 class="plan-title">حجز شهري</h3>
                        <!-- <div class="plan-price">550₪</div> -->
                        <div class="plan-period">للشهر (30 يوم)</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle"></i>قاعة VIP</li>
                            <li><i class="bi bi-check-circle"></i>إنترنت عالي السرعة</li>
                            <li><i class="bi bi-check-circle"></i>قاعة اجتماع اون لاين مخصصة</li>
                            <li><i class="bi bi-check-circle"></i>مقعد مخصص دائم</li>
                            <li><i class="bi bi-check-circle"></i>السماح للأجهزةالإضافية</li>
                            <li><i class="bi bi-check-circle"></i>دعوات للفعاليات الخاصة</li>
                        </ul>
                        <a href="{{ route('booking.form') }}" class="btn-plan">احجز الآن</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Target Audience Section -->
    <section id="audience" class="audience-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>مناسب لجميع الفئات</h2>
                <p>مساحة عمل مصممة لتناسب احتياجات الجميع</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="audience-card smart-hover">
                        <div class="audience-icon tech-pulse">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <h4>الطلاب</h4>
                        <p>بيئة هادئة ومريحة للدراسة والبحث. إنترنت سريع ومقاعد مريحة لساعات طويلة من التركيز.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="audience-card smart-hover">
                        <div class="audience-icon tech-pulse">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <h4>رواد الأعمال</h4>
                        <p>مساحة احترافية لعقد الاجتماعات وتطوير المشاريع. بيئة محفزة للابتكار والإبداع.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="audience-card smart-hover">
                        <div class="audience-icon tech-pulse">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <h4>الفريلانسرز</h4>
                        <p>مساحة عمل مرنة ومناسبة للعمل عن بُعد. إنترنت مستقر وبيئة مريحة للإنتاجية العالية.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="location" class="location-section">
        <div class="container">
            <div class="location-content" data-aos="fade-up">
                <h2>موقعنا في قطاع غزة</h2>
                <p>
                    نحن فخورون بكوننا جزءاً من مجتمع قطاع غزة النابض بالحياة. موقعنا الاستراتيجي 
                    يسهل الوصول إلينا من جميع أنحاء القطاع، مما يجعلنا الخيار الأمثل لمساحة العمل.
                </p>
                <div class="location-info">
                    <h4><i class="bi bi-geo-alt-fill me-2"></i>موقعنا</h4>
                    <p class="mb-0">فلسطين غزة الرمال عمارة مشتهى</p>
                    <p class="mb-0">
                        <i class="bi bi-geo-alt me-2"></i>
                        الإحداثيات: 31.522347, 34.448569
                    </p>
                    <div class="mt-3">
                        <a href="https://maps.google.com/?q=31.522347,34.448569" target="_blank" class="btn-custom">
                            <i class="bi bi-map"></i>
                            عرض على خرائط جوجل
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>تواصل معنا</h2>
                <p>نحن هنا لمساعدتك في كل ما تحتاجه. تواصل معنا عبر أي من الطرق التالية</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h4>اتصل بنا</h4>
                        <p>للاستفسارات السريعة والمباشرة</p>
                        <a href="tel:+972592782897" class="contact-link">
                            <i class="bi bi-telephone me-2"></i>
                            +972 59 278 2897
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <h4>واتساب</h4>
                        <p>للمحادثات والاستفسارات التفصيلية</p>
                        <a href="https://wa.me/972592782897" target="_blank" class="contact-link">
                            <i class="bi bi-whatsapp me-2"></i>
                            +972 59 278 2897
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="bi bi-instagram"></i>
                        </div>
                        <h4>انستجرام</h4>
                        <p>لمتابعة آخر الأخبار والصور</p>
                        <a href="https://www.instagram.com/branchspaces/" target="_blank" class="contact-link">
                            <i class="bi bi-instagram me-2"></i>
                            @branchspaces
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>ابدأ رحلتك معنا اليوم</h2>
                <p>
                    انضم إلى مجتمع Branch Hub واستمتع بتجربة عمل استثنائية. 
                    احجز مقعدك الآن وابدأ رحلتك نحو الإنتاجية والنجاح.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('booking.form') }}" class="btn-hero btn-primary-hero smart-hover">
                        <i class="bi bi-calendar-check me-2"></i>
                        احجز مقعدك الآن
                    </a>
                    <a href="#plans" class="btn-hero btn-outline-hero smart-hover">
                        <i class="bi bi-info-circle me-2"></i>
                        شاهد الخطط
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Branch Hub Logo" style="width: 50px; height: 50px; border-radius: 50%; margin-left: 10px;">
                    <span class="orbitron-bold orbitron-text medium">Branch Hub</span>
                </div>
                <p class="footer-text">
                    مساحة العمل المثالية في قطاع غزة<br>
                    جميع الحقوق محفوظة &copy; {{ date('Y') }}
                </p>
                
                <!-- Footer Contact Links -->
                <div class="mt-3">
                    <div class="d-flex justify-content-center gap-3">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Force font loading
        document.fonts.ready.then(function () {
            console.log('Fonts loaded');
            // Force reflow to apply fonts
            document.querySelectorAll('.orbitron-text, .orbitron-bold, .orbitron-heavy, .orbitron-medium').forEach(function(element) {
                element.style.fontFamily = '"Orbitron", sans-serif';
            });
            document.querySelectorAll('.tektur-text, .tektur-bold, .tektur-heavy, .tektur-medium').forEach(function(element) {
                element.style.fontFamily = '"Tektur", sans-serif';
            });
        });
        
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
