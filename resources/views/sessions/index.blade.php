@extends('layouts.app')

@section('title', 'إدارة الجلسات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إدارة الجلسات</h1>
    <div>
        <a href="{{ route('sessions.overdue') }}" class="btn btn-outline-danger me-2">
            <i class="bi bi-exclamation-triangle"></i> الجلسات المتأخرة
        </a>
        <a href="{{ route('sessions.trashed') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-trash"></i> الجلسات المحذوفة
        </a>
        <a href="{{ route('sessions.create') }}" class="btn btn-primary" style="padding-left: 35px; padding-right: 35px;">
            <i class="bi bi-plus-circle"></i> بدء جلسة جديدة
        </a>
    </div>
</div>


<!-- فلتر الجلسات -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-body">
                <form method="GET" action="{{ route('sessions.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="session_category" class="form-label">
                            <i class="bi bi-funnel text-info"></i>
                            نوع الجلسة
                        </label>
                        <select name="session_category" id="session_category" class="form-select">
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" {{ (request('session_category') ?: 'hourly') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="session_status" class="form-label">
                            <i class="bi bi-activity text-primary"></i>
                            حالة الجلسة
                        </label>
                        <select name="session_status" id="session_status" class="form-select">
                            <option value="all" {{ request('session_status') == 'all' ? 'selected' : '' }}>كل حالات الجلسات</option>
                            <option value="active" {{ (request('session_status') === null || request('session_status') === '') ? 'selected' : (request('session_status') == 'active' ? 'selected' : '') }}>نشط</option>
                            <option value="completed" {{ request('session_status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ request('session_status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="refund_status" class="form-label">
                            <i class="bi bi-cash-coin text-warning"></i>
                            حالة الديون
                        </label>
                        <select name="refund_status" id="refund_status" class="form-select">
                            <option value="">جميع الحالات</option>
                            <option value="needs_refund" {{ request('refund_status') == 'needs_refund' ? 'selected' : '' }}>يحتاج إرجاع (يستحق له)</option>
                            <option value="has_remaining" {{ request('refund_status') == 'has_remaining' ? 'selected' : '' }}>متبقي للدفع (يستحق لنا)</option>
                            <option value="fully_paid" {{ request('refund_status') == 'fully_paid' ? 'selected' : '' }}>مكتمل الدفع</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="start_date_from" class="form-label">
                            <i class="bi bi-calendar-date text-warning"></i>
                            من تاريخ
                        </label>
                        <input type="date"
                               name="start_date_from"
                               id="start_date_from"
                               class="form-control"
                               value="{{ request('start_date_from', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <label for="start_date_to" class="form-label">
                            <i class="bi bi-calendar-date text-warning"></i>
                            إلى تاريخ
                        </label>
                        <input type="date"
                               name="start_date_to"
                               id="start_date_to"
                               class="form-control"
                               value="{{ request('start_date_to', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">
                            <i class="bi bi-search text-primary"></i>
                            البحث
                        </label>
                        <div class="input-group">
                            <input type="text"
                                   name="search"
                                   id="search"
                                   class="form-control"
                                   placeholder="اسم المستخدم أو صاحب الجلسة..."
                                   value="{{ request('search') }}">
                            <button type="button" id="clearSearch" class="btn btn-outline-secondary" style="display: none;">
                                <i class="bi bi-x"></i>
                            </button>
                            <span class="input-group-text" id="searchIndicator">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                        </div>
                        <small class="form-text text-muted">
                            <i class="bi bi-info-circle"></i>
                            ابحث في اسم المستخدم، البريد الإلكتروني، الهاتف، اسم صاحب الجلسة، أو الملاحظات
                        </small>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2 align-items-center">
                            <small class="text-muted">
                                <span id="resultsCount">{{ $sessions->total() }}</span> نتيجة
                                <span id="filteredText" style="display: none;"> | <span id="visibleCount">0</span> ظاهرة</span>
                            </small>
                            @if(request()->hasAny(['session_category', 'search', 'refund_status', 'session_status', 'start_date_from', 'start_date_to']))
                                <a href="{{ route('sessions.index') }}" class="btn btn-warning text-dark fw-bold shadow-sm" style="padding: 0.5rem 1rem;">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> تنظيف الفلتر 
                                </a>
                            @endif
                        </div>
                    </div>
                    @if(request('session_category') || request('search') || request('refund_status') || request('session_status') || request('start_date_from') || request('start_date_to'))
                        <div class="col-md-12">
                            <div class="alert alert-info mb-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small>
                                        <i class="bi bi-info-circle"></i>
                                        <strong>الفلترة المطبقة:</strong>
                                        @if(request('session_status'))
                                            <span class="badge bg-primary ms-1">
                                                @if(request('session_status') == 'active') نشط
                                                @elseif(request('session_status') == 'completed') مكتمل
                                                @elseif(request('session_status') == 'cancelled') ملغي
                                                @endif
                                            </span>
                                        @endif
                                        @if(request('session_category'))
                                            <span class="badge bg-info ms-1">{{ $categories[request('session_category')] }}</span>
                                        @endif
                                        @if(request('refund_status'))
                                            <span class="badge bg-warning ms-1">
                                                @if(request('refund_status') == 'needs_refund') يحتاج إرجاع
                                                @elseif(request('refund_status') == 'has_remaining') متبقي للدفع
                                                @elseif(request('refund_status') == 'fully_paid') مكتمل الدفع
                                                @endif
                                            </span>
                                        @endif
                                        @if(request('start_date_from') || request('start_date_to'))
                                            <span class="badge bg-warning ms-1">
                                                @if(request('start_date_from') && request('start_date_to'))
                                                    {{ request('start_date_from') }} إلى {{ request('start_date_to') }}
                                                @elseif(request('start_date_from'))
                                                    من {{ request('start_date_from') }}
                                                @elseif(request('start_date_to'))
                                                    إلى {{ request('start_date_to') }}
                                                @endif
                                            </span>
                                        @endif
                                        @if(request('search'))
                                            <span class="badge bg-primary ms-1">بحث: {{ request('search') }}</span>
                                        @endif
                                    </small>
                                    <small class="text-muted">
                                        <span id="resultsCount">{{ $sessions->total() }}</span> نتيجة
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<!-- أزرار العمليات الجماعية -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="mb-2">
                            <i class="bi bi-check-square text-primary"></i>
                            العمليات الجماعية للجلسات
                        </h6>
                        <small class="text-muted">حدد الجلسات واختر العملية المطلوبة</small>
                        <div class="alert alert-warning alert-sm mt-2 mb-0" id="bulkDeleteWarning" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i>
                            <small><strong>تنبيه:</strong> لا يمكن حذف الجلسات النشطة. يجب إنهاؤها أولاً.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form id="bulkActionsForm" action="{{ route('sessions.bulk-destroy') }}" method="POST" class="d-inline">
                            @csrf
                            @if(request()->hasAny(['session_category', 'user_search', 'start_date_from', 'start_date_to']))
                                <input type="hidden" name="return_to" value="{{ request()->fullUrl() }}">
                            @endif
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-check-all"></i> تحديد الكل
                                </button>
                                <button type="button" id="deselectAllBtn" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x-square"></i> إلغاء التحديد
                                </button>
                                <button type="submit" id="bulkDeleteBtn" class="btn btn-sm btn-outline-danger" disabled>
                                    <i class="bi bi-trash"></i> حذف المحددة
                                </button>
                                <button type="button" id="bulkDeleteInfoBtn" class="btn btn-sm btn-outline-info" style="display: none;">
                                    <i class="bi bi-info-circle"></i> معلومات الحذف
                                </button>
                                <span class="badge bg-info" id="selectedCount">0 محدد</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- جدول الجلسات -->
<div class="card">
            <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">قائمة الجلسات</h5>
                <div class="text-muted">
                    <small>
                        <i class="bi bi-list-ul"></i>
                        عرض {{ $sessions->count() }} من {{ $sessions->total() }} جلسة
                        @if(request()->hasAny(['session_category', 'search', 'session_status', 'start_date_from', 'start_date_to']))
                            <span class="text-primary">(مفلترة)</span>
                        @endif
                        @if(request('session_status'))
                            <span class="badge bg-primary ms-1">
                                {{ request('session_status') == 'active' ? 'الجلسات النشطة' : (request('session_status') == 'completed' ? 'الجلسات المكتملة' : 'الجلسات الملغاة') }}
                            </span>
                        @endif
                    </small>
                </div>
            </div>
        </div>
    <div class="card-body">
        @if($sessions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="50">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                <label class="form-check-label" for="selectAllCheckbox">
                                    <small>الكل</small>
                                </label>
                            </div>
                        </th>
                        <th>رقم الجلسة</th>
                        <th>المستخدم</th>
                        <th>صاحب الجلسة</th>
                        <th>الفئة</th>
                        <th>بداية الجلسة</th>
                        <th>التكلفة</th>
                        <th>المبلغ المرتجع</th>
                        <th>حالة الدفع</th>
                        <th>حالة الجلسة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input session-checkbox" type="checkbox"
                                       name="session_ids[]" value="{{ $session->id }}"
                                       id="session_{{ $session->id }}">
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('sessions.show', $session) }}" class="text-decoration-none text-primary fw-medium session-link"
                               title="انقر لعرض تفاصيل الجلسة">
                                #{{ $session->id }}
                            </a>
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
                            @if($session->note)
                                <br>
                                <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">
                                    <i class="bi bi-sticky"></i> {{ Str::limit($session->note, 50) }}
                                </small>
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
                        <td>{{ $session->start_at->format('Y-m-d H:i') }}</td>
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
                                @php
                                    $totalPaid = $session->payment->amount_bank + $session->payment->amount_cash;
                                    $refundAmount = $totalPaid - $session->payment->total_price;
                                @endphp
                                @if($refundAmount > 0)
                                    <div class="text-success">
                                        <i class="bi bi-arrow-down-circle"></i>
                                        <span class="fw-bold">₪{{ number_format($refundAmount, 2) }}</span>
                                        <small class="d-block text-muted">يجب إرجاعه (يستحق له)</small>
                                    </div>
                                @elseif($refundAmount < 0)
                                    <div class="text-danger">
                                        <i class="bi bi-arrow-up-circle"></i>
                                        <span class="fw-bold">₪{{ number_format(abs($refundAmount), 2) }}</span>
                                        <small class="d-block text-muted">متبقي للدفع (يستحق لنا)</small>
                                    </div>
                                @else
                                    <div class="text-muted">
                                        <i class="bi bi-check-circle"></i>
                                        <small>مكتمل الدفع</small>
                                    </div>
                                @endif
                            @else
                                <span class="text-muted">-</span>
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
                                @elseif($session->payment->payment_status == 'cancelled')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> ملغي
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">غير محدد</span>
                                @endif
                            @else
                                <span class="badge bg-light text-dark">لا توجد مدفوعة</span>
                            @endif
                        </td>
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
                            <div class="btn-group" role="group">
                                <a href="{{ route('sessions.show', $session) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($session->session_status == 'active')
                                <a href="{{ route('sessions.edit', $session) }}" class="btn btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                @if($session->session_status == 'completed')
                                <form action="{{ route('sessions.cancel', $session) }}" method="POST" class="d-inline session-cancel-form">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger session-cancel-btn"
                                            data-session-id="{{ $session->id }}"
                                            onclick="return confirmSessionCancellation({{ $session->id }})">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('sessions.destroy', $session) }}" method="POST" class="d-inline session-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger session-delete-btn"
                                            data-session-id="{{ $session->id }}"
                                            data-session-status="{{ $session->session_status }}"
                                            onclick="return confirmSessionDeletion(this, {{ $session->id }}, '{{ $session->session_status }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $sessions->links() }}
        </div>
        @else
        <div class="text-center py-5">
            @if(request()->hasAny(['session_category', 'search', 'session_status', 'start_date_from', 'start_date_to']))
                <div class="alert alert-warning">
                    <i class="bi bi-search display-1 text-warning"></i>
                    <h5 class="mt-3">لا توجد نتائج</h5>
                    <p class="text-muted mb-3">جرب تغيير معايير البحث أو الفلترة</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('sessions.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-counterclockwise"></i> إعادة تعيين الفلاتر
                        </a>
                        <a href="{{ route('sessions.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> بدء جلسة جديدة
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-clock display-1 text-info"></i>
                    <h5 class="mt-3">لا توجد جلسات</h5>
                    <p class="text-muted mb-3">ابدأ بإنشاء جلسة جديدة</p>
                    <a href="{{ route('sessions.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> بدء جلسة جديدة
                    </a>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>

@endsection

@section('styles')
<style>
.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.alert-sm .bi {
    font-size: 0.875rem;
}

#bulkDeleteWarning {
    border-left: 4px solid #ffc107;
}

#bulkDeleteBtn:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

#bulkDeleteInfoBtn {
    border-color: #17a2b8;
    color: #17a2b8;
}

#bulkDeleteInfoBtn:hover {
    background-color: #17a2b8;
    color: white;
}

/* تنسيق أزرار حذف الجلسات */
.session-delete-btn[data-session-status="active"] {
    opacity: 0.6;
    cursor: not-allowed;
    position: relative;
}

.session-delete-btn[data-session-status="active"]:hover {
    background-color: #dc3545;
    color: white;
}

.session-delete-btn[data-session-status="active"]::after {
    content: "⚠️";
    position: absolute;
    top: -8px;
    right: -8px;
    font-size: 12px;
    background: #ffc107;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
}

/* تنسيق زر إلغاء الجلسة */
.session-cancel-btn {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.session-cancel-btn:hover {
    background-color: #c82333;
    border-color: #bd2130;
    color: white;
}

.session-cancel-btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}


</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCount = document.getElementById('selectedCount');
    const bulkActionsForm = document.getElementById('bulkActionsForm');



    // Real-time search elements
    const searchInput = document.getElementById('search');
    const sessionCategorySelect = document.getElementById('session_category');
    const sessionStatusSelect = document.getElementById('session_status');
    const startDateFromInput = document.getElementById('start_date_from');
    const startDateToInput = document.getElementById('start_date_to');
    const clearSearchBtn = document.getElementById('clearSearch');
    const searchIndicator = document.getElementById('searchIndicator');
    const resultsCount = document.getElementById('resultsCount');
    const filteredText = document.getElementById('filteredText');
    const visibleCount = document.getElementById('visibleCount');

    let searchTimeout;

    function getSessionCheckboxes() {
        return document.querySelectorAll('.session-checkbox');
    }

    function getVisibleSessionRows() {
        return document.querySelectorAll('tbody tr:not([style*="display: none"])');
    }

    function updateSelectedCount() {
        const sessionCheckboxes = getSessionCheckboxes();
        const visibleCheckboxes = document.querySelectorAll('tbody tr:not([style*="display: none"]) .session-checkbox');
        const checkedBoxes = document.querySelectorAll('.session-checkbox:checked');
        const count = checkedBoxes.length;

        if (selectedCount) {
            selectedCount.textContent = count + ' محدد';
        }

        // التحقق من حالة الجلسات المحددة
        let hasActiveSessions = false;
        let hasCompletedSessions = false;
        let activeSessionIds = [];
        let completedSessionIds = [];

        checkedBoxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const statusCell = row.cells[11]; // Session status column (index 11)
            const statusBadge = statusCell?.querySelector('.badge');

            if (statusBadge) {
                const status = statusBadge.textContent.trim();

                if (status === 'نشط') {
                    hasActiveSessions = true;
                    const sessionId = row.cells[1]?.textContent?.replace('#', '') || '';
                    if (sessionId) activeSessionIds.push(sessionId);
                } else if (status === 'مكتمل') {
                    hasCompletedSessions = true;
                    const sessionId = row.cells[1]?.textContent?.replace('#', '') || '';
                    if (sessionId) completedSessionIds.push(sessionId);
                }
            }
        });

        // تحديث حالة الأزرار
        if (bulkDeleteBtn) {
            if (count === 0) {
                bulkDeleteBtn.disabled = true;
            } else if (hasActiveSessions) {
                bulkDeleteBtn.disabled = true;
                bulkDeleteBtn.title = `لا يمكن حذف الجلسات النشطة: ${activeSessionIds.join(', ')}`;
            } else {
                bulkDeleteBtn.disabled = false;
                bulkDeleteBtn.title = '';
            }
        }



        // إظهار/إخفاء رسالة التحذير
        const bulkDeleteWarning = document.getElementById('bulkDeleteWarning');
        if (bulkDeleteWarning) {
            if (count > 0 && hasActiveSessions) {
                bulkDeleteWarning.style.display = 'block';
                bulkDeleteWarning.innerHTML = `
                    <i class="bi bi-exclamation-triangle"></i>
                    <small><strong>تنبيه:</strong> لا يمكن حذف الجلسات النشطة التالية: ${activeSessionIds.join(', ')}. يجب إنهاؤها أولاً.</small>
                `;
            } else {
                bulkDeleteWarning.style.display = 'none';
            }
        }

        // إظهار/إخفاء زر معلومات الحذف
        const bulkDeleteInfoBtn = document.getElementById('bulkDeleteInfoBtn');
        if (bulkDeleteInfoBtn) {
            if (count > 0 && hasActiveSessions) {
                bulkDeleteInfoBtn.style.display = 'inline-block';
            } else {
                bulkDeleteInfoBtn.style.display = 'none';
            }
        }

        // Update select all checkbox state based on visible checkboxes
        if (selectAllCheckbox) {
            const visibleCheckedBoxes = document.querySelectorAll('tbody tr:not([style*="display: none"]) .session-checkbox:checked');
            if (visibleCheckedBoxes.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (visibleCheckedBoxes.length === visibleCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }
    }

    function filterSessions() {
        // Only apply client-side filtering for search, not for server-side filters
        const searchTerm = searchInput.value.toLowerCase().trim();

        // Don't apply client-side filtering if server-side filters are active
        if (window.location.search.includes('session_status') ||
            window.location.search.includes('session_category') ||
            window.location.search.includes('refund_status') ||
            window.location.search.includes('start_date_from') ||
            window.location.search.includes('start_date_to') ||
            window.location.search.includes('search')) {
            return; // Exit early if server-side filters are active
        }

        const categoryFilter = sessionCategorySelect.value;
        const sessionStatusFilter = sessionStatusSelect.value;
        const dateFromFilter = startDateFromInput.value;
        const dateToFilter = startDateToInput.value;
        const tableRows = document.querySelectorAll('tbody tr');
        let visibleRowsCount = 0;

        // Show search indicator
        if (searchIndicator) {
            const icon = searchIndicator.querySelector('i');
            icon.className = 'bi bi-hourglass-split text-primary';
        }

        tableRows.forEach(row => {
            let showRow = true;

            // Combined search filter (user name, session owner, and notes)
            if (searchTerm) {
                const userName = row.cells[2]?.textContent?.toLowerCase() || '';
                const sessionOwner = row.cells[3]?.textContent?.toLowerCase() || '';
                // Note is included in userName cell, so searching userName will also search notes
                const userMatch = userName.includes(searchTerm);
                const ownerMatch = sessionOwner.includes(searchTerm);
                if (!userMatch && !ownerMatch) showRow = false;
            }

            // Category filter
            if (categoryFilter) {
                const categoryCell = row.cells[4];
                const categoryBadge = categoryCell?.querySelector('.badge');
                let categoryMatch = false;

                if (categoryBadge) {
                    const badgeText = categoryBadge.textContent.trim();
                    if (categoryFilter === 'hourly' && badgeText === 'ساعي') categoryMatch = true;
                    else if (categoryFilter === 'subscription' && badgeText === 'اشتراك') categoryMatch = true;

                    else if (categoryFilter === 'overtime' && badgeText === 'إضافي') categoryMatch = true;
                }

                if (!categoryMatch) showRow = false;
            }

            // Session status filter
            if (sessionStatusFilter) {
                const statusCell = row.cells[10]; // Session status column (index 10)
                const statusBadge = statusCell?.querySelector('.badge');
                let statusMatch = false;

                if (statusBadge) {
                    const badgeText = statusBadge.textContent.trim();
                    if (sessionStatusFilter === 'active' && badgeText === 'نشط') statusMatch = true;
                    else if (sessionStatusFilter === 'completed' && badgeText === 'مكتمل') statusMatch = true;
                    else if (sessionStatusFilter === 'cancelled' && badgeText === 'ملغي') statusMatch = true;
                }

                if (!statusMatch) showRow = false;
            }

            // Date filter (client-side for visible rows)
            if (dateFromFilter || dateToFilter) {
                const dateCell = row.cells[5]; // Start date column (index 5)
                const dateText = dateCell?.textContent?.trim();

                if (dateText && dateText !== '-') {
                    const sessionDate = new Date(dateText);

                    if (dateFromFilter) {
                        const fromDate = new Date(dateFromFilter);
                        if (sessionDate < fromDate) showRow = false;
                    }

                    if (dateToFilter && showRow) {
                        const toDate = new Date(dateToFilter);
                        if (sessionDate > toDate) showRow = false;
                    }
                }
            }

            // Show/hide row
            if (showRow) {
                row.style.display = '';
                visibleRowsCount++;
            } else {
                row.style.display = 'none';
                // Uncheck hidden rows
                const checkbox = row.querySelector('.session-checkbox');
                if (checkbox) checkbox.checked = false;
            }
        });

        // Update counters
        if (visibleCount) {
            visibleCount.textContent = visibleRowsCount;
        }

        // Show/hide filtered text
        if (filteredText) {
            if (searchTerm || categoryFilter || sessionStatusFilter || dateFromFilter || dateToFilter) {
                filteredText.style.display = 'inline';
            } else {
                filteredText.style.display = 'none';
            }
        }

        // Show/hide clear button
        if (clearSearchBtn) {
            if (searchTerm) {
                clearSearchBtn.style.display = 'block';
            } else {
                clearSearchBtn.style.display = 'none';
            }
        }

        // Update checkboxes
        updateSelectedCount();

        // Reset search indicator
        setTimeout(() => {
            if (searchIndicator) {
                const icon = searchIndicator.querySelector('i');
                icon.className = 'bi bi-search text-muted';
            }
        }, 200);
    }

    // Debounced search function
    function debouncedFilter() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterSessions, 300);
    }

    function addCheckboxListeners() {
        const sessionCheckboxes = getSessionCheckboxes();
        sessionCheckboxes.forEach(checkbox => {
            checkbox.removeEventListener('change', updateSelectedCount);
            checkbox.addEventListener('change', updateSelectedCount);
        });
    }

    // Real-time search event listeners
    if (searchInput) {
        searchInput.addEventListener('input', debouncedFilter);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                filterSessions();
            }
        });
    }

    if (sessionCategorySelect) {
        sessionCategorySelect.addEventListener('change', function() {
            // Use server-side filtering for category
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    }

    if (sessionStatusSelect) {
        sessionStatusSelect.addEventListener('change', function() {
            // Use server-side filtering for session status
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    }

    // Add event listener for refund status filter
    const refundStatusSelect = document.getElementById('refund_status');
    if (refundStatusSelect) {
        refundStatusSelect.addEventListener('change', function() {
            // Use server-side filtering for refund status
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    }

    if (startDateFromInput) {
        startDateFromInput.addEventListener('change', function() {
            // Use server-side filtering for date
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    }

    if (startDateToInput) {
        startDateToInput.addEventListener('change', function() {
            // Use server-side filtering for date
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterSessions();
            searchInput.focus();
        });
    }

    // Handle select all checkbox (only visible rows)
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const visibleCheckboxes = document.querySelectorAll('tbody tr:not([style*="display: none"]) .session-checkbox');
            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });
    }

    // Handle select all button (only visible rows)
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            const visibleCheckboxes = document.querySelectorAll('tbody tr:not([style*="display: none"]) .session-checkbox');
            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = true;
            }

            updateSelectedCount();
        });
    }

    // Handle deselect all button
    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function() {
            const sessionCheckboxes = getSessionCheckboxes();
            sessionCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = false;
            }

            updateSelectedCount();
        });
    }

    // Handle bulk delete form submission
    if (bulkActionsForm) {
        bulkActionsForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.session-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('يرجى تحديد جلسة واحدة على الأقل');
                return;
            }

            // التحقق من وجود جلسات نشطة
            let hasActiveSessions = false;
            let activeSessionIds = [];

            checkedBoxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const statusCell = row.cells[10]; // Session status column
                const statusBadge = statusCell?.querySelector('.badge');

                if (statusBadge && statusBadge.textContent.trim() === 'نشط') {
                    hasActiveSessions = true;
                    const sessionId = row.cells[1]?.textContent?.replace('#', '') || '';
                    if (sessionId) activeSessionIds.push(sessionId);
                }
            });

            if (hasActiveSessions) {
                e.preventDefault();
                alert(`لا يمكن حذف الجلسات النشطة التالية: ${activeSessionIds.join(', ')}\n\nيجب إنهاؤها أولاً قبل الحذف.`);
                return;
            }

            // Clear previous hidden inputs
            const existingInputs = this.querySelectorAll('input[name="session_ids[]"]');
            existingInputs.forEach(input => input.remove());

            // Add checked session IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'session_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });

            if (!confirm(`هل تريد حذف ${checkedBoxes.length} جلسة؟ (يمكن استرجاعها لاحقاً)`)) {
                e.preventDefault();
            }
        });
    }



    // Handle bulk delete info button
    const bulkDeleteInfoBtn = document.getElementById('bulkDeleteInfoBtn');
    if (bulkDeleteInfoBtn) {
        bulkDeleteInfoBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.session-checkbox:checked');
            let activeSessionIds = [];
            let completedSessionIds = [];
            let cancelledSessionIds = [];

            checkedBoxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const sessionId = row.cells[1]?.textContent?.replace('#', '') || '';
                const statusCell = row.cells[10]; // Session status column
                const statusBadge = statusCell?.querySelector('.badge');

                if (statusBadge) {
                    const status = statusBadge.textContent.trim();
                    if (status === 'نشط') {
                        activeSessionIds.push(sessionId);
                    } else if (status === 'مكتمل') {
                        completedSessionIds.push(sessionId);
                    } else if (status === 'ملغي') {
                        cancelledSessionIds.push(sessionId);
                    }
                }
            });

            let message = 'معلومات الجلسات المحددة:\n\n';

            if (activeSessionIds.length > 0) {
                message += `❌ الجلسات النشطة (لا يمكن حذفها): ${activeSessionIds.join(', ')}\n`;
            }
            if (completedSessionIds.length > 0) {
                message += `✅ الجلسات المكتملة (يمكن حذفها): ${completedSessionIds.join(', ')}\n`;
            }
            if (cancelledSessionIds.length > 0) {
                message += `🚫 الجلسات الملغاة (يمكن حذفها): ${cancelledSessionIds.join(', ')}\n`;
            }

            message += '\nملاحظة: يجب إنهاء الجلسات النشطة قبل حذفها.';

            alert(message);
        });
    }

    // Function to confirm session deletion with status check
    window.confirmSessionDeletion = function(button, sessionId, sessionStatus) {
        if (sessionStatus === 'active') {
            alert(`❌ لا يمكن حذف الجلسة النشطة رقم #${sessionId}\n\nيجب إنهاؤها أولاً قبل الحذف.`);
            return false;
        }

        return confirm(`هل تريد حذف الجلسة رقم #${sessionId}؟ (يمكن استرجاعها لاحقاً)`);
    };

    // Function to confirm session cancellation
    window.confirmSessionCancellation = function(sessionId) {
        return confirm(`هل تريد إلغاء الجلسة رقم #${sessionId}؟\n\n⚠️ تحذير: سيتم تغيير حالة الجلسة من مكتملة إلى ملغية، وسيتم تغيير حالة الدفع إلى ملغية أيضاً.\n\nهذا الإجراء لا يمكن التراجع عنه.`);
    };

    // Initialize
    addCheckboxListeners();
    updateSelectedCount();

    // Apply initial filter only for client-side search (not for server-side filters)
    if (searchInput.value) {
        filterSessions();
    }

    // Show all rows if server-side filters are active
    if (window.location.search.includes('session_status') ||
        window.location.search.includes('session_category') ||
        window.location.search.includes('refund_status') ||
        window.location.search.includes('start_date_from') ||
        window.location.search.includes('start_date_to') ||
        window.location.search.includes('search')) {
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.style.display = '';
        });
    }
});

