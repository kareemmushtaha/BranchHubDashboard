@extends('layouts.app')

@section('title', 'التقارير')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">لوحة التقارير</h1>
</div>

<!-- الإحصائيات العامة -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>₪{{ number_format($totalRevenue, 2) }}</h4>
                        <p class="card-text">إجمالي الإيرادات</p>
                    </div>
                    <div>
                        <i class="bi bi-cash-stack fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalSessions }}</h4>
                        <p class="card-text">إجمالي الجلسات</p>
                    </div>
                    <div>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalUsers }}</h4>
                        <p class="card-text">إجمالي المستخدمين</p>
                    </div>
                    <div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $activeSessions }}</h4>
                        <p class="card-text">جلسات نشطة</p>
                    </div>
                    <div>
                        <i class="bi bi-play-circle fs-1"></i>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
</div>

<!-- إحصائيات هذا الشهر -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">إحصائيات هذا الشهر</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h3 class="text-success">₪{{ number_format($monthlyRevenue, 2) }}</h3>
                        <p class="text-muted">إيرادات الشهر</p>
                    </div>
                    <div class="col-6">
                        <h3 class="text-primary">{{ $monthlySessions }}</h3>
                        <p class="text-muted">جلسات الشهر</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">تفصيل الإيرادات</h5>
            </div>
            <div class="card-body">
                @php
                    $totalDrinksRevenue = \App\Models\SessionDrink::getTotalDrinksRevenue();
                    $totalInternetRevenue = \App\Models\Session::getTotalInternetRevenue();
                @endphp
                <div class="row">
                    <div class="col-6">
                        <h4 class="text-info">${{ number_format($totalInternetRevenue, 2) }}</h4>
                        <p class="text-muted small">إيرادات الإنترنت</p>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">${{ number_format($totalDrinksRevenue, 2) }}</h4>
                        <p class="text-muted small">إيرادات المشروبات</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">أفضل المستخدمين</h5>
            </div>
            <div class="card-body">
                @if($topUsers->count() > 0)
                <ul class="list-unstyled">
                    @foreach($topUsers as $user)
                    <li class="d-flex justify-content-between">
                        <span>{{ $user->name }}</span>
                        <span class="badge bg-primary">{{ $user->sessions_count }} جلسة</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">لا توجد بيانات</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- أفضل المشروبات -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">أفضل المشروبات مبيعاً</h5>
            </div>
            <div class="card-body">
                @if($topDrinks->count() > 0)
                <ul class="list-unstyled">
                    @foreach($topDrinks as $drink)
                    <li class="d-flex justify-content-between">
                        <span>{{ $drink->name }}</span>
                        <span class="badge bg-success">{{ $drink->session_drinks_count }} مرة</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">لا توجد بيانات</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">التقارير التفصيلية</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('reports.revenue') }}" class="btn btn-outline-success">
                        <i class="bi bi-graph-up"></i> تقرير الإيرادات
                    </a>
                    <a href="{{ route('reports.users') }}" class="btn btn-outline-primary">
                        <i class="bi bi-people"></i> تقرير المستخدمين
                    </a>
                    <a href="{{ route('reports.drinks') }}" class="btn btn-outline-info">
                        <i class="bi bi-cup"></i> تقرير المشروبات
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection