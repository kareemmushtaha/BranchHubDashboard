@extends('layouts.public')

@section('title', $leader->name . ' - Branch Hub الأكاديمية')

@section('meta_description', Str::limit($leader->job_description ?? $leader->job_title ?? 'الملف الشخصي للقائد', 160))

@section('styles')
<style>
    :root {
        --academic-blue: #1e40af;
        --academic-blue-dark: #1e3a8a;
        --academic-red: #a40206;
    }

    /* === Hero Section === */
    .leader-hero {
        background: linear-gradient(135deg,rgb(104, 19, 19) 0%, #000 40%, #661e1e 100%);
        position: relative;
        padding: 6rem 0 4rem;
        overflow: hidden;
        color: #fff;
    }

    .leader-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.6;
    }

    .leader-hero .container {
        position: relative;
        z-index: 2;
    }

    .leader-photo-wrapper {
        position: relative;
        display: inline-block;
    }

    .leader-photo {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        transition: transform 0.4s ease;
    }

    .leader-photo:hover {
        transform: scale(1.05);
    }

    .leader-photo-placeholder {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        border: 5px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .leader-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        border: 3px solid #fff;
    }

    .leader-badge i {
        color: #fff;
        font-size: 1.1rem;
    }

    .leader-name {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }

    .leader-job-title {
        font-size: 1.2rem;
        opacity: 0.9;
        font-weight: 400;
    }

    .leader-hero-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .hero-btn-linkedin {
        background: #0077b5;
        color: #fff;
        border: 2px solid #0077b5;
    }

    .hero-btn-linkedin:hover {
        background: #005f8d;
        border-color: #005f8d;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 119, 181, 0.4);
    }

    .hero-btn-email {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .hero-btn-email:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: #fff;
        color: #fff;
        transform: translateY(-2px);
    }

    /* === Stats Bar === */
    .stats-bar {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-top: -2.5rem;
        position: relative;
        z-index: 3;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--academic-red);
    }

    .stat-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
    }

    /* === Content Sections === */
    .section-card {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--academic-red);
        font-size: 1.2rem;
    }

    /* === Info Table === */
    .info-table {
        width: 100%;
    }

    .info-table tr {
        border-bottom: 1px solid #f3f4f6;
    }

    .info-table tr:last-child {
        border-bottom: none;
    }

    .info-table th {
        padding: 0.85rem 0;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.9rem;
        width: 140px;
        vertical-align: top;
    }

    .info-table td {
        padding: 0.85rem 0;
        color: #1f2937;
        font-weight: 400;
    }

    /* === CV Content === */
    .cv-content {
        line-height: 1.9;
        color: #374151;
        font-size: 1rem;
    }

    .cv-content p {
        margin-bottom: 1rem;
    }

    .cv-content ul, .cv-content ol {
        padding-right: 1.5rem;
        margin-bottom: 1rem;
    }

    /* === Courses Grid === */
    .course-card-mini {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .course-card-mini:hover {
        background: #fff;
        border-color: var(--academic-blue);
        box-shadow: 0 8px 25px rgba(30, 64, 175, 0.12);
        transform: translateY(-3px);
        color: inherit;
    }

    .course-card-mini h6 {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .course-card-mini:hover h6 {
        color: var(--academic-blue);
    }

    .course-card-mini .course-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: #6b7280;
    }

    /* === Back Button === */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: #fff;
    }

    /* === Responsive === */
    @media (max-width: 768px) {
        .leader-hero {
            padding: 4rem 0 3rem;
            text-align: center;
        }

        .leader-name {
            font-size: 1.75rem;
        }

        .leader-photo, .leader-photo-placeholder {
            width: 140px;
            height: 140px;
        }

        .leader-hero-actions {
            justify-content: center;
        }

        .stats-bar {
            gap: 1.5rem;
            padding: 1.25rem;
        }

        .stat-value {
            font-size: 1.4rem;
        }

        .section-card {
            padding: 1.25rem;
        }

        .info-table th {
            width: 110px;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="leader-hero">
        <div class="container">
            <a href="javascript:history.back()" class="back-link">
                <i class="bi bi-arrow-right"></i> العودة
            </a>

            <div class="row align-items-center" data-aos="fade-up">
                <div class="col-md-auto text-center text-md-start mb-4 mb-md-0">
                    <div class="leader-photo-wrapper">
                        @if($leader->photo)
                            <img src="{{ asset('storage/' . $leader->photo) }}" alt="{{ $leader->name }}" class="leader-photo">
                        @else
                            <div class="leader-photo-placeholder">
                                {{ mb_substr($leader->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="leader-badge">
                            <i class="bi bi-award-fill"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md text-center text-md-start">
                    <h1 class="leader-name">{{ $leader->name }}</h1>
                    @if($leader->job_title)
                        <p class="leader-job-title"><i class="bi bi-briefcase me-2"></i>{{ $leader->job_title }}</p>
                    @endif

                    <div class="leader-hero-actions">
                        @if($leader->linkedin)
                            <a href="{{ $leader->linkedin }}" target="_blank" class="hero-btn hero-btn-linkedin">
                                <i class="bi bi-linkedin"></i> LinkedIn
                            </a>
                        @endif
                        @if($leader->email)
                            <a href="mailto:{{ $leader->email }}" class="hero-btn hero-btn-email">
                                <i class="bi bi-envelope"></i> تواصل معنا
                            </a>
                        @endif
                        @if($leader->phone)
                            <a href="tel:{{ $leader->phone }}" class="hero-btn hero-btn-email">
                                <i class="bi bi-telephone"></i> {{ $leader->phone }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="container">
        <div class="stats-bar" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-item">
                <div class="stat-value">{{ $leader->courses_count }}</div>
                <div class="stat-label">الدورات</div>
            </div>
            @if($leader->job_title)
            <div class="stat-item">
                <div class="stat-value"><i class="bi bi-briefcase" style="font-size: 1.5rem;"></i></div>
                <div class="stat-label">{{ $leader->job_title }}</div>
            </div>
            @endif
            @if($leader->linkedin)
            <div class="stat-item">
                <div class="stat-value"><i class="bi bi-linkedin" style="font-size: 1.5rem;"></i></div>
                <div class="stat-label">متصل على LinkedIn</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Right Column: Bio & CV -->
            <div class="col-lg-8 mb-4">
                @if($leader->job_description)
                <div class="section-card" data-aos="fade-up" data-aos-delay="150">
                    <h3 class="section-title"><i class="bi bi-person-lines-fill"></i> نبذة تعريفية</h3>
                    <p style="color: #374151; line-height: 1.9; font-size: 1.05rem;">{{ $leader->job_description }}</p>
                </div>
                @endif

                @if($leader->cv)
                <div class="section-card" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="section-title"><i class="bi bi-file-text"></i> السيرة الذاتية</h3>
                    <div class="cv-content">{!! $leader->cv !!}</div>
                </div>
                @endif

                @if($leader->courses->count() > 0)
                <div class="section-card" data-aos="fade-up" data-aos-delay="250">
                    <h3 class="section-title"><i class="bi bi-journal-bookmark"></i> الدورات ({{ $leader->courses->count() }})</h3>
                    <div class="row g-3">
                        @foreach($leader->courses as $course)
                            <div class="col-md-6">
                                <a href="{{ $course->slug ? route('public.courses.show', $course->slug) : '#' }}" class="course-card-mini">
                                    <h6>{{ $course->title }}</h6>
                                    @if($course->short_description)
                                        <p class="text-muted small mb-2">{{ Str::limit($course->short_description, 80) }}</p>
                                    @endif
                                    <div class="course-meta">
                                        @if($course->price)
                                            <span><i class="bi bi-tag me-1"></i>{{ $course->price }} ₪</span>
                                        @endif
                                        @if($course->duration_hours)
                                            <span><i class="bi bi-clock me-1"></i>{{ $course->duration_hours }} ساعة</span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Left Column: Contact Info -->
            <div class="col-lg-4 mb-4">
                <div class="section-card" data-aos="fade-up" data-aos-delay="150">
                    <h3 class="section-title"><i class="bi bi-info-circle"></i> معلومات التواصل</h3>
                    <table class="info-table">
                        <tbody>
                            @if($leader->email)
                            <tr>
                                <th><i class="bi bi-envelope me-1"></i> البريد</th>
                                <td><a href="mailto:{{ $leader->email }}" style="color: var(--academic-red);">{{ $leader->email }}</a></td>
                            </tr>
                            @endif
                            @if($leader->phone)
                            <tr>
                                <th><i class="bi bi-telephone me-1"></i> الهاتف</th>
                                <td dir="ltr" class="text-end">{{ $leader->phone }}</td>
                            </tr>
                            @endif
                             
                            @if($leader->job_title)
                            <tr>
                                <th><i class="bi bi-briefcase me-1"></i> الوظيفة</th>
                                <td>{{ $leader->job_title }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if($leader->linkedin)
                <div class="section-card text-center" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ $leader->linkedin }}" target="_blank" class="hero-btn hero-btn-linkedin w-100 justify-content-center" style="font-size: 1rem; padding: 0.85rem;">
                        <i class="bi bi-linkedin"></i> تواصل عبر LinkedIn
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
