@extends('layouts.app')

@section('title', 'تقرير المستخدمين')

@section('content')
@php
    $userTypeBadges = [
        'hourly' => ['label' => 'ساعي', 'class' => 'bg-info'],
        'subscription' => ['label' => 'اشتراك', 'class' => 'bg-success'],
        'prepaid' => ['label' => 'مدفوع مسبقاً', 'class' => 'bg-primary'],
        'manager' => ['label' => 'مدير إداري', 'class' => 'bg-warning text-dark'],
        'admin' => ['label' => 'مدير النظام', 'class' => 'bg-danger'],
    ];
@endphp
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تقرير المستخدمين</h1>
    <div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة للتقارير
        </a>
    </div>
</div>

<!-- فلتر التاريخ -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.users') }}" class="row g-3">
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

<!-- إحصائيات المستخدمين -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h3>{{ $totalUsers }}</h3>
                <p class="card-text">إجمالي المستخدمين</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h3>{{ $activeUsers }}</h3>
                <p class="card-text">مستخدمين نشطين</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h3>{{ $newUsers }}</h3>
                <p class="card-text">مستخدمين جدد</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h3>{{ $dailyActivity->sum('unique_users') }}</h3>
                <p class="card-text">إجمالي النشاط</p>
            </div>
        </div>
    </div>
</div>

<!-- التوزيع حسب النوع والحالة -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">التوزيع حسب نوع المستخدم</h5>
            </div>
            <div class="card-body">
                @if($usersByType->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>نوع المستخدم</th>
                                <th>العدد</th>
                                <th>النسبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usersByType as $type)
                            <tr>
                                @php
                                    $typeInfo = $userTypeBadges[$type->user_type] ?? ['label' => 'غير معروف', 'class' => 'bg-secondary'];
                                @endphp
                                <td>
                                    <span class="badge {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
                                </td>
                                <td>{{ $type->count }}</td>
                                <td>
                                    @if($totalUsers > 0)
                                        {{ number_format(($type->count / $totalUsers) * 100, 1) }}%
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
                <p class="text-muted text-center">لا توجد بيانات</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">التوزيع حسب الحالة</h5>
            </div>
            <div class="card-body">
                @if($usersByStatus->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>الحالة</th>
                                <th>العدد</th>
                                <th>النسبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usersByStatus as $status)
                            <tr>
                                <td>
                                    @if($status->status == 'active')
                                        <span class="badge bg-success">نشط</span>
                                    @elseif($status->status == 'inactive')
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @else
                                        <span class="badge bg-danger">معلق</span>
                                    @endif
                                </td>
                                <td>{{ $status->count }}</td>
                                <td>
                                    @if($totalUsers > 0)
                                        {{ number_format(($status->count / $totalUsers) * 100, 1) }}%
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
                <p class="text-muted text-center">لا توجد بيانات</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- المستخدمون الأكثر نشاطاً -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">المستخدمون الأكثر نشاطاً</h5>
            </div>
            <div class="card-body">
                @if($mostActiveUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>المستخدم</th>
                                <th>النوع</th>
                                <th>عدد الجلسات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mostActiveUsers as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('users.show', $user) }}" class="text-decoration-none">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                @php
                                    $typeInfo = $userTypeBadges[$user->user_type] ?? ['label' => 'غير معروف', 'class' => 'bg-secondary'];
                                @endphp
                                <td>
                                    <span class="badge {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
                                </td>
                                <td>{{ $user->sessions_count }}</td>
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
                <h5 class="card-title mb-0">النشاط اليومي</h5>
            </div>
            <div class="card-body">
                @if($dailyActivity->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>مستخدمين فريدين</th>
                                <th>إجمالي الجلسات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyActivity->take(10) as $day)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($day->date)->format('Y-m-d') }}</td>
                                <td>{{ $day->unique_users }}</td>
                                <td>{{ $day->total_sessions }}</td>
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
</div>

@endsection