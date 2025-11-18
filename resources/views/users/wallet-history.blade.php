@extends('layouts.app')

@section('title', 'تاريخ محفظة ' . $user->name)

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
    <h1 class="h2">
        <i class="bi bi-wallet"></i>
        تاريخ محفظة {{ $user->name }}
    </h1>
    <div>
        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary me-2">
            <i class="bi bi-person"></i> ملف المستخدم
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right"></i> العودة
        </a>
    </div>
</div>

<!-- معلومات المحفظة الحالية -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-wallet2"></i>
                    معلومات المحفظة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h3 class="text-success">${{ number_format($wallet->balance ?? 0, 2) }}</h3>
                        <p class="text-muted mb-0">الرصيد الحالي</p>
                    </div>
                    <div class="col-6">
                        <h4 class="text-info">{{ $transactions->total() }}</h4>
                        <p class="text-muted mb-0">إجمالي المعاملات</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person"></i>
                    معلومات المستخدم
                </h5>
            </div>
            <div class="card-body">
                <p><strong>الاسم:</strong> {{ $user->name }}</p>
                <p><strong>النوع:</strong> 
                    @php
                        $typeInfo = $userTypeBadges[$user->user_type] ?? ['label' => 'غير معروف', 'class' => 'bg-secondary'];
                    @endphp
                    <span class="badge {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
                </p>
                <p><strong>الحالة:</strong>
                    @if($user->status == 'active')
                        <span class="badge bg-success">نشط</span>
                    @elseif($user->status == 'inactive')
                        <span class="badge bg-secondary">غير نشط</span>
                    @else
                        <span class="badge bg-danger">معلق</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- زر شحن سريع -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-0">
                            <i class="bi bi-plus-circle text-success"></i>
                            شحن سريع للمحفظة
                        </h6>
                        <small class="text-muted">اشحن المحفظة مباشرة من هذه الصفحة</small>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#quickChargeModal">
                            <i class="bi bi-wallet"></i> شحن المحفظة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- تاريخ المعاملات -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-clock-history"></i>
            تاريخ المعاملات المالية
        </h5>
    </div>
    <div class="card-body">
        @if($transactions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="120">التاريخ</th>
                        <th width="80">النوع</th>
                        <th width="110">طريقة الدفع</th>
                        <th width="100">المبلغ</th>
                        <th width="120">الرصيد قبل</th>
                        <th width="120">الرصيد بعد</th>
                        <th>الملاحظات</th>
                        <th width="150">المرجع</th>
                        <th width="120">المدير</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>
                            <div class="small">
                                <strong>{{ $transaction->created_at->format('Y-m-d') }}</strong><br>
                                <span class="text-muted">{{ $transaction->created_at->format('H:i:s') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($transaction->type == 'charge')
                                <span class="badge bg-success">
                                    <i class="bi bi-arrow-up"></i> شحن
                                </span>
                            @elseif($transaction->type == 'deduct')
                                <span class="badge bg-danger">
                                    <i class="bi bi-arrow-down"></i> خصم
                                </span>
                            @else
                                <span class="badge bg-info">
                                    <i class="bi bi-arrow-repeat"></i> استرداد
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($transaction->payment_method == 'cash')
                                <span class="badge bg-warning text-dark">
                                    💵 كاش
                                </span>
                            @elseif($transaction->payment_method == 'bank_transfer')
                                <span class="badge bg-primary">
                                    🏦 بنكي
                                </span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            <strong class="{{ $transaction->type == 'charge' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'charge' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                            </strong>
                        </td>
                        <td class="text-muted">${{ number_format($transaction->balance_before, 2) }}</td>
                        <td class="text-success"><strong>${{ number_format($transaction->balance_after, 2) }}</strong></td>
                        <td>
                            @if($transaction->notes)
                                <span class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" 
                                      title="{{ $transaction->notes }}">
                                    <i class="bi bi-chat-text"></i>
                                    {{ Str::limit($transaction->notes, 30) }}
                                </span>
                            @else
                                <span class="text-muted">لا توجد ملاحظات</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $transaction->reference }}</td>
                        <td class="text-muted small">{{ $transaction->admin_name ?? 'غير محدد' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- معلومات النتائج والـ Pagination -->
        <div class="row align-items-center mt-4">
            <div class="col-md-6">
                <div class="text-muted">
                    @if($transactions->total() > 0)
                        عرض {{ $transactions->firstItem() }} إلى {{ $transactions->lastItem() }} 
                        من أصل {{ number_format($transactions->total()) }} معاملة
                    @endif
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-clock-history display-1 text-muted"></i>
            <h5 class="mt-3">لا توجد معاملات مالية</h5>
            <p class="text-muted">لم يتم تسجيل أي معاملات مالية لهذا المستخدم بعد</p>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#quickChargeModal">
                <i class="bi bi-wallet"></i> ابدأ بشحن المحفظة
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Modal شحن سريع -->
<div class="modal fade" id="quickChargeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">شحن محفظة {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.charge-wallet', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الرصيد الحالي</label>
                        <input type="text" class="form-control" value="${{ number_format($wallet->balance ?? 0, 2) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">مبلغ الشحن</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">طريقة الدفع</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">اختر طريقة الدفع</option>
                            <option value="cash">💵 كاش</option>
                            <option value="bank_transfer">🏦 حوالة بنكية</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظات <small class="text-muted">(اختياري)</small></label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="أضف ملاحظة حول هذه العملية..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success">شحن المحفظة</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تفعيل tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection