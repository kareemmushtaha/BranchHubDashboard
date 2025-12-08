@extends('layouts.app')

@section('title', 'تفاصيل المستخدم')

@push('styles')
<style>
.session-link {
    transition: all 0.3s ease-in-out;
    position: relative;
}
.session-link:hover {
    transform: translateX(8px);
    color: #0056b3 !important;
    text-decoration: none !important;
}
.session-link::after {
    content: '→';
    position: absolute;
    right: -15px;
    opacity: 0;
    transition: all 0.3s ease;
}
.session-link:hover::after {
    opacity: 1;
    right: -20px;
}

.session-row {
    transition: all 0.2s ease-in-out;
    border-left: 4px solid transparent;
}
.session-row:hover {
    background-color: #f8f9fa;
    border-left-color: #007bff;
    transform: translateX(5px);
}

.user-info-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.wallet-card {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.financial-summary-card {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stats-card {
    background: white;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border-radius: 15px;
}
.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.sessions-card {
    background: white;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border-radius: 15px;
}

.badge-custom {
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 500;
}

.alert-custom {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.table-custom {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.table-custom thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-weight: 600;
    padding: 15px 12px;
}

.table-custom tbody tr {
    transition: all 0.2s ease;
}

.table-custom tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-custom {
    border-radius: 25px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.modal-custom .modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
}

.modal-custom .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    border: none;
}

.progress-ring {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: conic-gradient(#28a745 0deg, #28a745 calc(var(--progress) * 360deg), #e9ecef calc(var(--progress) * 360deg), #e9ecef 360deg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.progress-ring::before {
    content: '';
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%;
}

.progress-text {
    position: absolute;
    font-weight: bold;
    color: #333;
}

.user-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 auto 20px;
}

.info-item {
    padding: 12px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    opacity: 0.9;
}

.info-value {
    font-weight: 600;
}

.amount-display {
    font-size: 1.5rem;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 10px;
    text-align: center;
    margin: 10px 0;
}

.amount-positive {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 2px solid #c3e6cb;
}

.amount-negative {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 2px solid #f5c6cb;
}

.amount-neutral {
    background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
    color: #383d41;
    border: 2px solid #d6d8db;
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.status-active {
    background: #28a745;
    box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
}

.status-inactive {
    background: #6c757d;
}

.status-suspended {
    background: #dc3545;
    box-shadow: 0 0 10px rgba(220, 53, 69, 0.5);
}


.collapse-icon {
    transition: transform 0.3s ease;
    display: inline-block;
}

[data-bs-toggle="collapse"]:not(.collapsed) .collapse-icon,
[data-bs-toggle="collapse"][aria-expanded="true"] .collapse-icon {
    transform: rotate(180deg);
}

.btn-link {
    color: inherit;
    border: none;
    text-align: right;
}

.btn-link:hover {
    color: inherit;
    background-color: rgba(0,0,0,0.05);
}

.btn-link:focus {
    box-shadow: none;
    outline: none;
}

.btn-link.collapsed .collapse-icon {
    transform: rotate(0deg);
}

@media (max-width: 768px) {
    .stats-card {
        margin-bottom: 20px;
    }

    .table-responsive {
        border-radius: 15px;
        overflow: hidden;
    }

}
</style>
@endpush

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
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div class="d-flex align-items-center">
        <div class="user-avatar me-3">
         </div>
        <div>
            <h4 class="h3 mb-1"> بروفايل المستخدم
            </h4>
            <div class="text-muted mb-0" style="font-size: 1.15rem; line-height: 1.8;">
                @if($user->name_ar)
                    <span class="d-inline-block me-2">
                        <i class="bi bi-translate me-1"></i>
                        <strong>ع:</strong> {{ $user->name_ar }}
                    </span>
                @endif
                @if($user->name)
                    <span class="d-inline-block me-2">
                        <i class="bi bi-person-circle me-1"></i>
                        <strong>En:</strong> {{ $user->name }}
                    </span>
                @endif
                @if($user->phone)
                    <span class="d-inline-block">
                        <i class="bi bi-telephone me-1"></i>
                        <strong>جوال:</strong> {{ $user->phone }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="btn-group">
        @php
            $hasUnpaidInvoices = $drinkInvoices && $drinkInvoices->whereIn('payment_status', ['pending', 'partial'])->count() > 0;
            $unpaidInvoicesList = $drinkInvoices ? $drinkInvoices->whereIn('payment_status', ['pending', 'partial']) : collect();
        @endphp
        <button type="button" class="btn btn-success btn-custom me-2" data-bs-toggle="modal" data-bs-target="#chargeWalletModal" title="شحن المحفظة">
            <i class="bi bi-wallet2 me-1"></i> شحن المحفظة
        </button>
        @if($hasUnpaidInvoices)
        <button type="button" class="btn btn-secondary btn-custom me-2" onclick="showInvoiceAlert()" title="انقر لعرض التفاصيل">
            <i class="bi bi-cup-hot me-1"></i> فاتورة مشروبات
        </button>
        @else
        <a href="{{ route('drink-invoices.create', ['user_id' => $user->id]) }}" class="btn btn-primary btn-custom me-2">
            <i class="bi bi-cup-hot me-1"></i> فاتورة مشروبات
        </a>
        @endif
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-custom me-2">
            <i class="bi bi-pencil me-1"></i> تعديل
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left me-1"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <!-- العمود الجانبي -->
    <div class="col-lg-4 mb-4">
        <!-- ملخص المستحقات المالية -->
        @php
            $totalRemainingAmount = 0;
            $totalRefund = 0;

            foreach($user->sessions as $session) {
                if($session->payment) {
                    // إذا كانت هناك مدفوعة، استخدم القيمة المخزنة في قاعدة البيانات
                    $paidAmount = $session->payment->amount_bank + $session->payment->amount_cash;
                    $remainingAmount = max(0, $session->payment->total_price - $paidAmount);
                    $totalPrice = $session->payment->total_price;

                    $totalRemainingAmount += $remainingAmount;
                    $totalRefund += max(0, $paidAmount - $totalPrice);
                } else {
                    // إذا لم تكن هناك مدفوعة، احسب التكلفة بنفس طريقة صفحة عرض تفاصيل الجلسة
                    $internetCost = $session->calculateInternetCost();
                    $drinksCost = $session->drinks->sum('price');
                    $sessionTotal = $internetCost + $drinksCost;

                    $totalRemainingAmount += $sessionTotal;
                }
            }
        @endphp

        <div class="card financial-summary-card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-cash-coin me-2"></i>
                    ملخص المستحقات المالية
                </h5>

                <div class="text-center mb-4">
                    @if($totalRemainingAmount > 0)
                        <div class="amount-display amount-negative">
                            ₪{{ number_format($totalRemainingAmount, 2) }}
                        </div>
                        <small class="text-muted">إجمالي المبالغ المتبقية</small>
                    @else
                        <div class="amount-display amount-positive">
                            ₪0.00
                        </div>
                        <small class="text-muted">لا توجد مبالغ متبقية</small>
                    @endif
                </div>

                @if($totalRefund > 0)
                    <div class="text-center">
                        <div class="amount-display amount-positive">
                            ₪{{ number_format($totalRefund, 2) }}
                        </div>
                        <small class="text-muted">المبلغ المستحق للزبون</small>
                    </div>
                @endif
            </div>
        </div>

        <!-- إحصائيات سريعة -->
        @php
            $userSessions = $user->sessions()->with('payment')->get();
            $totalSessionsWithPayments = 0;
            $sessionsWithRemainingAmount = 0;

            foreach($userSessions as $userSession) {
                if($userSession->payment) {
                    $paidAmount = $userSession->payment->amount_bank + $userSession->payment->amount_cash;
                    $remainingAmount = max(0, $userSession->payment->total_price - $paidAmount);
                    $totalSessionsWithPayments++;

                    if($remainingAmount > 0) {
                        $sessionsWithRemainingAmount++;
                    }
                } else {
                    $internetCost = $userSession->calculateInternetCost();
                    $drinksCost = $userSession->drinks->sum('price');
                    $sessionTotal = $internetCost + $drinksCost;
                    $sessionsWithRemainingAmount++;
                }
            }
        @endphp

        <div class="card stats-card mb-4">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="bi bi-bar-chart me-2"></i>
                    إحصائيات سريعة
                </h6>
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle text-primary me-2"></i>
                                <small class="text-muted">الجلسات المدفوعة</small>
                            </div>
                            <strong class="text-primary">{{ $totalSessionsWithPayments }}/{{ $userSessions->count() }}</strong>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                <small class="text-muted">جلسات بمبالغ متبقية</small>
                            </div>
                            <strong class="text-warning">{{ $sessionsWithRemainingAmount }}</strong>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-wallet2 text-success me-2"></i>
                                <small class="text-muted">رصيد المحفظة</small>
                            </div>
                            <strong class="text-success">₪{{ number_format($user->wallet->balance ?? 0, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="col-lg-8">
        <!-- الجلسات الأخيرة -->
        <div class="card sessions-card mb-4">
            <div class="card-header bg-transparent border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        الجلسات الأخيرة
                    </h5>
                    <div class="badge bg-primary badge-custom">
                        {{ $user->sessions->count() }} جلسة
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($user->sessions && $user->sessions->count() > 0)
                    <div class="mb-3">
                        <div class="alert alert-info alert-custom">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>دليل الألوان:</strong>
                            <span class="badge bg-warning text-dark me-2">أصفر</span> = جلسة عليها مبلغ متبقي
                            <span class="badge bg-success text-white me-2">أخضر</span> = جلسة يستحق عليها الزبون إرجاع مبلغ
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>الجلسة</th>
                                    <th>نهاية الجلسة</th>
                                    <th>حالة الجلسة</th>
                                    <th>حالة الدفع</th>
                                    <th>المبلغ الكلي</th>
                                    <th>المبلغ المتبقي</th>
                                    <th>المبلغ المستحق للزبون</th>
                                 </tr>
                            </thead>
                            <tbody>
                            @foreach($user->sessions->take(10) as $session)
                                @php
                                    if ($session->payment) {
                                        // إذا كانت هناك مدفوعة، استخدم القيم المخزنة في قاعدة البيانات
                                        $paidAmount = $session->payment->amount_bank + $session->payment->amount_cash;
                                        $totalPrice = $session->payment->total_price;
                                        $remainingAmount = max(0, $totalPrice - $paidAmount);
                                        $refundAmount = max(0, $paidAmount - $totalPrice);
                                    } else {
                                        // إذا لم تكن هناك مدفوعة، احسب التكلفة بنفس طريقة صفحة عرض تفاصيل الجلسة
                                        $internetCost = $session->calculateInternetCost();
                                        $drinksCost = $session->drinks->sum('price');
                                        $sessionTotal = $internetCost + $drinksCost;

                                        $paidAmount = 0;
                                        $totalPrice = $sessionTotal;
                                        $remainingAmount = $sessionTotal;
                                        $refundAmount = 0;
                                    }

                                    // تحديد لون الصف
                                    $rowClass = '';
                                    if ($remainingAmount > 0) {
                                        $rowClass = 'table-warning';
                                    } elseif ($session->payment && $refundAmount > 0) {
                                        $rowClass = 'table-success';
                                    }
                                @endphp
                                <tr class="session-row {{ $rowClass }}">
                                    <td>
                                        <a href="{{ route('sessions.show', $session) }}" class="text-decoration-none text-primary fw-medium session-link"
                                           title="انقر لعرض تفاصيل الجلسة">
                                            #{{ $session->id }} عرض الجلسة
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ $session->start_at->format('Y-m-d H:i') }}</small>
                                    </td>
                                    <td>{{ $session->end_at ? $session->end_at->format('Y-m-d H:i') : 'نشط' }}</td>
                                    <td>
                                        @if($session->session_status == 'active')
                                            <span class="badge bg-success badge-custom">نشط</span>
                                        @elseif($session->session_status == 'completed')
                                            <span class="badge bg-primary badge-custom">مكتمل</span>
                                        @else
                                            <span class="badge bg-danger badge-custom">ملغي</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($session->payment)
                                            @if($session->payment->payment_status == 'paid')
                                                <span class="badge bg-success badge-custom">مدفوعة بالكامل</span>
                                            @elseif($session->payment->payment_status == 'partial')
                                                <span class="badge bg-warning badge-custom">مدفوعة جزئياً</span>
                                            @elseif($session->payment->payment_status == 'pending')
                                                <span class="badge bg-secondary badge-custom">قيد الانتظار</span>
                                            @elseif($session->payment->payment_status == 'cancelled')
                                                <span class="badge bg-danger badge-custom">ملغية</span>
                                            @else
                                                <span class="badge bg-light text-dark badge-custom">غير محدد</span>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-dark badge-custom">لا يوجد دفع</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($session->payment)
                                            <span class="fw-bold">₪{{ number_format($session->payment->total_price, 2) }}</span>
                                        @else
                                            @php
                                                // حساب تكلفة الجلسة بنفس طريقة صفحة عرض تفاصيل الجلسة
                                                $internetCost = $session->calculateInternetCost();
                                                $drinksCost = $session->drinks->sum('price');
                                                $sessionTotal = $internetCost + $drinksCost;
                                            @endphp
                                            <span class="fw-bold">₪{{ number_format($sessionTotal, 2) }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($remainingAmount > 0)
                                            <span class="text-danger fw-bold">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                ₪{{ number_format($remainingAmount, 2) }}
                                            </span>
                                            @if(!$session->payment)
                                                @php
                                                    $internetCost = $session->calculateInternetCost();
                                                    $drinksCost = $session->drinks->sum('price');
                                                @endphp
                                                <br>
                                                <small class="text-muted">
                                                    <i class="bi bi-wifi me-1"></i>إنترنت: ₪{{ number_format($internetCost, 2) }}
                                                    @if($drinksCost > 0)
                                                        | <i class="bi bi-cup-hot me-1"></i>مشروبات: ₪{{ number_format($drinksCost, 2) }}
                                                    @endif
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-success fw-bold">
                                                <i class="bi bi-check-circle me-1"></i>
                                                $0.00
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($refundAmount > 0)
                                            <span class="text-success fw-bold">
                                                <i class="bi bi-arrow-return-left me-1"></i>
                                                ₪{{ number_format($refundAmount, 2) }}
                                            </span>
                                            <br>
                                            <small class="text-muted">يستحق إرجاع</small>
                                        @else
                                            <span class="text-muted">
                                                <i class="bi bi-dash-circle me-1"></i>
                                                $0.00
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">لا توجد جلسات سابقة</p>
                        <form id="createSessionForm" action="{{ route('users.create-session', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="button" onclick="confirmCreateSession()" class="btn btn-primary btn-custom mt-3">
                                <i class="bi bi-plus-circle me-1"></i> إضافة جلسة جديدة
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- فواتير المشروبات -->
        @if($user->user_type == 'subscription')
            <div class="card sessions-card mb-4">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-cup-hot me-2"></i>
                            فواتير المشروبات
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            <div class="badge bg-primary badge-custom">
                                {{ $drinkInvoices->count() }} فاتورة
                            </div>
                            <a href="{{ route('drink-invoices.create', ['user_id' => $user->id]) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle"></i> فاتورة جديدة
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($drinkInvoices && $drinkInvoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>عدد المشروبات</th>
                                    <th>إجمالي المبلغ</th>
                                    <th>حالة الدفع</th>
                                    <th>المتبقي</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($drinkInvoices as $invoice)
                                    <tr>
                                        <td>
                                            <a href="{{ route('drink-invoices.show', $invoice) }}" class="text-decoration-none session-link">
                                                #{{ $invoice->id }}
                                            </a>
                                        </td>
                                        <td>{{ $invoice->items->sum('quantity') }}</td>
                                        <td>₪{{ number_format($invoice->total_price, 2) }}</td>
                                        <td>
                                            @if($invoice->payment_status == 'pending')
                                                <span class="badge bg-warning">قيد الانتظار</span>
                                            @elseif($invoice->payment_status == 'paid')
                                                <span class="badge bg-success">مدفوع</span>
                                            @elseif($invoice->payment_status == 'partial')
                                                <span class="badge bg-info">مدفوع جزئياً</span>
                                            @else
                                                <span class="badge bg-danger">ملغي</span>
                                            @endif
                                        </td>
                                        <td class="{{ $invoice->remaining_amount > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                            ₪{{ number_format($invoice->remaining_amount, 2) }}
                                        </td>
                                        <td>{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('drink-invoices.show', $invoice) }}" class="btn btn-sm btn-primary" title="عرض">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('drink-invoices.edit', $invoice) }}" class="btn btn-sm btn-warning" title="تعديل">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cup-hot display-4 text-muted mb-3"></i>
                            <p class="text-muted">لا توجد فواتير مشروبات لهذا المستخدم</p>
                            <a href="{{ route('drink-invoices.create', ['user_id' => $user->id]) }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> إنشاء فاتورة جديدة
                            </a>
                        </div>
                    @endif
                    @php
                        $hasUnpaidInvoices = $drinkInvoices && $drinkInvoices->whereIn('payment_status', ['pending', 'partial'])->count() > 0;
                    @endphp
                    @if($hasUnpaidInvoices && $drinkInvoices->count() > 0)
                        <div class="alert alert-warning mt-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>تنبيه:</strong> لا يمكن إنشاء فاتورة جديدة. يجب أن تكون جميع الفواتير السابقة مدفوعة بالكامل أولاً.
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- تفاصيل الجلسات المتبقية -->
        @if($sessionsWithRemainingAmount > 0)
            <div class="card sessions-card mb-4">
                <div class="card-header bg-transparent border-0 p-0">
                    <button class="btn btn-link text-decoration-none w-100 text-start p-3 d-flex justify-content-between align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#remainingSessionsCollapse" aria-expanded="false" aria-controls="remainingSessionsCollapse">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                            الجلسات بمبالغ متبقية
                        </h5>
                        <i class="bi bi-chevron-down collapse-icon"></i>
                    </button>
                </div>
                <div id="remainingSessionsCollapse" class="collapse" aria-labelledby="remainingSessionsCollapse">
                    <div class="card-body">
                        <div class="alert alert-warning alert-custom mb-4">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i> تنبيه:</h6>
                            <p class="mb-0">
                                لدى المستخدم <strong>{{ $sessionsWithRemainingAmount }}</strong> جلسة/جلسات بمبالغ متبقية تبلغ إجماليها
                                <strong class="text-danger">₪{{ number_format($totalRemainingAmount, 2) }}</strong>
                            </p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                <tr>
                                    <th>رقم الجلسة</th>
                                    <th>تاريخ الجلسة</th>
                                    <th>المبلغ المستحق</th>
                                    <th>المدفوع</th>
                                    <th>المتبقي</th>
                                    <th>حالة الدفع</th>
                                    <th>الإجراءات</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userSessions as $userSession)
                                    @php
                                        if($userSession->payment) {
                                            // إذا كانت هناك مدفوعة، استخدم القيمة المخزنة في قاعدة البيانات
                                            $paidAmount = $userSession->payment->amount_bank + $userSession->payment->amount_cash;
                                            $remainingAmount = max(0, $userSession->payment->total_price - $paidAmount);
                                            $sessionTotal = $userSession->payment->total_price;
                                        } else {
                                            // إذا لم تكن هناك مدفوعة، احسب التكلفة بنفس طريقة صفحة عرض تفاصيل الجلسة
                                            $internetCost = $userSession->calculateInternetCost();
                                            $drinksCost = $userSession->drinks->sum('price');
                                            $sessionTotal = $internetCost + $drinksCost;
                                            $remainingAmount = $sessionTotal;
                                        }
                                    @endphp
                                    @if($remainingAmount > 0)
                                        <tr class="session-row">
                                            <td>
                                                <a href="{{ route('sessions.show', $userSession) }}" class="text-decoration-none text-primary fw-medium session-link">
                                                    #{{ $userSession->id }}
                                                </a>
                                            </td>
                                            <td>{{ $userSession->start_at->format('Y-m-d H:i') }}</td>
                                            <td class="fw-bold">
                                                @if($userSession->payment)
                                                    ₪{{ number_format($userSession->payment->total_price, 2) }}
                                                @else
                                                    ₪{{ number_format($sessionTotal, 2) }}
                                                @endif
                                            </td>
                                            <td class="text-success">
                                                @if($userSession->payment)
                                                    ₪{{ number_format($userSession->payment->amount_bank + $userSession->payment->amount_cash, 2) }}
                                                @else
                                                    ₪0.00
                                                @endif
                                            </td>
                                            <td class="text-danger fw-bold">₪{{ number_format($remainingAmount, 2) }}</td>
                                            <td>
                                                @if($userSession->payment)
                                                    @if($userSession->payment->payment_status == 'partial')
                                                        <span class="badge bg-warning badge-custom">مدفوع جزئياً</span>
                                                    @elseif($userSession->payment->payment_status == 'pending')
                                                        <span class="badge bg-secondary badge-custom">معلق</span>
                                                    @else
                                                        <span class="badge bg-danger badge-custom">غير مدفوع</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger badge-custom">لا توجد مدفوعة</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($userSession->payment)
                                                    <a href="{{ route('session-payments.show', $userSession->payment->id) }}" class="btn btn-sm btn-outline-primary btn-custom">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if($userSession->session_status == 'completed')
                                                        <a href="{{ route('session-payments.edit', $userSession->payment->id) }}" class="btn btn-sm btn-outline-warning btn-custom">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-muted">لا توجد مدفوعة</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card sessions-card mb-4">
                <div class="card-body text-center py-5">
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <h5 class="text-success mt-3">ممتاز!</h5>
                    <p class="text-muted">جميع مدفوعات المستخدم مكتملة ولا توجد مبالغ متبقية.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- زر الإجراءات السريعة -->
<!-- <button class="floating-action-btn" data-bs-toggle="modal" data-bs-target="#chargeWalletModal" title="شحن المحفظة">
    <i class="bi bi-plus-lg"></i>
</button>
-->
<br><br>
<!-- Modal شحن المحفظة -->
<div class="modal fade modal-custom" id="chargeWalletModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-wallet2 me-2"></i>
                    شحن محفظة {{ $user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.charge-wallet', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">الرصيد الحالي</label>
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white">
                                <i class="bi bi-wallet2"></i>
                            </span>
                            <input type="text" class="form-control fw-bold text-success"
                                   value="₪{{ number_format($user->wallet->balance ?? 0, 2) }}" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="form-label fw-bold">مبلغ الشحن</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-currency-dollar"></i>
                            </span>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount"
                                   placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="form-label fw-bold">طريقة الدفع</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">اختر طريقة الدفع</option>
                            <option value="cash">💵 كاش</option>
                            <option value="bank_transfer">🏦 حوالة بنكية</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-bold">ملاحظات <small class="text-muted">(اختياري)</small></label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                                  placeholder="أضف ملاحظة حول هذه العملية..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-custom" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> إلغاء
                    </button>
                    <button type="submit" class="btn btn-success btn-custom">
                        <i class="bi bi-check-circle me-1"></i> شحن المحفظة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCreateSession() {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'هل تريد فتح جلسة جديدة لهذا المستخدم؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، افتح الجلسة',
                cancelButtonText: 'إلغاء',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createSessionForm').submit();
                }
            });
        }

        function showInvoiceAlert() {
            @if($hasUnpaidInvoices && $unpaidInvoicesList->count() > 0)
            const unpaidInvoices = [
                    @foreach($unpaidInvoicesList as $invoice)
                {
                    id: {{ $invoice->id }},
                    status: '{{ $invoice->payment_status == "pending" ? "قيد الانتظار" : "مدفوع جزئياً" }}',
                    total: {{ $invoice->total_price }},
                    remaining: {{ $invoice->remaining_amount }},
                    url: '{{ route("drink-invoices.show", $invoice) }}'
                }@if(!$loop->last),@endif
                @endforeach
            ];

            let invoiceList = '<div class="text-start mt-3"><strong>الفواتير غير المدفوعة:</strong><ul class="mt-2 mb-0">';
            unpaidInvoices.forEach(function(invoice) {
                invoiceList += `<li class="mb-2">
            <a href="${invoice.url}" target="_blank" class="text-decoration-none">
                فاتورة #${invoice.id}
            </a> -
            <span class="badge ${invoice.status === 'قيد الانتظار' ? 'bg-warning' : 'bg-info'}">${invoice.status}</span> -
            المتبقي: <strong>₪${parseFloat(invoice.remaining).toFixed(2)}</strong>
        </li>`;
            });
            invoiceList += '</ul></div>';

            Swal.fire({
                title: 'لا يمكن إنشاء فاتورة جديدة',
                html: `
            <div class="text-start">
                <p class="mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    يجب أن تكون جميع الفواتير السابقة مدفوعة بالكامل قبل إنشاء فاتورة جديدة.
                </p>
                ${invoiceList}
            </div>
        `,
                icon: 'warning',
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#3085d6',
                width: '600px'
            });
            @endif
        }

        // التأكد من عمل collapse للجلسات المتبقية
        document.addEventListener('DOMContentLoaded', function() {
            const collapseElement = document.getElementById('remainingSessionsCollapse');
            const collapseButton = document.querySelector('[data-bs-target="#remainingSessionsCollapse"]');

            if (collapseElement && collapseButton) {
                // تحديث حالة الأيقونة عند الفتح
                collapseElement.addEventListener('show.bs.collapse', function () {
                    collapseButton.classList.remove('collapsed');
                    collapseButton.setAttribute('aria-expanded', 'true');
                });

                // تحديث حالة الأيقونة عند الإغلاق
                collapseElement.addEventListener('hide.bs.collapse', function () {
                    collapseButton.classList.add('collapsed');
                    collapseButton.setAttribute('aria-expanded', 'false');
                });
            }
        });
    </script>
@endpush