// Toast message for filter confirmation
@if(request()->hasAny(['session_category', 'search', 'refund_status', 'session_status', 'start_date_from', 'start_date_to']))
(function() {
    let filterMessage = 'تم تطبيق الفلتر بنجاح!';
    let filterDetails = '';
    
    @if(request('session_status'))
        @if(request('session_status') == 'active')
            filterDetails = 'عرض الجلسات النشطة فقط ({{ $sessions->total() }} جلسة)';
        @elseif(request('session_status') == 'completed')
            filterDetails = 'عرض الجلسات المكتملة فقط ({{ $sessions->total() }} جلسة)';
        @elseif(request('session_status') == 'cancelled')
            filterDetails = 'عرض الجلسات الملغاة فقط ({{ $sessions->total() }} جلسة)';
        @endif
    @else
        filterDetails = 'تم تطبيق الفلتر المحدد ({{ $sessions->total() }} جلسة)';
    @endif
    
    document.addEventListener('DOMContentLoaded', function() {
        // Create toast container
        const toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-bs-autohide', 'true');
        toast.setAttribute('data-bs-delay', '5000');
        
        toast.innerHTML = `
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">${filterMessage}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${filterDetails}
            </div>
        `;
        
        toastContainer.appendChild(toast);
        document.body.appendChild(toastContainer);
        
        // Initialize and show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove container after toast is hidden
        toast.addEventListener('hidden.bs.toast', function() {
            if (toastContainer.parentNode) {
                toastContainer.remove();
            }
        });
    });
})();
@endif
</script>
@endsection
