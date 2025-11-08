@extends('layouts.app')

@section('title', 'إدارة مدفوعات الجلسات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إدارة مدفوعات الجلسات</h1>
    <div>
        <a href="{{ route('session-payments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة مدفوعة جديدة
        </a>
    </div>
</div>

<!-- إحصائيات المدفوعات -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_payments'] }}</h4>
                        <p class="card-text">إجمالي المدفوعات</p>
                    </div>
                    <div>
                        <i class="bi bi-credit-card fs-1"></i>
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
                        <h4>{{ $stats['pending_payments'] }}</h4>
                        <p class="card-text">قيد الانتظار</p>
                    </div>
                    <div>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['paid_payments'] }}</h4>
                        <p class="card-text">مدفوعة بالكامل</p>
                    </div>
                    <div>
                        <i class="bi bi-check-circle fs-1"></i>
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
                        <h4>₪{{ number_format($stats['total_revenue'], 2) }}</h4>
                        <p class="card-text">إجمالي الإيرادات</p>
                    </div>
                    <div>
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات إضافية -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>₪{{ number_format($stats['total_refunds'] ?? 0, 2) }}</h4>
                        <p class="card-text">إجمالي المبالغ المرتجعة</p>
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
                        <h4>{{ $stats['refund_sessions'] ?? 0 }}</h4>
                        <p class="card-text">جلسات تحتاج إرجاع</p>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>₪{{ number_format($stats['total_remaining'] ?? 0, 2) }}</h4>
                        <p class="card-text">إجمالي المبالغ المتبقية</p>
                    </div>
                    <div>
                        <i class="bi bi-arrow-up-circle fs-1"></i>
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
                        <h4>{{ $stats['partial_payments'] ?? 0 }}</h4>
                        <p class="card-text">مدفوعات جزئية</p>
                    </div>
                    <div>
                        <i class="bi bi-percent fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- البحث والفلترة -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('session-payments.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">البحث</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="رقم المدفوعة، رقم الجلسة، أو اسم المستخدم">
            </div>
            <div class="col-md-3">
                <label for="payment_status" class="form-label">حالة الدفع</label>
                <select class="form-select" id="payment_status" name="payment_status">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>مدفوعة</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                    <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>ملغية</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="per_page" class="form-label">عدد النتائج</label>
                <select class="form-select" id="per_page" name="per_page">
                    <option value="15" {{ request('per_page') == '15' ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="bi bi-search"></i> بحث
                </button>
                <a href="{{ route('session-payments.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i> إعادة تعيين
                </a>
            </div>
        </form>
    </div>
</div>

<!-- جدول المدفوعات -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة مدفوعات الجلسات</h5>
    </div>
    <div class="card-body">
        @if($payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>رقم المدفوعة</th>
                        <th>رقم الجلسة</th>
                        <th>المستخدم</th>

                        <th>السعر الإجمالي</th>
                        <th>مدفوع بنكي</th>
                        <th>مدفوع كاش</th>
                        <th>المبلغ المتبقي</th>
                        <th>المبلغ المرتجع</th>
                        <th>حالة الدفع</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td><strong>#{{ $payment->id }}</strong></td>
                        <td>
                            @if($payment->session)
                                @if($payment->session->trashed())
                                    <span class="text-muted">
                                        #{{ $payment->session->id }} 
                                        <small class="badge bg-secondary">محذوفة</small>
                                    </span>
                                @else
                                    <a href="{{ route('sessions.show', $payment->session->id) }}" class="text-decoration-none">
                                        #{{ $payment->session->id }}
                                    </a>
                                @endif
                            @else
                                <span class="text-muted">جلسة غير موجودة</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->session && $payment->session->user)
                                <a href="{{ route('users.show', $payment->session->user) }}" class="text-decoration-none">
                                    <span class="text-primary fw-bold">{{ $payment->session->user->name }}</span>
                                    <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                                </a>
                            @else
                                <span class="text-muted">غير محدد</span>
                            @endif
                        </td>
                        
                        <td><strong class="text-primary">₪{{ number_format($payment->total_price, 2) }}</strong></td>
                        <td>
                            @if($payment->amount_bank > 0)
                                <span class="text-info">₪{{ number_format($payment->amount_bank, 2) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->amount_cash > 0)
                                <span class="text-success">₪{{ number_format($payment->amount_cash, 2) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->remaining_amount > 0)
                                <span class="text-danger">₪{{ number_format($payment->remaining_amount, 2) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $totalPaid = $payment->amount_bank + $payment->amount_cash;
                                $refundAmount = $totalPaid - $payment->total_price;
                            @endphp
                            @if($refundAmount > 0)
                                <span class="text-success fw-bold">
                                    <i class="bi bi-arrow-down-circle"></i>
                                    ₪{{ number_format($refundAmount, 2) }}
                                    <small class="d-block text-muted">يجب إرجاعه</small>
                                </span>
                            @elseif($refundAmount < 0)
                                <span class="text-danger fw-bold">
                                    <i class="bi bi-arrow-up-circle"></i>
                                    ₪{{ number_format(abs($refundAmount), 2) }}
                                    <small class="d-block text-muted">متبقي للدفع</small>
                                </span>
                            @else
                                <span class="text-muted">
                                    <i class="bi bi-check-circle"></i>
                                    <small>لا يوجد</small>
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($payment->payment_status == 'pending')
                                <span class="badge bg-warning">قيد الانتظار</span>
                            @elseif($payment->payment_status == 'paid')
                                <span class="badge bg-success">مدفوعة</span>
                            @elseif($payment->payment_status == 'partial')
                                <span class="badge bg-info">مدفوعة جزئياً</span>
                            @else
                                <span class="badge bg-danger">ملغية</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <strong>{{ $payment->created_at->format('Y-m-d') }}</strong><br>
                                <span class="text-muted">{{ $payment->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('session-payments.show', $payment) }}" class="btn btn-sm btn-outline-primary" title="عرض التفاصيل">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('session-payments.edit', $payment) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('session-payments.invoice', $payment) }}" class="btn btn-sm btn-outline-danger" title="تصدير PDF">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                                <a href="{{ route('session-payments.invoice.show', $payment) }}" target="_blank" class="btn btn-sm btn-outline-info" title="عرض للطباعة">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <form action="{{ route('session-payments.destroy', $payment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('هل تريد حذف هذه المدفوعة؟')" title="حذف">
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
            {{ $payments->links() }}
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-credit-card display-1 text-muted"></i>
            <h5 class="mt-3">لا توجد مدفوعات</h5>
            <p class="text-muted">ابدأ بإضافة مدفوعة جديدة</p>
            <a href="{{ route('session-payments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> إضافة مدفوعة جديدة
            </a>
        </div>
        @endif
    </div>
</div>

@endsection