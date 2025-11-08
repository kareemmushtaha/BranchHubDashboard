<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مساحة العمل - نظام إدارة بسيط وسريع</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        :root {
            --primary: #4f46e5;
            --secondary: #06b6d4;
            --success: #10b981;
            --text: #374151;
            --text-light: #6b7280;
            --bg: #f9fafb;
        }
        
        body {
            margin: 0;
            padding: 0;
            background: var(--bg);
            color: var(--text);
        }
        
        /* Header */
        .header {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        /* Hero */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-primary-custom {
            background: white;
            color: var(--primary);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            background: var(--bg);
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        /* Features */
        .features {
            padding: 4rem 0;
        }
        
        .feature {
            text-align: center;
            padding: 2rem 1rem;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }
        
        .feature h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .feature p {
            color: var(--text-light);
            margin-bottom: 0;
        }
        
        /* CTA */
        .cta {
            background: var(--text);
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .btn-outline-custom {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: white;
            color: var(--text);
        }
        
        /* Footer */
        .footer {
            background: var(--bg);
            padding: 2rem 0;
            text-align: center;
            color: var(--text-light);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .cta h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="logo">
                    <i class="bi bi-building me-2"></i>
                    مساحة العمل
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary">تسجيل الدخول</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>مساحة العمل البسيطة</h1>
            <p>نظام إدارة سهل وسريع للجلسات والمشروبات. حل بسيط وفعال لإدارة مساحة العمل الخاصة بك.</p>
            <a href="{{ route('login') }}" class="btn-primary-custom">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                ابدأ الآن
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h4>إدارة الجلسات</h4>
                        <p>تتبع الجلسات والوقت بسهولة</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="bi bi-cup-hot"></i>
                        </div>
                        <h4>إدارة المشروبات</h4>
                        <p>تتبع المشروبات والطلبات</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h4>نظام الدفع</h4>
                        <p>إدارة المدفوعات والمحاسبة</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>إدارة المستخدمين</h4>
                        <p>إدارة المستخدمين والاشتراكات</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>جاهز للبدء؟</h2>
            <p>انضم إلينا اليوم واستمتع بنظام إدارة بسيط وفعال</p>
            <a href="{{ route('login') }}" class="btn-outline-custom">
                <i class="bi bi-rocket-takeoff me-2"></i>
                ابدأ مجاناً
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">
                نظام إدارة مساحة العمل &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
