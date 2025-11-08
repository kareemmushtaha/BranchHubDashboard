<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مساحة العمل المتطورة - نظام إدارة الجلسات والمشروبات</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <style>
        * {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-dark: #1f2937;
            --text-light: #6b7280;
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
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/><circle cx="600" cy="100" r="80" fill="url(%23a)"/><circle cx="100" cy="600" r="90" fill="url(%23a)"/></svg>');
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            font-weight: 400;
            max-width: 600px;
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
            background: var(--white);
            color: var(--primary-color);
            border-color: var(--white);
        }
        
        .btn-primary-hero:hover {
            background: transparent;
            color: var(--white);
            border-color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 255, 255, 0.3);
        }
        
        .btn-outline-hero {
            background: transparent;
            color: var(--white);
            border-color: var(--white);
        }
        
        .btn-outline-hero:hover {
            background: var(--white);
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 255, 255, 0.3);
        }
        
        /* Features Section */
        .features-section {
            padding: 6rem 0;
            background: var(--bg-light);
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
        
        .feature-card {
            background: var(--white);
            border-radius: 25px;
            padding: 3rem 2.5rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.4s ease;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-lg);
        }
        
        .feature-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .feature-card h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }
        
        .feature-card p {
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 0;
            font-size: 1.1rem;
        }
        
        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 5rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .stats-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
            opacity: 0.2;
        }
        
        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 2;
        }
        
        .stat-number {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            display: block;
            background: linear-gradient(135deg, var(--white), rgba(255, 255, 255, 0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 500;
        }
        
        /* Testimonials Section */
        .testimonials-section {
            padding: 6rem 0;
            background: var(--white);
        }
        
        .testimonial-card {
            background: var(--bg-light);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }
        
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
        }
        
        .testimonial-text {
            font-size: 1.1rem;
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 2rem;
            font-style: italic;
        }
        
        .testimonial-author {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .testimonial-role {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--white) 100%);
        }
        
        .cta-content {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .cta-content h2 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2rem;
        }
        
        .cta-content p {
            font-size: 1.3rem;
            color: var(--text-light);
            margin-bottom: 3rem;
            line-height: 1.7;
        }
        
        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer-logo {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }
        
        .footer-text {
            opacity: 0.8;
            margin-bottom: 0;
            font-size: 1.1rem;
        }
        
        .footer-links {
            margin: 2rem 0;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        
        .footer-links a:hover {
            opacity: 1;
            color: var(--primary-color);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-hero {
                width: 100%;
                max-width: 300px;
            }
            
            .section-title h2 {
                font-size: 2.2rem;
            }
            
            .feature-card {
                margin-bottom: 2rem;
            }
            
            .stat-number {
                font-size: 3rem;
            }
            
            .cta-content h2 {
                font-size: 2.2rem;
            }
        }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-building me-2"></i>
                مساحة العمل
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">المميزات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">الإحصائيات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">آراء العملاء</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                    <a href="#cta" class="btn btn-primary">ابدأ الآن</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                        <div class="floating">
                            <i class="bi bi-building fs-1 mb-4"></i>
                        </div>
                        <h1 class="hero-title">مساحة العمل الذكية</h1>
                        <p class="hero-subtitle">
                            نظام متكامل لإدارة الجلسات والمشروبات مع تقنيات حديثة وسهولة في الاستخدام. 
                            احصل على تجربة إدارة متطورة وآمنة لمساحة العمل الخاصة بك.
                        </p>
                        <div class="hero-buttons">
                            <a href="{{ route('login') }}" class="btn-hero btn-primary-hero">
                                <i class="bi bi-rocket-takeoff me-2"></i>
                                ابدأ الآن
                            </a>
                            <a href="#features" class="btn-hero btn-outline-hero">
                                <i class="bi bi-play-circle me-2"></i>
                                شاهد العرض
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                    <div class="text-center">
                        <div class="pulse">
                            <i class="bi bi-laptop display-1 text-white opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>مميزات النظام المتطورة</h2>
                <p>نقدم لك حلول متكاملة وإدارة ذكية لمساحة العمل مع تقنيات حديثة</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h4>إدارة الجلسات الذكية</h4>
                        <p>نظام متطور لإدارة الجلسات الساعية والاشتراكات مع تتبع دقيق للوقت والتكلفة والتحكم الكامل في العمليات</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-cup-hot"></i>
                        </div>
                        <h4>إدارة المشروبات المتقدمة</h4>
                        <p>تتبع شامل للمشروبات والطلبات مع إدارة المخزون والأسعار بشكل تلقائي ونظام طلبات ذكي</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h4>نظام الدفع المتكامل</h4>
                        <p>حلول دفع متعددة مع إدارة المحفظة الإلكترونية والفواتير التلقائية وتتبع المدفوعات</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>إدارة المستخدمين الشاملة</h4>
                        <p>نظام شامل لإدارة المستخدمين والاشتراكات مع تتبع تاريخ الاستخدام وإدارة الصلاحيات</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4>التقارير والإحصائيات المتقدمة</h4>
                        <p>تقارير مفصلة وإحصائيات شاملة مع رسوم بيانية تفاعلية لمساعدتك في اتخاذ القرارات الصحيحة</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>الأمان والحماية المتقدمة</h4>
                        <p>نظام أمان متقدم مع تشفير البيانات وحماية شاملة للمعلومات الحساسة ومراقبة النشاطات</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats-section">
        <div class="stats-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <div class="stat-label">جلسة نشطة</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <span class="stat-number">2500+</span>
                        <div class="stat-label">مستخدم مسجل</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <span class="stat-number">100+</span>
                        <div class="stat-label">نوع مشروب</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <span class="stat-number">99.9%</span>
                        <div class="stat-label">وقت التشغيل</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>آراء عملائنا</h2>
                <p>اكتشف ما يقوله عملاؤنا عن تجربتهم مع نظامنا</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <p class="testimonial-text">
                            "نظام رائع وسهل الاستخدام. ساعدني في إدارة مساحة العمل بكفاءة عالية وتوفير الوقت والجهد."
                        </p>
                        <div class="testimonial-author">أحمد محمد</div>
                        <div class="testimonial-role">مدير مساحة عمل</div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <p class="testimonial-text">
                            "التقارير والإحصائيات مفيدة جداً. تساعدني في اتخاذ قرارات صحيحة لتحسين الخدمة."
                        </p>
                        <div class="testimonial-author">فاطمة علي</div>
                        <div class="testimonial-role">مالكة مقهى</div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <p class="testimonial-text">
                            "الدعم الفني ممتاز والنظام مستقر جداً. أنصح به بشدة لأي شخص يريد إدارة احترافية."
                        </p>
                        <div class="testimonial-author">محمد حسن</div>
                        <div class="testimonial-role">مدير مركز خدمات</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>ابدأ رحلتك معنا اليوم</h2>
                <p>
                    انضم إلى آلاف المستخدمين الذين يثقون في نظامنا لإدارة مساحة العمل الخاصة بهم. 
                    استمتع بتجربة سهلة وآمنة مع دعم فني متواصل وتحديثات مستمرة.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn-hero btn-primary-hero">
                        <i class="bi bi-rocket-takeoff me-2"></i>
                        ابدأ الآن مجاناً
                    </a>
                    <a href="#features" class="btn-hero btn-outline-hero">
                        <i class="bi bi-info-circle me-2"></i>
                        تعرف على المزيد
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
                    <i class="bi bi-building me-2"></i>
                    مساحة العمل المتطورة
                </div>
                <div class="footer-links">
                    <a href="#features">المميزات</a>
                    <a href="#stats">الإحصائيات</a>
                    <a href="#testimonials">آراء العملاء</a>
                    <a href="{{ route('login') }}">تسجيل الدخول</a>
                </div>
                <p class="footer-text">
                    نظام إدارة الجلسات والمشروبات المتطور<br>
                    جميع الحقوق محفوظة &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
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
        
        // Counter animation for stats
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    
                    if (counter.textContent.includes('+')) {
                        counter.textContent = Math.floor(current) + '+';
                    } else if (counter.textContent.includes('%')) {
                        counter.textContent = Math.floor(current) + '%';
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 16);
            });
        }
        
        // Trigger counter animation when stats section is visible
        const statsSection = document.querySelector('.stats-section');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        if (statsSection) {
            observer.observe(statsSection);
        }
        
        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>
