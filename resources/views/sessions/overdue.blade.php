@extends('layouts.app')

@section('title', 'الجلسات المتأخرة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-exclamation-triangle text-danger"></i>
        الجلسات المتأخرة
    </h1>
    <div>
        <a href="{{ route('sessions.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i> العودة للجلسات
        </a>
        <a href="{{ route('sessions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> بدء جلسة جديدة
        </a>
    </div>
</div>

<!-- تنبيه -->
<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle fs-4 me-2"></i>
                <div>
                    <strong>تنبيه!</strong><br>
                    <small>هذه الجلسات يفترض أن تكون قد انتهت ولكن لم يتم إنهاؤها بعد. يرجى مراجعة كل جلسة وإنهاؤها عند الحاجة.</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
</div>

<!-- إحصائيات الجلسات المتأخرة -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_overdue'] }}</h4>
                        <p class="card-text">إجمالي الجلسات المتأخرة</p>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
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
                        <h4>{{ $stats['overdue_by_category']['hourly'] }}</h4>
                        <p class="card-text">جلسات ساعية متأخرة</p>
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
                        <h4>{{ $stats['overdue_by_category']['subscription'] }}</h4>
                        <p class="card-text">جلسات اشتراك متأخرة</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-check fs-1"></i>
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
                        <h4>{{ $stats['overdue_by_category']['overtime'] }}</h4>
                        <p class="card-text">جلسات إضافية متأخرة</p>
                    </div>
                    <div>
                        <i class="bi bi-hourglass-split fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلتر الجلسات المتأخرة -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-body">
                <form method="GET" action="{{ route('sessions.overdue') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="session_category" class="form-label">
                            <i class="bi bi-funnel text-info"></i>
                            نوع الجلسة
                        </label>
                        <select name="session_category" id="session_category" class="form-select">
                            <option value="">جميع الأنواع</option>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" {{ request('session_category') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="search" class="form-label">
                            <i class="bi bi-search text-primary"></i>
                            البحث
                        </label>
                        <input type="text" name="search" id="search" class="form-control" 
                               placeholder="ابحث بالاسم، البريد الإلكتروني، أو رقم الهاتف..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> بحث
                        </button>
                    </div>
                    @if(request()->hasAny(['session_category', 'search']))
                        <div class="col-12">
                            <a href="{{ route('sessions.overdue') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> إزالة الفلاتر
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<!-- جدول الجلسات المتأخرة -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-ul text-danger"></i>
                قائمة الجلسات المتأخرة
            </h5>
            <div class="text-muted">
                <small>
                    <i class="bi bi-list-ul"></i>
                    عرض {{ $sessions->count() }} من {{ $sessions->total() }} جلسة متأخرة
                </small>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($sessions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>رقم الجلسة</th>
                        <th>المستخدم</th>
                        <th>صاحب الجلسة</th>
                        <th>الفئة</th>
                        <th>بداية الجلسة</th>
                        <th>التاريخ المتوقع للانتهاء</th>
                        <th>مدة التأخير</th>
                        <th>التكلفة</th>
                        <th>حالة الدفع</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    @php
                        $expectedEndDate = $session->getExpectedEndDate();
                        $daysOverdue = $session->getDaysUntilExpectedEnd();
                        $isOverdue = $session->isOverdue();
                    @endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                        <td>
                            <span class="fw-bold">#{{ $session->id }}</span>
                        </td>
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
                        <td>
                            @if($session->session_owner)
                                <span class="text-info fw-bold">{{ $session->session_owner }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($session->session_category == 'hourly')
                                <span class="badge bg-info">ساعي</span>
                            @elseif($session->session_category == 'subscription')
                                <span class="badge bg-success">اشتراك</span>
                            @else
                                <span class="badge bg-secondary">إضافي</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <div class="fw-bold">{{ $session->start_at->format('Y-m-d') }}</div>
                                <div class="text-muted">{{ $session->start_at->format('H:i') }}</div>
                            </div>
                        </td>
                        <td>
                            @if($expectedEndDate)
                                <div class="small">
                                    <div class="fw-bold text-danger">{{ $expectedEndDate->format('Y-m-d') }}</div>
                                    <div class="text-muted">{{ $expectedEndDate->format('H:i') }}</div>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($daysOverdue !== null && $daysOverdue < 0)
                                <span class="badge bg-danger">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    متأخرة {{ abs($daysOverdue) }} يوم
                                </span>
                            @elseif($daysOverdue !== null && $daysOverdue == 0)
                                <span class="badge bg-warning">
                                    <i class="bi bi-clock"></i>
                                    تنتهي اليوم
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i>
                                    {{ $daysOverdue ?? 0 }} يوم متبقي
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($session->payment)
                                @php
                                    $drinksCost = $session->drinks->sum('price');
                                    $internetCost = $session->calculateInternetCost();
                                @endphp
                                <div class="small">
                                    <div class="fw-bold">₪{{ number_format($session->payment->total_price, 2) }}</div>
                                    <div class="text-muted">
                                        <small>
                                            إنترنت: ₪{{ number_format($internetCost, 2) }}<br>
                                            مشروبات: ₪{{ number_format($drinksCost, 2) }}
                                        </small>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">₪0.00</span>
                            @endif
                        </td>
                        <td>
                            @if($session->payment)
                                @if($session->payment->payment_status == 'paid')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> مدفوع
                                    </span>
                                @elseif($session->payment->payment_status == 'partial')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock-history"></i> دفع جزئي
                                    </span>
                                @elseif($session->payment->payment_status == 'pending')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-hourglass-split"></i> قيد الانتظار
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">غير محدد</span>
                                @endif
                            @else
                                <span class="badge bg-light text-dark">لا توجد مدفوعة</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('sessions.show', $session) }}" class="btn btn-sm btn-outline-primary" title="عرض التفاصيل">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('sessions.edit', $session) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($session->session_category == 'subscription')
                                    <form action="{{ route('sessions.end-subscription', $session) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" 
                                                title="إنهاء الجلسة"
                                                onclick="return confirm('هل أنت متأكد من إنهاء هذه الجلسة؟')">
                                            <i class="bi bi-stop-circle"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('sessions.end', $session) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" 
                                                title="إنهاء الجلسة"
                                                onclick="return confirm('هل أنت متأكد من إنهاء هذه الجلسة؟')">
                                            <i class="bi bi-stop-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $sessions->links() }}
        </div>
        @else
        <div class="text-center py-5">
            @if(request()->hasAny(['session_category', 'search']))
                <div class="alert alert-warning">
                    <i class="bi bi-search display-1 text-warning"></i>
                    <h5 class="mt-3">لا توجد نتائج</h5>
                    <p class="text-muted mb-3">لا توجد جلسات متأخرة تطابق معايير البحث</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('sessions.overdue') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-counterclockwise"></i> إعادة تعيين الفلاتر
                        </a>
                        <a href="{{ route('sessions.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> العودة للجلسات
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-success">
                    <i class="bi bi-check-circle display-1 text-success"></i>
                    <h5 class="mt-3">ممتاز!</h5>
                    <p class="text-muted mb-3">لا توجد جلسات متأخرة حالياً</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('sessions.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> العودة للجلسات
                        </a>
                        <a href="{{ route('sessions.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle"></i> بدء جلسة جديدة
                        </a>
                    </div>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>

@endsection

@section('styles')
<style>
.table-danger {
    background-color: #f8d7da !important;
}

.table-danger:hover {
    background-color: #f5c6cb !important;
}
</style>
@endsection

