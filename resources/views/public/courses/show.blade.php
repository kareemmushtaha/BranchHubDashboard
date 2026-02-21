@extends('layouts.public')

@section('title', $course->title . ' - Branch Hub الأكاديمية')

@section('meta_description', Str::limit($course->short_description ?? $course->description, 160))

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&family=Tektur:wght@400..900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --academic-blue: #1e40af;
            --academic-blue-dark: #1e3a8a;
        }
        
        /* Orbitron Font Classes */
        .orbitron-bold {
            font-family: "Orbitron", sans-serif !important;
            font-weight: 700;
        }
        
        .orbitron-text { font-family: "Orbitron", sans-serif !important; }
        
        /* === Navigation === */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }
        
        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 1);
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
        
        /* === Premium Course Page === */
        .course-page {
            background: #ffffff;
            min-height: 100vh;
        }
        
        /* === Modern Hero Section === */
        .course-hero {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0f0f0f 100%);
            position: relative;
            padding: 6rem 0 3rem;
            overflow: hidden;
        }
        
        .course-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(220, 38, 38, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(30, 64, 175, 0.15) 0%, transparent 50%);
            opacity: 0.6;
        }
        
        .hero-bg-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            z-index: 0;
        }
        
        .course-hero .container {
            position: relative;
            z-index: 1;
        }
        
        .breadcrumb-academic {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-academic a {
            color: #a78bfa;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }
        
        .breadcrumb-academic a:hover {
            color: #c4b5fd;
        }
        
        .breadcrumb-academic .sep {
            color: #6b7280;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        @media (min-width: 768px) {
            .hero-content h1 {
                font-size: 3rem;
            }
        }
        
        .hero-subtitle {
            font-size: 1.125rem;
            color: #d1d5db;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        
        /* Category Badges */
        .category-badge {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2) 0%, rgba(30, 64, 175, 0.2) 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: #ffffff;
            font-size: 0.875rem;
            font-weight: 600;
            margin: 0.25rem;
            transition: all 0.3s ease;
        }
        
        .category-badge:hover {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.3) 0%, rgba(30, 64, 175, 0.3) 100%);
            transform: translateY(-2px);
        }
        
        /* Stats Row */
        .hero-stats {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #d1d5db;
            font-size: 0.95rem;
        }
        
        .stat-item i {
            color: #fbbf24;
        }
        
        .stat-item .rating {
            color: #fbbf24;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .stat-item .text-danger {
            font-size: 1.1rem;
        }
        
        /* === Main Content Area === */
        .course-main {
            background: #f9fafb;
            padding: 3rem 0;
        }
        
        /* Section Titles */
        .section-title-academic {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.75rem;
        }
        
        .section-title-academic::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-red) 0%, var(--academic-blue) 100%);
            border-radius: 2px;
        }
        
        /* === Skills as Modern Pills === */
        .skills-wrapper {
            background: #ffffff;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 3rem;
        }
        
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        .skill-pill {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #bae6fd;
            border-radius: 12px;
            color: var(--academic-blue-dark);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .skill-pill:hover {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.15);
        }
        
        .skill-pill i {
            font-size: 1.25rem;
            color: var(--academic-blue);
        }
        
        /* === Description Section === */
        .description-wrapper {
            background: #ffffff;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 3rem;
        }
        
        .description-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--text-light);
        }
        
        .description-body p {
            margin-bottom: 1.25rem;
        }
        
        .description-body img,
        .description-body video,
        .description-body iframe {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 1.5rem 0;
        }
        
        /* === Academic Instructor Carousel === */
        .instructors-wrapper {
            background: #ffffff;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 3rem;
            overflow: hidden; /* Fix: Prevent cards from bleeding out */
        }
        
        .instructors-carousel-wrapper {
            position: relative;
            padding: 1rem 0 3rem;
            overflow: hidden; /* Fix: Contain carousel within wrapper */
            margin: 0 -0.5rem; /* Compensate for card shadows */
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .instructors-swiper {
            overflow: hidden; /* Fix: Changed from visible to hidden */
            padding-bottom: 3rem;
            width: 100%; /* Fix: Ensure full width containment */
        }
        
        .instructors-swiper .swiper-slide {
            height: auto; /* Fix: Allow natural height */
            box-sizing: border-box; /* Fix: Include padding/border in width */
        }
        
        .instructor-card-academic {
            background: #ffffff;
            border: 2px solid rgba(30, 64, 175, 0.1);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.5rem; /* Reduced from 2rem */
            height: 100%;
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%; /* Fix: Ensure card doesn't exceed slide width */
            max-width: 100%; /* Fix: Prevent card from growing beyond container */
            box-sizing: border-box; /* Fix: Include padding in width calculation */
        }
        
        .instructor-card-academic:hover {
            box-shadow: 0 12px 40px rgba(30, 64, 175, 0.2);
            transform: translate(-12px);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        .instructor-image-frame {
            position: relative;
            width: 100px; /* Reduced from 120px */
            height: 100px; /* Reduced from 120px */
            margin-bottom: 1rem; /* Reduced from 1.5rem */
            overflow: hidden;
            border-radius: 50%;
            border: 4px solid #e0f2fe;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.15);
        }
        
        .instructor-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .instructor-card-academic:hover .instructor-image-frame img {
            transform: scale(1.15);
        }
        
        .instructor-image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .instructor-expert-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: linear-gradient(135deg, var(--accent-red) 0%, #b91c1c 100%);
            color: #ffffff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #ffffff;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }
        
        .instructor-name-academic {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        
        .instructor-title-academic {
            font-size: 0.875rem;
            color: var(--academic-blue);
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .instructor-bio-academic {
            font-size: 0.875rem;
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 1.5rem;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .instructor-actions-academic {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }
        
        .btn-academic {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-academic-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: #ffffff;
            border: none;
        }
        
        .btn-academic-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
            transform: translateY(-2px);
            color: #ffffff;
        }
        
        .btn-academic-outline {
            background: transparent;
            color: var(--academic-blue);
            border: 2px solid var(--academic-blue);
        }
        
        .btn-academic-outline:hover {
            background: var(--academic-blue);
            color: #ffffff;
            transform: translateY(-2px);
        }
        
        .instructors-swiper .swiper-button-next,
        .instructors-swiper .swiper-button-prev {
            width: 48px;
            height: 48px;
            background: #ffffff;
            border: 2px solid rgba(30, 58, 138, 0.15);
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            z-index: 10; /* Fix: Ensure buttons are above content */
        }
        
        .instructors-swiper .swiper-button-next {
            left: auto;
            right: 10px; /* Fix: Position inside container */
        }
        
        .instructors-swiper .swiper-button-prev {
            right: auto;
            left: 10px; /* Fix: Position inside container */
        }
        
        .instructors-swiper .swiper-button-next:hover,
        .instructors-swiper .swiper-button-prev:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            border-color: transparent;
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.3);
        }
        
        .instructors-swiper .swiper-button-next:after,
        .instructors-swiper .swiper-button-prev:after {
            font-size: 20px;
            font-weight: 900;
            color: #1e3a8a;
        }
        
        .instructors-swiper .swiper-button-next:hover:after,
        .instructors-swiper .swiper-button-prev:hover:after {
            color: #ffffff;
        }
        
        .instructors-swiper .swiper-pagination {
            bottom: 0;
        }
        
        .instructors-swiper .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: #cbd5e1;
            opacity: 1;
            transition: all 0.4s ease;
        }
        
        .instructors-swiper .swiper-pagination-bullet-active {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            width: 30px;
            border-radius: 5px;
        }
        
        /* === Floating Sticky Sidebar === */
        .sidebar-wrap {
            position: static;
        }
        
        @media (min-width: 992px) {
            .sidebar-wrap {
                /* position: sticky; */
                top: 6rem;
            }
        }
        
        .sidebar-card {
            background: #ffffff;
            border: 2px solid rgba(30, 64, 175, 0.1);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
            transform: translateY(-5px);
        }
        
        .course-img-wrap {
            position: relative;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            aspect-ratio: 16/9;
            overflow: hidden;
        }
        
        .course-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .sidebar-card:hover .course-img-wrap img {
            transform: scale(1.1);
        }
        
        .course-img-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .sidebar-body {
            padding: 2rem;
        }
        
        .course-price {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--accent-red);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
        }
        
        .course-price small {
            font-size: 1.25rem;
            color: var(--text-light);
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--accent-red) 0%, #b91c1c 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            padding: 1rem 2rem;
            width: 100%;
            border-radius: 12px;
            font-size: 1.125rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.5);
            transform: translateY(-2px);
            color: #ffffff;
        }
        
        .guarantee-text {
            text-align: center;
            color: var(--text-light);
            font-size: 0.875rem;
            margin: 1rem 0;
        }
        
        .course-includes {
            border-top: 2px solid #f3f4f6;
            padding-top: 1.5rem;
        }
        
        .include-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        
        .include-item:last-child {
            border-bottom: none;
        }
        
        .include-item i {
            color: var(--success-color);
            font-size: 1.125rem;
        }
        
        .share-section {
            margin-top: 1.5rem;
            text-align: center;
        }
        
        .share-title {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.75rem;
        }
        
        .share-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-share {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            background: #ffffff;
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .btn-share:hover {
            background: var(--academic-blue);
            border-color: var(--academic-blue);
            color: #ffffff;
            transform: translateY(-3px);
        }
        
        /* === Registration Modal === */
        .registration-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            animation: fadeIn 0.3s ease;
        }
        
        .registration-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .modal-content-wrapper {
            background: #ffffff;
            border-radius: 24px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-header-custom {
            background: linear-gradient(135deg, var(--accent-red) 0%, #b91c1c 100%);
            color: #ffffff;
            padding: 2rem;
            text-align: center;
            border-radius: 24px 24px 0 0;
            position: relative;
        }
        
        .modal-close {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }
        
        .modal-header-custom h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .modal-header-custom p {
            opacity: 0.9;
            margin: 0;
        }
        
        .modal-body-custom {
            padding: 2.5rem;
        }
        
        .form-group-custom {
            margin-bottom: 1.5rem;
        }
        
        .form-group-custom label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        
        .form-control-custom:focus {
            outline: none;
            border-color: var(--academic-blue);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
        }
        
        .form-control-custom::placeholder {
            color: #9ca3af;
        }
        
        .btn-submit-form {
            width: 100%;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--accent-red) 0%, #b91c1c 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 1.125rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .btn-submit-form:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.5);
            transform: translateY(-2px);
        }
        
        /* === Footer === */
        .footer {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: #ffffff;
            padding: 3rem 0 2rem;
            text-align: center;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .footer-text {
            color: #9ca3af;
            margin: 1rem 0;
            line-height: 1.8;
        }
        
        /* === Responsive === */
        @media (max-width: 991px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .section-title-academic {
                font-size: 1.5rem;
            }
            
            .sidebar-wrap {
                margin-top: 2rem;
            }
            
            .instructors-swiper .swiper-button-next,
            .instructors-swiper .swiper-button-prev {
                width: 40px;
                height: 40px;
            }
            
            /* Fix: Better button positioning on tablets */
            .instructors-swiper .swiper-button-next {
                right: 5px;
            }
            
            .instructors-swiper .swiper-button-prev {
                left: 5px;
            }
            
            /* Fix: Adjust wrapper padding on smaller screens */
            .instructors-wrapper {
                padding: 1.5rem;
            }
            
            .instructors-carousel-wrapper {
                margin: 0 -0.25rem;
                padding-left: 0.25rem;
                padding-right: 0.25rem;
            }
        }
        
        @media (max-width: 768px) {
            .course-hero {
                padding: 5rem 0 2rem;
            }
            
            .skills-grid {
                grid-template-columns: 1fr;
            }
            
            .modal-body-custom {
                padding: 1.5rem;
            }
            
            /* Fix: Mobile carousel containment */
            .instructors-wrapper {
                padding: 1rem;
            }
            
            .instructors-carousel-wrapper {
                padding: 0.5rem 0 2.5rem;
                margin: 0;
            }
            
            .instructors-swiper {
                padding-bottom: 2.5rem;
            }
            
            /* Fix: Hide navigation buttons on very small screens, use swipe instead */
            .instructors-swiper .swiper-button-next,
            .instructors-swiper .swiper-button-prev {
                width: 35px;
                height: 35px;
            }
            
            .instructors-swiper .swiper-button-next:after,
            .instructors-swiper .swiper-button-prev:after {
                font-size: 14px;
            }
        }

        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            max-width: 400px;
        }

        .toast-notification {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
            margin-bottom: 1rem;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .toast-notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast-notification::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: toast-shimmer 2s infinite;
        }

        .toast-notification .toast-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toast-notification .toast-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            animation: toast-bounce 0.6s ease-in-out;
        }

        .toast-notification .toast-text {
            flex: 1;
        }

        .toast-notification .toast-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .toast-notification .toast-message {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.4;
        }

        .toast-notification .toast-close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
            z-index: 3;
        }

        .toast-notification .toast-close-btn:hover {
            opacity: 1;
        }

        .toast-notification.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 20px 40px rgba(239, 68, 68, 0.3);
        }

        .toast-notification.warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
        }

        @keyframes toast-shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes toast-bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        @media (max-width: 768px) {
            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }

            .toast-notification {
                padding: 1.2rem 1.5rem;
            }
        }
    </style>
