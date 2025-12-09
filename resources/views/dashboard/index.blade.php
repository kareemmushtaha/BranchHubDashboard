@extends('layouts.app')

@section('title', 'لوحة التحكم الرئيسية')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">لوحة التحكم</h1>
</div>

<!-- إحصائيات عامة -->
<div class="row mb-4">
    <div class="col-md-2 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_users'] }}</h4>
                        <p class="card-text">إجمالي المستخدمين</p>
                    </div>
                    <div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['active_sessions'] }}</h4>
                        <p class="card-text">الجلسات النشطة</p>
                    </div>
                    <div>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>${{ number_format($stats['today_revenue'], 2) }}</h4>
                        <p class="card-text">إيرادات اليوم</p>
                    </div>
                    <div>
                        <i class="bi bi-cash fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>${{ number_format($stats['pending_payments'], 2) }}</h4>
                        <p class="card-text">مدفوعات معلقة</p>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['subscription_sessions'] }}</h4>
                        <p class="card-text">اشتراكات نشطة</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['overdue_subscriptions'] }}</h4>
                        <p class="card-text">اشتراكات متأخرة</p>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات الجلسات -->
<div class="row mb-4">
    <div class="col-md-2 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_sessions'] }}</h4>
                        <p class="card-text">إجمالي الجلسات</p>
                    </div>
                    <div>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['active_sessions'] }}</h4>
                        <p class="card-text">جلسات نشطة</p>
                    </div>
                    <div>
                        <i class="bi bi-play-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['completed_sessions'] }}</h4>
                        <p class="card-text">جلسات مكتملة</p>
                    </div>
                    <div>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['cancelled_sessions'] }}</h4>
                        <p class="card-text">جلسات ملغاة</p>
                    </div>
                    <div>
                        <i class="bi bi-x-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['active_subscription_sessions'] }}</h4>
                        <p class="card-text">اشتراكات نشطة</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['overdue_subscription_sessions'] }}</h4>
                        <p class="card-text">اشتراكات متأخرة</p>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات المبالغ المرتجعة -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['sessions_needing_refund'] ?? 0 }}</h4>
                        <p class="card-text">جلسات تحتاج إرجاع</p>
                    </div>
                    <div>
                        <i class="bi bi-arrow-down-circle fs-1"></i>
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
                        <h4>{{ $stats['sessions_with_remaining'] ?? 0 }}</h4>
                        <p class="card-text">جلسات متبقية للدفع</p>
                    </div>
                    <div>
                        <i class="bi bi-arrow-up-circle fs-1"></i>
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
                        <h4>{{ $stats['fully_paid_sessions'] ?? 0 }}</h4>
                        <p class="card-text">جلسات مكتملة الدفع</p>
                    </div>
                    <div>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_sessions'] - ($stats['sessions_needing_refund'] ?? 0) - ($stats['sessions_with_remaining'] ?? 0) - ($stats['fully_paid_sessions'] ?? 0) }}</h4>
                        <p class="card-text">جلسات بدون دفع</p>
                    </div>
                    <div>
                        <i class="bi bi-x-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- الجلسات الحديثة -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">الجلسات الحديثة</h5>
            </div>
            <div class="card-body">
                @if($recent_sessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>المستخدم</th>
    
                                <th>بداية الجلسة</th>
                                <th>الحالة</th>
                                <th>الفئة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_sessions as $session)
                            <tr>
                                <td>
                                    @if($session->user)
                                        <a href="{{ route('users.show', $session->user) }}" class="text-decoration-none">
                                            <span class="text-primary fw-bold">{{ $session->user->name }}</span>
                                            <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>

                                <td>{{ $session->start_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($session->session_status == 'active')
                                        <span class="badge bg-success">نشط</span>
                                    @elseif($session->session_status == 'completed')
                                        <span class="badge bg-primary">مكتمل</span>
                                    @else
                                        <span class="badge bg-danger">ملغي</span>
                                    @endif
                                </td>
                                <td>
                                    @if($session->session_category == 'hourly')
                                        <span class="badge bg-info">ساعي</span>
                                    
                                    @elseif($session->session_category == 'subscription')
                                        <span class="badge bg-success">اشتراك</span>
                                        @if($session->session_status == 'active')
                                            @php
                                                $remainingDays = $session->getRemainingDays();
                                                $isOverdue = $session->isOverdue();
                                            @endphp
                                            @if($isOverdue)
                                                <br><small class="text-danger">متأخرة</small>
                                            @elseif($remainingDays !== null && $remainingDays <= 3)
                                                <br><small class="text-warning">{{ $remainingDays }} يوم متبقي</small>
                                            @endif
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">إضافي</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted">لا توجد جلسات حديثة</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- أزرار سريعة -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">إجراءات سريعة</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('sessions.create') }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-plus-circle"></i> بدء جلسة جديدة
                        </a>
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('sessions.index', ['session_category' => 'subscription', 'session_status' => 'active']) }}" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-calendar-check"></i> الجلسات الاشتراكية
                        </a>
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('users.create') }}" class="btn btn-info btn-lg w-100">
                            <i class="bi bi-person-plus"></i> إضافة مستخدم
                        </a>
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('drinks.create') }}" class="btn btn-warning btn-lg w-100">
                            <i class="bi bi-cup"></i> إضافة مشروب
                        </a>
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-lg w-100">
                            <i class="bi bi-graph-up"></i> عرض التقارير
                        </a>
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('sessions.index') }}" class="btn btn-dark btn-lg w-100">
                            <i class="bi bi-list"></i> جميع الجلسات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection