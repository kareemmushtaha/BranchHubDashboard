@extends('layouts.app')

@section('title', 'تقرير المشروبات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تقرير المشروبات</h1>
    <div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة للتقارير
        </a>
    </div>
</div>

<!-- فلتر التاريخ -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.drinks') }}" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">من تاريخ</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> تصفية
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- إحصائيات المشروبات -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h3>{{ $totalDrinks }}</h3>
                <p class="card-text">إجمالي المشروبات</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h3>{{ $availableDrinks }}</h3>
                <p class="card-text">مشروبات متوفرة</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h3>{{ $totalSold }}</h3>
                <p class="card-text">إجمالي المبيعات</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h3>${{ number_format($totalDrinksRevenue, 2) }}</h3>
                <p class="card-text">إيرادات المشروبات</p>
            </div>
        </div>
    </div>
</div>

<!-- أفضل المشروبات مبيعاً -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">أفضل المشروبات مبيعاً</h5>
            </div>
            <div class="card-body">
                @if($topSellingDrinks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>المشروب</th>
                                <th>السعر الحالي</th>
                                <th>عدد المبيعات</th>
                                <th>إجمالي الإيرادات</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSellingDrinks as $drink)
                            <tr>
                                <td>
                                    <a href="{{ route('drinks.show', $drink) }}" class="text-decoration-none">
                                        {{ $drink->name }}
                                    </a>
                                </td>
                                <td>${{ number_format($drink->price, 2) }}</td>
                                <td>{{ $drink->session_drinks_count }}</td>
                                <td>${{ number_format($drink->sessionDrinks->sum('price'), 2) }}</td>
                                <td>
                                    @if($drink->status == 'available')
                                        <span class="badge bg-success">متوفر</span>
                                    @else
                                        <span class="badge bg-danger">غير متوفر</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <th colspan="2">الإجمالي</th>
                                <th>{{ $topSellingDrinks->sum('session_drinks_count') }}</th>
                                <th>${{ number_format($topSellingDrinks->sum(function($drink) { return $drink->sessionDrinks->sum('price'); }), 2) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">لا توجد مبيعات في هذه الفترة</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">إحصائيات سريعة</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between">
                        <span>متوسط المبيعات اليومية:</span>
                        <strong>
                            @if($dailySales->count() > 0)
                                {{ number_format($totalSold / $dailySales->count(), 1) }}
                            @else
                                0
                            @endif
                        </strong>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>متوسط سعر المشروب:</span>
                        <strong>
                            @if($totalSold > 0)
                                ${{ number_format($totalDrinksRevenue / $totalSold, 2) }}
                            @else
                                $0.00
                            @endif
                        </strong>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>نسبة المتوفر:</span>
                        <strong>
                            @if($totalDrinks > 0)
                                {{ number_format(($availableDrinks / $totalDrinks) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </strong>
                    </li>
                </ul>
                
                <hr>
                
                <div class="d-grid">
                    <a href="{{ route('drinks.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> إضافة مشروب جديد
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- المبيعات اليومية -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">المبيعات اليومية</h5>
    </div>
    <div class="card-body">
        @if($dailySales->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الكمية المباعة</th>
                        <th>الإيرادات</th>
                        <th>متوسط السعر</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailySales as $day)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($day->date)->format('Y-m-d') }}</td>
                        <td>{{ $day->quantity }}</td>
                        <td>${{ number_format($day->revenue, 2) }}</td>
                        <td>
                            @if($day->quantity > 0)
                                ${{ number_format($day->revenue / $day->quantity, 2) }}
                            @else
                                $0.00
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <th>الإجمالي</th>
                        <th>{{ $dailySales->sum('quantity') }}</th>
                        <th>${{ number_format($dailySales->sum('revenue'), 2) }}</th>
                        <th>
                            @if($dailySales->sum('quantity') > 0)
                                ${{ number_format($dailySales->sum('revenue') / $dailySales->sum('quantity'), 2) }}
                            @else
                                $0.00
                            @endif
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <p class="text-muted text-center">لا توجد مبيعات في هذه الفترة</p>
        @endif
    </div>
</div>

@endsection