@endsection

@section('content')

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Premium Course Page -->
    <div class="course-page">
        <!-- Modern Hero Section -->
        <section class="course-hero" data-aos="fade-in">
            @if($course->cover_image)
                <div class="hero-bg-image" style="background-image: url('{{ asset('storage/' . $course->cover_image) }}');"></div>
            @endif
            
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <!-- Breadcrumb -->
                            <nav class="breadcrumb-academic" aria-label="breadcrumb">
                                <a href="{{ route('public.courses.index') }}">الأكاديمية</a>
                                @foreach($course->categories as $cat)
                                    <span class="sep">›</span>
                                    <a href="{{ route('public.courses.index', ['category' => $cat->id]) }}">{{ $cat->name }}</a>
                                @endforeach
                            </nav>

                            <!-- Course Title -->
                            <h1 data-aos="fade-up" data-aos-delay="100">{{ $course->title }}</h1>

                            <!-- Short Description -->
                            @if($course->short_description)
                                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                                    {{ $course->short_description }}
                                </p>
                            @endif

                            <!-- Categories Badges -->
                            <div class="mb-4" data-aos="fade-up" data-aos-delay="250">
                                @foreach($course->categories as $cat)
                                    <span class="category-badge">{{ $cat->name }}</span>
                                @endforeach
                            </div>

                            <!-- Stats Row -->
                            <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
                                <div class="stat-item">
                                    <i class="bi bi-star-fill"></i>
                                    <span class="rating">{{ $course->review_count > 0 ? number_format($course->review_count, 1) : '4.8' }}</span>
                                    @if($course->review_count > 0)
                                        <span>({{ number_format($course->review_count) }} تقييم)</span>
                                    @else
                                        <span>(245 تقييم)</span>
                                    @endif
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-people-fill"></i>
                                    <span>{{ number_format($course->learner_count) }} متعلم</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-heart-fill text-danger"></i>
                                    <span>{{ $course->likes_count }} إعجاب</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-clock"></i>
                                    <span>آخر تحديث {{ $course->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="course-main">
            <div class="container">
                <div class="row g-4">
                    <!-- Left Column: Content -->
                    <div class="col-lg-8">

                    <!-- Description Section -->
                    <div class="description-wrapper" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="section-title-academic">نظرة عامة على الدورة</h2>
                            <div class="description-body">
                                {!! $course->description !!}
                            </div>
                        </div>


                        <!-- Skills Section -->
                        @if($course->skills->isNotEmpty())
                        <div class="skills-wrapper" data-aos="fade-up">
                            <h2 class="section-title-academic">المهارات التي ستكتسبها</h2>
                            <div class="skills-grid">
                                @foreach($course->skills as $skill)
                                    <div class="skill-pill">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>{{ $skill->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        
                        <!-- Instructors Section -->
                        @if($course->leaders->isNotEmpty())
                        <div class="instructors-wrapper" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="section-title-academic">خبراء أكاديميون متميزون</h2>
                            
                            <div class="instructors-carousel-wrapper">
                                <div class="swiper instructors-swiper">
                                    <div class="swiper-wrapper">
                                        @foreach($course->leaders as $leader)
                                            <div class="swiper-slide">
                                                <div class="instructor-card-academic">
                                                    <!-- Professional Image Frame -->
                                                    <div class="instructor-image-frame">
                                                        @if($leader->photo)
                                                            <img src="{{ asset('storage/' . $leader->photo) }}" 
                                                                 alt="{{ $leader->name }}">
                                                        @else
                                                            <div class="instructor-image-placeholder">
                                                                {{ mb_substr($leader->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- Expert Badge -->
                                                        <div class="instructor-expert-badge">
                                                            <i class="bi bi-award-fill" style="font-size: 0.75rem;"></i>
                                                        </div>
                                                    </div>

                                                    <!-- Academic Typography -->
                                                    <a href="{{ route('public.leaders.show', $leader) }}" class="text-decoration-none">
                                                        <h5 class="instructor-name-academic" style="transition: color 0.3s ease;">{{ $leader->name }}</h5>
                                                    </a>
                                                    
                                                    @if($leader->job_title)
                                                        <p class="instructor-title-academic">{{ $leader->job_title }}</p>
                                                    @else
                                                        <p class="instructor-title-academic">{{ $leader->job_title }}</p>
                                                    @endif

                                                    @if($leader->job_description)
                                                        <p class="instructor-bio-academic">{{ $leader->job_description }}</p>
                                                    @else
                                                        <p class="instructor-bio-academic">متخصص في مجال التدريب الأكاديمي والتطوير المهني بخبرة واسعة في تقديم المحتوى التعليمي المتميز.</p>
                                                    @endif

                                                    <!-- Academic Actions -->
                                                    <div class="instructor-actions-academic">
                                                        <a href="{{ route('public.leaders.show', $leader) }}" 
                                                           class="btn-academic btn-academic-primary w-100">
                                                            <i class="bi bi-person-lines-fill me-2"></i>عرض الملف الشخصي
                                                        </a>
                                                       
                                                        @if($leader->linkedin)
                                                            <a href="{{ $leader->linkedin }}" 
                                                               target="_blank" 
                                                               class="btn-academic btn-academic-outline w-100">
                                                                <i class="bi bi-linkedin me-2"></i>LinkedIn
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Professional Navigation -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    
                                    <!-- Professional Pagination -->
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Right Column: Sticky Sidebar -->
                    <div class="col-lg-4">
                        <div class="sidebar-wrap">
                            <div class="sidebar-card" data-aos="fade-up" data-aos-delay="100">
                                <!-- Course Image -->
                                <div class="course-img-wrap">
                                    @if($course->cover_image)
                                        <img src="{{ asset('storage/' . $course->cover_image) }}" alt="{{ $course->title }}">
                                    @else
                                        <div class="course-img-placeholder">
                                            <i class="bi bi-camera-video display-1"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Sidebar Body -->
                                <div class="sidebar-body">
                                    <!-- Price -->
                                    <div class="course-price">
                                        ${{ number_format($course->price, 0) }}
                                        @if((int)$course->price != $course->price)
                                            <small>.{{ explode('.', number_format($course->price, 2))[1] }}</small>
                                        @endif
                                    </div>

                                    <!-- Register Button -->
                                    <button type="button" class="btn-register" onclick="openRegistrationModal()">
                                        <i class="bi bi-rocket-takeoff me-2"></i>سجل الآن في الدورة
                                    </button>

                                    <!-- Guarantee Text -->
                                    <p class="guarantee-text">
                                        <i class="bi bi-shield-check me-1"></i>ضمان استرداد الأموال لمدة 30 يوم
                                    </p>

                                    <!-- Course Includes -->
                                    <div class="course-includes">
                                        <div class="include-item">
                                            <span><i class="bi bi-infinity me-2"></i>وصول مدى الحياة</span>
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <div class="include-item">
                                            <span><i class="bi bi-award me-2"></i>شهادة إتمام معتمدة</span>
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <div class="include-item">
                                            <span><i class="bi bi-phone me-2"></i>الوصول عبر الجوال</span>
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <div class="include-item">
                                            <span><i class="bi bi-chat-dots me-2"></i>دعم فني متواصل</span>
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Share Section -->
                            <div class="share-section" data-aos="fade-up" data-aos-delay="200">
                                <p class="share-title">شارك هذه الدورة</p>
                                <div class="share-buttons">
                                    <a href="#" class="btn-share" title="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="#" class="btn-share" title="Twitter">
                                        <i class="bi bi-twitter"></i>
                                    </a>
                                    <a href="#" class="btn-share" title="WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                    <button type="button" class="btn-share" title="نسخ الرابط" onclick="copyLink()">
                                        <i class="bi bi-link-45deg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Registration Modal -->
    <div class="registration-modal" id="registrationModal">
        <div class="modal-content-wrapper">
            <div class="modal-header-custom">
                <button type="button" class="modal-close" onclick="closeRegistrationModal()">
                    <i class="bi bi-x"></i>
                </button>
                <h3>سجل في الدورة</h3>
                <p>{{ $course->title }}</p>
            </div>
            <div class="modal-body-custom">
                <form id="enrollmentForm">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="course_title" value="{{ $course->title }}">
                    
                    <div class="form-group-custom">
                        <label for="enrollName">الاسم الكامل <span style="color: var(--accent-red);">*</span></label>
                        <input type="text" 
                               id="enrollName" 
                               name="name" 
                               class="form-control-custom" 
                               placeholder="أدخل اسمك الكامل"
                               required>
                    </div>

                    <div class="form-group-custom">
                        <label for="enrollEmail">البريد الإلكتروني <span style="color: var(--accent-red);">*</span></label>
                        <input type="email" 
                               id="enrollEmail" 
                               name="email" 
                               class="form-control-custom" 
                               placeholder="example@email.com"
                               required>
                    </div>

                    <div class="form-group-custom">
                        <label for="enrollPhone">رقم الهاتف <span style="color: var(--accent-red);">*</span></label>
                        <input type="tel" 
                               id="enrollPhone" 
                               name="phone" 
                               class="form-control-custom" 
                               placeholder="+972 XX XXX XXXX"
                               required>
                    </div>

                    <div class="form-group-custom">
                        <label for="enrollMessage">ملاحظات إضافية (اختياري)</label>
                        <textarea id="enrollMessage" 
                                  name="message" 
                                  class="form-control-custom" 
                                  rows="4" 
                                  placeholder="أخبرنا عن اهتماماتك وأهدافك من الدورة..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit-form" id="enrollSubmitBtn">
                        <i class="bi bi-send me-2"></i>إرسال طلب التسجيل
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        
        // Initialize Instructors Carousel
        document.addEventListener('DOMContentLoaded', function() {
            const swiperElement = document.querySelector('.instructors-swiper');
            if (swiperElement) {
                const instructorsSwiper = new Swiper('.instructors-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    
                    breakpoints: {
                        576: {
                            slidesPerView: 1,
                            spaceBetween: 24
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 30
                        },
                        992: {
                            slidesPerView: 2,
                            spaceBetween: 30
                        }
                    },
                    
                    navigation: {
                        nextEl: '.instructors-swiper .swiper-button-next',
                        prevEl: '.instructors-swiper .swiper-button-prev',
                    },
                    
                    pagination: {
                        el: '.instructors-swiper .swiper-pagination',
                        clickable: true,
                    },
                    
                    speed: 600,
                    grabCursor: true,
                    keyboard: {
                        enabled: true,
                    },
                    watchSlidesProgress: true,
                    watchOverflow: true,
                });
            }
        });
        
        // Toast Notification System
        function showToast(title, message, type = 'success', duration = 5000) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;

            const icon = type === 'success' ? 'bi-check-circle-fill' :
                        type === 'error' ? 'bi-x-circle-fill' :
                        type === 'warning' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill';

            toast.innerHTML = `
                <button class="toast-close-btn" onclick="closeToast(this)">&times;</button>
                <div class="toast-content">
                    <div class="toast-icon">
                        <i class="bi ${icon}"></i>
                    </div>
                    <div class="toast-text">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                </div>
            `;

            container.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            // Auto remove
            setTimeout(() => {
                closeToast(toast.querySelector('.toast-close-btn'));
            }, duration);
        }

        function closeToast(closeBtn) {
            const toast = closeBtn.closest('.toast-notification');
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 400);
        }

        // Registration Modal Functions
        function openRegistrationModal() {
            const modal = document.getElementById('registrationModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeRegistrationModal() {
            const modal = document.getElementById('registrationModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('registrationModal');
            if (event.target === modal) {
                closeRegistrationModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRegistrationModal();
            }
        });

        // Enrollment Form AJAX Submission
        document.addEventListener('DOMContentLoaded', function() {
            const enrollForm = document.getElementById('enrollmentForm');
            const submitBtn = document.getElementById('enrollSubmitBtn');

            if (enrollForm) {
                enrollForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(enrollForm);
                    const name = formData.get('name');
                    const email = formData.get('email');
                    const phone = formData.get('phone');

                    // Validate required fields
                    if (!name || name.trim() === '') {
                        showToast(
                            'يرجى إدخال الاسم',
                            'الاسم الكامل مطلوب للمتابعة.',
                            'warning',
                            4000
                        );
                        document.getElementById('enrollName').focus();
                        return;
                    }

                    if (!email || email.trim() === '') {
                        showToast(
                            'يرجى إدخال البريد الإلكتروني',
                            'البريد الإلكتروني مطلوب للمتابعة.',
                            'warning',
                            4000
                        );
                        document.getElementById('enrollEmail').focus();
                        return;
                    }

                    if (!phone || phone.trim() === '') {
                        showToast(
                            'يرجى إدخال رقم الهاتف',
                            'رقم الهاتف مطلوب للمتابعة.',
                            'warning',
                            4000
                        );
                        document.getElementById('enrollPhone').focus();
                        return;
                    }

                    // Disable submit button
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>جاري الإرسال...';

                    // Submit form data via AJAX
                    fetch('{{ route("course-enrollment-requests.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            course_id: formData.get('course_id'),
                            course_title: formData.get('course_title'),
                            name: name,
                            email: email,
                            phone: phone,
                            message: formData.get('message')
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success toast
                            showToast(
                                'تم إرسال طلب التسجيل بنجاح! 🎉',
                                'شكراً لك! سنتواصل معك قريباً لتأكيد التسجيل في الدورة.',
                                'success',
                                6000
                            );

                            // Reset form
                            enrollForm.reset();

                            // Close modal after a short delay
                            setTimeout(() => {
                                closeRegistrationModal();
                            }, 2000);

                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>إرسال طلب التسجيل';
                        } else {
                            // Show validation errors
                            if (data.errors) {
                                const firstError = Object.values(data.errors)[0][0];
                                showToast(
                                    'خطأ في البيانات',
                                    firstError,
                                    'error',
                                    5000
                                );
                            } else {
                                showToast(
                                    'حدث خطأ!',
                                    data.message || 'لم يتم إرسال الطلب بنجاح. يرجى المحاولة مرة أخرى.',
                                    'error',
                                    5000
                                );
                            }

                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>إرسال طلب التسجيل';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast(
                            'حدث خطأ!',
                            'لم يتم إرسال الطلب بنجاح. يرجى المحاولة مرة أخرى.',
                            'error',
                            5000
                        );

                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>إرسال طلب التسجيل';
                    });
                });
            }
        });
        
        // Copy Link Function
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(function() {
                // Show success message
                const btn = event.target.closest('.btn-share');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check2"></i>';
                btn.style.background = 'var(--success-color)';
                btn.style.borderColor = 'var(--success-color)';
                btn.style.color = '#ffffff';
                
                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.style.background = '';
                    btn.style.borderColor = '';
                    btn.style.color = '';
                }, 2000);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection
