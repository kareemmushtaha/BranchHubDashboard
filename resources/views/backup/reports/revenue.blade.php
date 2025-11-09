@extends('layouts.app')

@section('title', 'تقرير الإيرادات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تقرير الإيرادات</h1>
    <div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة للتقارير
        </a>
    </div>
</div>

<!-- فلتر التاريخ -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.revenue') }}" class="row g-3">
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

<!-- إحصائيات الإيرادات -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h3>₪{{ number_format($totalRevenue, 2) }}</h3>
                <p class="card-text">إجمالي الإيرادات</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h3>₪{{ number_format($totalCash, 2) }}</h3>
                <p class="card-text">إيرادات نقدية</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h3>₪{{ number_format($totalBank, 2) }}</h3>
                <p class="card-text">إيرادات بنكية</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h3>{{ $dailyRevenue->count() }}</h3>
                <p class="card-text">أيام النشاط</p>
            </div>
        </div>
    </div>
</div>

<!-- الإيرادات حسب الفئة -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">الإيرادات حسب فئة الجلسة</h5>
            </div>
            <div class="card-body">
                @if($revenueByCategory->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>فئة الجلسة</th>
                                <th>الإيرادات</th>
                                <th>النسبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenueByCategory as $category)
                            <tr>
                                <td>
                                    @if($category->session_category == 'hourly')
                                        <span class="badge bg-info">ساعي</span>
                                    
                                    @elseif($category->session_category == 'subscription')
                                        <span class="badge bg-success">اشتراك</span>
                                    @else
                                        <span class="badge bg-secondary">إضافي</span>
                                    @endif
                                </td>
                                <td>₪{{ number_format($category->revenue, 2) }}</td>
                                <td>
                                    @if($totalRevenue > 0)
                                        {{ number_format(($category->revenue / $totalRevenue) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">لا توجد بيانات في هذه الفترة</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">ملخص سريع</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between">
                        <span>متوسط الإيرادات اليومية:</span>
                        <strong>
                            @if($dailyRevenue->count() > 0)
                                ₪{{ number_format($totalRevenue / $dailyRevenue->count(), 2) }}
                            @else
                                $0.00
                            @endif
                        </strong>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>نسبة النقد:</span>
                        <strong>
                            @if($totalRevenue > 0)
                                {{ number_format(($totalCash / $totalRevenue) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </strong>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>نسبة البنك:</span>
                        <strong>
                            @if($totalRevenue > 0)
                                {{ number_format(($totalBank / $totalRevenue) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- الإيرادات اليومية -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">الإيرادات اليومية</h5>
    </div>
    <div class="card-body">
        @if($dailyRevenue->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الإيرادات</th>
                        <th>عدد الجلسات</th>
                        <th>متوسط الجلسة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyRevenue as $day)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($day->date)->format('Y-m-d') }}</td>
                        <td>₪{{ number_format($day->revenue, 2) }}</td>
                        <td>{{ $day->sessions_count }}</td>
                        <td>
                            @if($day->sessions_count > 0)
                                ₪{{ number_format($day->revenue / $day->sessions_count, 2) }}
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
                        <th>₪{{ number_format($dailyRevenue->sum('revenue'), 2) }}</th>
                        <th>{{ $dailyRevenue->sum('sessions_count') }}</th>
                        <th>
                            @if($dailyRevenue->sum('sessions_count') > 0)
                                ₪{{ number_format($dailyRevenue->sum('revenue') / $dailyRevenue->sum('sessions_count'), 2) }}
                            @else
                                $0.00
                            @endif
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <p class="text-muted text-center">لا توجد إيرادات في هذه الفترة</p>
        @endif
    </div>
</div>

@endsection