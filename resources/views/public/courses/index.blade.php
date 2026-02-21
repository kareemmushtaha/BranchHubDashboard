@extends('layouts.public')

@section('title', 'أكاديمية Branch Hub - الدورات التدريبية')

@section('meta_description', 'طور مهاراتك وانطلق نحو الاحتراف مع نخبة من أفضل المدربين في بيئة تعليمية متكاملة')

@section('styles')
    <style>
        :root {
            
            --secondary-color:rgb(96, 90, 91);
            --accent-color: #f093fb;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #40424a 0%, #1a0f10 50%, #6a1010 100%);
            min-height: 70vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 8rem 0 4rem;
            margin-top: -70px;
            padding-top: 150px;
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .hero-badge .pulse-dot {
            width: 8px;
            height: 8px;
            background: var(--accent-red);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            font-family:"Orbitron", sans-serif !important;
        }

        .hero-title .accent-text {
            color: var(--accent-red);
            font-family: "Orbitron", sans-serif !important;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            font-weight: 400;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            min-width: 150px;
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            /* display: flex; */
            align-items: center;
            justify-center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .stat-icon.red { background: rgba(220, 38, 38, 0.2); color: #fca5a5; }
        .stat-icon.blue { background: rgba(59, 130, 246, 0.2); color: #93c5fd; }
        .stat-icon.green { background: rgba(34, 197, 94, 0.2); color: #86efac; }

        .stat-number {
            display: block;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        /* Courses Section */
        .courses-section {
            padding: 4rem 0;
            background: var(--bg-light);
        }

        /* Filter Bar */
        .filter-bar {
            background: var(--white);
            border-radius: 25px;
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 3rem;
        }

        .filter-bar select {
            border-radius: 15px;
            border: 2px solid #e5e7eb;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .filter-bar select:focus {
            outline: none;
            border: color #000;
            box-shadow: 0 0 0 4px #667eea;
        }

        /* Course Cards */
        .course-card {
            background: var(--white);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 2px solid transparent;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .course-image-wrapper {
            position: relative;
            aspect-ratio: 16/10;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .course-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover .course-image-wrapper img {
            transform: scale(1.1);
        }

        .price-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.25rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .price-badge .price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--accent-red);
            font-family: monospace;
        }

        .price-badge .currency {
            font-size: 0.75rem;
            color: var(--text-light);
            text-transform: uppercase;
        }

        .course-body {
            padding: 2rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .category-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .category-badge {
            padding: 0.375rem 1rem;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 1px solid #bae6fd;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #0c4a6e;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .course-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .course-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .course-title a:hover {
            color: var(--primary-color);
        }

        .course-description {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            flex-grow: 1;
            line-height: 1.7;
        }


        .course-meta {
            display: flex;
            gap: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .meta-item i {
            font-size: 1.125rem;
        }

        .meta-item.learners i { color: #3b82f6; }
        .meta-item.rating i { color: #fbbf24; }

        .course-link-arrow {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-center;
            color: white;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .course-card:hover .course-link-arrow {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: var(--white);
            border-radius: 25px;
            box-shadow: var(--shadow);
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 3rem;
        }

        .empty-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .empty-text {
            color: var(--text-light);
            font-size: 1.125rem;
            margin-bottom: 2rem;
        }

        .btn-primary-custom {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .hero-stats {
                gap: 1rem;
            }

            .stat-box {
                min-width: 120px;
                padding: 1rem 1.5rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .course-meta {
                gap: 1rem;
            }
        }
    </style>
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <div class="hero-badge">
                    <span class="pulse-dot"></span>
                    <span style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">أكاديمية برانش هب</span>
                </div>

                <h1 class="hero-title">
                    BRANCH <span class="accent-text">ACADEMY</span>
                </h1>

                <p class="hero-subtitle">
                    طور مهاراتك وانطلق نحو الاحتراف مع نخبة من أفضل المدربين في بيئة تعليمية متكاملة
                </p>

                <div class="hero-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-icon red">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <span class="stat-number">{{ $courses->total() }}</span>
                        <span class="stat-label">دورة تدريبية</span>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-icon blue">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <span class="stat-number">+500</span>
                        <span class="stat-label">متعلم نشط</span>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-icon green">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <span class="stat-number">100%</span>
                        <span class="stat-label">جودة معتمدة</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Courses Section -->
    <section class="courses-section">
        <div class="container">
            <!-- Filter Bar -->
            <div class="filter-bar" data-aos="fade-up">
                <form method="GET" action="{{ route('public.courses.index') }}" class="d-flex align-items-center gap-4 flex-wrap">
                    <label for="category" class="fw-bold text-dark" style="white-space: nowrap;">تصفح حسب القسم:</label>
                    <select name="category" id="category" onchange="this.form.submit()" class="form-select flex-grow-1" style="max-width: 350px;">
                        <option value="">كل الأقسام</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Courses Grid -->
            @if($courses->count() > 0)
                <div class="row g-4">
                    @foreach($courses as $course)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="course-card">
                                <!-- Course Image -->
                                <div class="course-image-wrapper">
                                    <a href="{{ route('public.courses.show', $course) }}">
                                        @if($course->thumbnail_image)
                                            <img src="{{ asset('storage/app/public/' . $course->thumbnail_image) }}" alt="{{ $course->title }}">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                                <i class="bi bi-card-image" style="font-size: 4rem; opacity: 0.5;"></i>
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Price Badge -->
                                    <div class="price-badge">
                                        <div class="currency">السعر</div>
                                        <div class="price">${{ number_format($course->price, 0) }}</div>
                                    </div>
                                </div>

                                <!-- Course Body -->
                                <div class="course-body">
                                    <!-- Category Badges -->
                                    <div class="category-badges">
                                        @foreach($course->categories->take(2) as $cat)
                                            <span class="category-badge">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>

                                    <!-- Course Title -->
                                    <h3 class="course-title">
                                        <a href="{{ route('public.courses.show', $course) }}">{{ $course->title }}</a>
                                    </h3>

                                    <!-- Course Description -->
                                    @if($course->short_description)
                                        <p class="course-description">
                                            {{ Str::limit($course->short_description, 120) }}
                                        </p>
                                    @endif

                                    <!-- Course Footer -->
                                    <div class="course-footer">
                                        <div class="course-meta">
                                            <div class="meta-item learners">
                                                <i class="bi bi-people-fill"></i>
                                                <span>{{ number_format($course->learner_count) }}</span>
                                            </div>
                                            <div class="meta-item rating">
                                                <i class="bi bi-star-fill"></i>
                                                <span>{{ $course->review_count > 0 ? number_format($course->review_count, 1) : '4.8' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($courses->hasPages())
                    <div class="pagination-wrapper">
                        {{ $courses->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3 class="empty-title">لا توجد دورات متاحة حالياً</h3>
                    <p class="empty-text">يرجى المحاولة في وقت لاحق أو تغيير خيارات البحث.</p>
                    @if(request('category'))
                        <a href="{{ route('public.courses.index') }}" class="btn-primary-custom">
                            <i class="bi bi-grid-fill"></i>
                            عرض جميع الدورات
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
