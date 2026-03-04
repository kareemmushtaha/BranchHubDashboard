@extends('layouts.public')

@section('title', 'أكاديمية Branch Hub - المدربون')

@section('meta_description', 'تعرّف على نخبة المدربين والخبراء الأكاديميين في أكاديمية Branch Hub')

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
            font-family: "Orbitron", sans-serif !important;
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
            align-items: center;
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

        /* Leaders Section */
        .leaders-section {
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

        .filter-bar .search-input {
            border-radius: 15px;
            border: 2px solid #e5e7eb;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .filter-bar .search-input:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.15);
        }

        .filter-bar .btn-search {
            border-radius: 15px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #ffffff;
            border: none;
            transition: all 0.3s ease;
        }

        .filter-bar .btn-search:hover {
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.3);
            transform: translateY(-2px);
        }

        /* Leader Cards */
        .leader-card {
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

        .leader-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(30, 64, 175, 0.3);
        }

        .leader-image-wrapper {
            position: relative;
            aspect-ratio: 16/10;
            overflow: hidden;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .leader-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .leader-card:hover .leader-image-wrapper img {
            transform: scale(1.1);
        }

        .leader-image-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: rgba(255, 255, 255, 0.7);
            font-size: 5rem;
            font-weight: 700;
        }

        .courses-count-badge {
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

        .courses-count-badge .count {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e40af;
            font-family: monospace;
        }

        .courses-count-badge .label {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .leader-body {
            padding: 2rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .leader-title-badge {
            display: inline-block;
            padding: 0.375rem 1rem;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 1px solid #bae6fd;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #0c4a6e;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .leader-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .leader-name a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .leader-name a:hover {
            color: #1e40af;
        }

        .leader-bio {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            flex-grow: 1;
            line-height: 1.7;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .leader-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .leader-meta {
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

        .meta-item.courses i { color: #1e40af; }
        .meta-item.linkedin i { color: #0a66c2; }

        .btn-view-profile {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.8rem;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            white-space: nowrap;
        }

        .btn-view-profile:hover {
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
            transform: translateY(-2px);
            color: #ffffff;
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
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
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
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            border: none;
            color: white;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(30, 58, 138, 0.3);
            color: white;
        }

        /* ===== Modern Pagination ===== */
        .pagination-wrapper {
            margin-top: 3.5rem;
        }

        .modern-pagination {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
        }

        .modern-pagination-list {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
            padding: 1rem 1.5rem;
            background: var(--white);
            border-radius: 50px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(30, 64, 175, 0.08);
        }

        .modern-page-item .modern-page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            padding: 0 0.25rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            cursor: pointer;
            position: relative;
        }

        .modern-page-item .modern-page-link:hover {
            color: #1e40af;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-color: rgba(30, 64, 175, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.12);
        }

        .modern-page-item.active .modern-page-link {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.35);
            transform: translateY(-2px);
        }

        .modern-page-item.active .modern-page-link:hover {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.45);
            color: #ffffff;
        }

        .modern-page-item.disabled .modern-page-link {
            color: #d1d5db;
            cursor: not-allowed;
            pointer-events: none;
        }

        .modern-page-item.disabled .modern-page-link:hover {
            background: transparent;
            border-color: transparent;
            transform: none;
            box-shadow: none;
        }

        .modern-page-item.nav-arrow .modern-page-link {
            min-width: 48px;
            height: 48px;
            border-radius: 50%;
            font-size: 1.1rem;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
        }

        .modern-page-item.nav-arrow .modern-page-link:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.3);
        }

        .modern-page-item.nav-arrow.disabled .modern-page-link {
            background: #f9fafb;
            border-color: #f3f4f6;
            color: #d1d5db;
        }

        .modern-page-item.dots .modern-page-link {
            min-width: 36px;
            color: #9ca3af;
            letter-spacing: 2px;
            cursor: default;
        }

        .modern-page-item.dots .modern-page-link:hover {
            background: transparent;
            border-color: transparent;
            transform: none;
            box-shadow: none;
            color: #9ca3af;
        }

        .modern-pagination-info {
            font-size: 0.875rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modern-pagination-info strong {
            color: #1e40af;
            font-weight: 700;
        }

        .modern-pagination-divider {
            color: #d1d5db;
            margin: 0 0.25rem;
        }

        @media (max-width: 640px) {
            .modern-pagination-list {
                gap: 0.25rem;
                padding: 0.75rem 1rem;
                border-radius: 20px;
            }

            .modern-page-item .modern-page-link {
                min-width: 38px;
                height: 38px;
                font-size: 0.85rem;
                border-radius: 10px;
            }

            .modern-page-item.nav-arrow .modern-page-link {
                min-width: 42px;
                height: 42px;
            }

            .modern-page-item.dots .modern-page-link {
                min-width: 28px;
            }
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

            .leader-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .leader-meta {
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
                    <span style="font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">فريق المدربين</span>
                </div>

                <h1 class="hero-title">
                    OUR <span class="accent-text">INSTRUCTORS</span>
                </h1>

                <p class="hero-subtitle">
                    تعرّف على نخبة الخبراء والمدربين الذين يقودون رحلتك التعليمية في أكاديمية Branch Hub
                </p>

                <div class="hero-stats">
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-icon red">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <span class="stat-number">{{ $leaders->total() }}</span>
                        <span class="stat-label">مدرب متميز</span>
                    </div>
                    <div class="stat-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-icon blue">
                            <i class="bi bi-mortarboard-fill"></i>
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

    <!-- Leaders Section -->
    <section class="leaders-section">
        <div class="container">
            <!-- Filter Bar -->
            <div class="filter-bar" data-aos="fade-up">
                <form method="GET" action="{{ route('public.leaders.index') }}" class="d-flex align-items-center gap-4 flex-wrap">
                    <label for="search" class="fw-bold text-dark" style="white-space: nowrap;">بحث عن مدرب:</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control search-input flex-grow-1" style="max-width: 350px;" placeholder="اسم المدرب أو التخصص...">
                    <button type="submit" class="btn btn-search">
                        <i class="bi bi-search me-2"></i>بحث
                    </button>
                </form>
            </div>

            <!-- Leaders Grid -->
            @if($leaders->count() > 0)
                <div class="row g-4">
                    @foreach($leaders as $leader)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="leader-card">
                                <!-- Leader Image -->
                                <div class="leader-image-wrapper">
                                    <a href="{{ route('public.leaders.show', $leader) }}">
                                        @if($leader->photo)
                                            <img src="{{ asset('storage/app/public/' . $leader->photo) }}" alt="{{ $leader->name }}">
                                        @else
                                            <div class="leader-image-placeholder">
                                                {{ mb_substr($leader->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Courses Count Badge -->
                                    @if($leader->courses_count > 0)
                                        <div class="courses-count-badge">
                                            <div class="label">الدورات</div>
                                            <div class="count">{{ $leader->courses_count }}</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Leader Body -->
                                <div class="leader-body">
                                    <!-- Job Title Badge -->
                                    @if($leader->job_title)
                                        <span class="leader-title-badge">{{ $leader->job_title }}</span>
                                    @endif

                                    <!-- Leader Name -->
                                    <h3 class="leader-name">
                                        <a href="{{ route('public.leaders.show', $leader) }}">{{ $leader->name }}</a>
                                    </h3>

                                    <!-- Leader Bio -->
                                    @if($leader->job_description)
                                        <p class="leader-bio">{{ Str::limit($leader->job_description, 150) }}</p>
                                    @else
                                        <p class="leader-bio">متخصص في مجال التدريب الأكاديمي والتطوير المهني بخبرة واسعة في تقديم المحتوى التعليمي المتميز.</p>
                                    @endif

                                    <!-- Leader Footer -->
                                    <div class="leader-footer">
                                        <div class="leader-meta">
                                            <div class="meta-item courses">
                                                <i class="bi bi-journal-bookmark-fill"></i>
                                                <span>{{ $leader->courses_count }} {{ $leader->courses_count == 1 ? 'دورة' : 'دورات' }}</span>
                                            </div>
                                            @if($leader->linkedin)
                                                <a href="{{ $leader->linkedin }}" target="_blank" class="meta-item linkedin text-decoration-none">
                                                    <i class="bi bi-linkedin"></i>
                                                    <span>LinkedIn</span>
                                                </a>
                                            @endif
                                        </div>
                                        <a href="{{ route('public.leaders.show', $leader) }}" class="btn-view-profile">
                                            <i class="bi bi-person-lines-fill"></i>
                                            الملف الشخصي
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $leaders->links('custom.pagination.modern') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3 class="empty-title">لا يوجد مدربون حالياً</h3>
                    <p class="empty-text">يرجى المحاولة في وقت لاحق أو تغيير خيارات البحث.</p>
                    @if(request('search'))
                        <a href="{{ route('public.leaders.index') }}" class="btn-primary-custom">
                            <i class="bi bi-grid-fill"></i>
                            عرض جميع المدربين
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
