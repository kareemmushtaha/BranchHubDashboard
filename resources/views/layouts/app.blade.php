<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - لوحة تحكم مساحة العمل</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/jpeg" sizes="32x32" href="{{ asset('images/logo.jpeg') }}">
    <link rel="icon" type="image/jpeg" sizes="16x16" href="{{ asset('images/logo.jpeg') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.jpeg') }}">
    <meta name="msapplication-TileImage" content="{{ asset('images/logo.jpeg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
    
    <!-- Custom CSS for RTL Pagination -->
    <style>
        /* تطبيق خط Almarai على جميع العناصر */
        * {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        body {
            font-family: 'Almarai', 'Segoe UI', 'Tahoma', 'Arial', sans-serif !important;
        }
        
        /* تحسين pagination للـ RTL */
        .pagination {
            direction: ltr;
        }
        
        .pagination .page-link {
            color: #0d6efd;
            background-color: #fff;
            border: 1px solid #dee2e6;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }
        
        .pagination .page-link:hover {
            color: #0a58ca;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .pagination .page-item.active .page-link {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
        
        /* تحسين spacing للنصوص العربية */
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .pagination-sm .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        /* تحسين الـ icons في pagination */
        .pagination .bi {
            font-size: 0.75rem;
            vertical-align: middle;
        }
    </style>
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        /* تحسين مظهر خط Almarai */
        .sidebar h5 {
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .nav-link {
            font-weight: 400;
            font-size: 0.95rem;
        }
        
        .card-title {
            font-weight: 700;
        }
        
        .btn {
            font-weight: 400;
        }
        
        .table th {
            font-weight: 700;
        }
        
        .table td {
            font-weight: 400;
        }
        
        /* تحسين مظهر العناوين */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
        }
        
        /* تحسين مظهر النصوص في الجداول */
        .table {
            font-size: 0.9rem;
        }
        
        /* تحسين مظهر الأزرار */
        .btn-sm {
            font-size: 0.875rem;
        }
        
        .btn-lg {
            font-size: 1.125rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0">مساحة العمل</h5>
                    @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="bi bi-person me-2"></i>الملف الشخصي
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>تسجيل الخروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endauth
                </div>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('dashboard') }}">
                            <i class="bi bi-house"></i> الرئيسية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('dashboard.real-time') }}">
                            <i class="bi bi-speedometer2"></i> لوحة التحكم المباشرة
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('users.index') }}">
                            <i class="bi bi-people"></i> المستخدمون
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('sessions.index') }}">
                            <i class="bi bi-clock"></i> الجلسات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('sessions.trashed') }}">
                            <i class="bi bi-trash text-danger"></i> الجلسات المحذوفة
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('session-payments.index') }}">
                            <i class="bi bi-cash-coin"></i> مدفوعات الجلسات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('expenses.index') }}">
                            <i class="bi bi-receipt"></i> المصروفات المالية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('employee-salaries.index') }}">
                            <i class="bi bi-wallet2"></i> إدارة رواتب الموظفين
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('electricity-meter-readings.index') }}">
                            <i class="bi bi-lightning-charge"></i> قراءات عداد الكهرباء
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('booking-requests.index') }}">
                            <i class="bi bi-calendar-check"></i> طلبات الحجز
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('calendar-notes.index') }}">
                            <i class="bi bi-calendar-event"></i> تقويم الملاحظات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('employee-notes.index') }}">
                            <i class="bi bi-person-badge"></i> ملاحظات الموظفين
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('drinks.index') }}">
                            <i class="bi bi-cup"></i> المشروبات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('reports.index') }}">
                            <i class="bi bi-graph-up"></i> التقارير
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('audit.index') }}">
                            <i class="bi bi-clock-history"></i> سجلات التدقيق
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 col-lg-10 main-content p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>