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
        @if($transactions->total() > 0)
        <button class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteAllTransactionsModal">
            <i class="bi bi-trash"></i> حذف جميع الحركات
        </button>
        @endif
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
                        <h3 class="text-success">₪{{ number_format($wallet->balance ?? 0, 2) }}</h3>
                        <p class="text-muted mb-0">الرصيد الحالي</p>
                    </div>
                    <div class="col-6">
                        <h4 class="text-info">{{ $transactions->total() }}</h4>
                        <p class="text-muted mb-0">إجمالي المعاملات</p>
                    </div>
                </div>
                @if(($wallet->debt ?? 0) > 0)
                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12">
                        <h4 class="text-danger mb-0">
                            <i class="bi bi-exclamation-triangle"></i>
                            ₪{{ number_format($wallet->debt, 2) }}
                        </h4>
                        <p class="text-muted mb-0">الدين المستحق</p>
                    </div>
                </div>
                @endif
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

<!-- أزرار شحن وخصم سريع -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-0">
                            <i class="bi bi-plus-circle text-success"></i>
                            شحن سريع للمحفظة
                        </h6>
                        <small class="text-muted">اشحن المحفظة مباشرة من هذه الصفحة</small>
                        @if(($wallet->debt ?? 0) > 0)
                        <br><small class="text-warning">
                            <i class="bi bi-info-circle"></i>
                            سيتم خصم الدين تلقائياً
                        </small>
                        @endif
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
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-0">
                            <i class="bi bi-dash-circle text-danger"></i>
                            خصم من المحفظة
                        </h6>
                        <small class="text-muted">خصم مبلغ من المحفظة مباشرة</small>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#quickDeductModal">
                            <i class="bi bi-wallet2"></i> خصم من المحفظة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-0">
                            <i class="bi bi-credit-card text-warning"></i>
                            تسجيل دين
                        </h6>
                        <small class="text-muted">سجل دين على المستخدم</small>
                        @if(($wallet->debt ?? 0) > 0)
                        <br><small class="text-danger">
                            <strong>الدين الحالي: ₪{{ number_format($wallet->debt, 2) }}</strong>
                        </small>
                        @endif
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addDebtModal">
                            <i class="bi bi-credit-card"></i> تسجيل دين
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
                        <th width="100">إجراءات</th>
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
                            @elseif($transaction->type == 'debt')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-credit-card"></i> دين
                                </span>
                            @else
                                <span class="badge bg-info">
                                    <i class="bi bi-arrow-repeat"></i> استرداد
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($transaction->type == 'debt')
                                <span class="badge bg-warning text-dark">
                                    💳 دين
                                </span>
                            @elseif($transaction->type == 'deduct')
                                <span class="badge bg-secondary">
                                    ✋ يدوي
                                </span>
                            @elseif($transaction->payment_method == 'cash')
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
                            <strong class="{{ $transaction->type == 'charge' ? 'text-success' : ($transaction->type == 'debt' ? 'text-warning' : 'text-danger') }}">
                                {{ $transaction->type == 'charge' ? '+' : '-' }}₪{{ number_format($transaction->amount, 2) }}
                            </strong>
                        </td>
                        <td class="text-muted">₪{{ number_format($transaction->balance_before, 2) }}</td>
                        <td class="text-success"><strong>₪{{ number_format($transaction->balance_after, 2) }}</strong></td>
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
                        <td>
                            <button class="btn btn-sm btn-outline-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editTransactionModal{{ $transaction->id }}"
                                    title="تعديل المعاملة">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modals للتعديل - لكل معاملة -->
        @foreach($transactions as $transaction)
        <div class="modal fade" id="editTransactionModal{{ $transaction->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil"></i>
                            تعديل معاملة مالية
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('users.wallet-transactions.update', [$user, $transaction]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="transaction_date{{ $transaction->id }}" class="form-label">التاريخ</label>
                                    <input type="date" class="form-control" 
                                           id="transaction_date{{ $transaction->id }}" 
                                           name="transaction_date" 
                                           value="{{ $transaction->created_at->format('Y-m-d') }}" 
                                           required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="transaction_time{{ $transaction->id }}" class="form-label">الوقت</label>
                                    <input type="time" class="form-control" 
                                           id="transaction_time{{ $transaction->id }}" 
                                           name="transaction_time" 
                                           value="{{ $transaction->created_at->format('H:i') }}" 
                                           required>
                                </div>
                            </div>
                            
                            @if($transaction->type == 'debt')
                            <div class="mb-3">
                                <label for="amount{{ $transaction->id }}" class="form-label">مبلغ الدين</label>
                                <input type="number" step="0.01" class="form-control" 
                                       id="amount{{ $transaction->id }}" 
                                       name="amount" 
                                       value="{{ $transaction->amount }}" 
                                       required min="0.01">
                                <small class="text-muted">يمكنك تعديل مبلغ الدين من هنا</small>
                            </div>
                            @endif

                            @if($transaction->type == 'deduct')
                            <div class="mb-3">
                                <label for="amount{{ $transaction->id }}" class="form-label">المبلغ المخصوم</label>
                                <input type="number" step="0.01" class="form-control" 
                                       id="amount{{ $transaction->id }}" 
                                       name="amount" 
                                       value="{{ $transaction->amount }}" 
                                       required min="0.01">
                                <small class="text-muted">
                                    الرصيد الحالي: ₪{{ number_format($wallet->balance ?? 0, 2) }}<br>
                                    @if($transaction->amount > ($wallet->balance ?? 0))
                                    <span class="text-warning">ملاحظة: إذا زدت المبلغ، سيتم التحقق من كفاية الرصيد</span>
                                    @endif
                                </small>
                            </div>
                            @endif

                            <div class="mb-3">
                                <label for="payment_method{{ $transaction->id }}" class="form-label">طريقة الدفع</label>
                                <select class="form-select" 
                                        id="payment_method{{ $transaction->id }}" 
                                        name="payment_method" 
                                        required>
                                    <option value="cash" {{ $transaction->payment_method == 'cash' ? 'selected' : '' }}>
                                        💵 كاش
                                    </option>
                                    <option value="bank_transfer" {{ $transaction->payment_method == 'bank_transfer' ? 'selected' : '' }}>
                                        🏦 حوالة بنكية
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="notes{{ $transaction->id }}" class="form-label">ملاحظات <small class="text-muted">(اختياري)</small></label>
                                <textarea class="form-control" 
                                          id="notes{{ $transaction->id }}" 
                                          name="notes" 
                                          rows="3" 
                                          placeholder="أضف أو عدل ملاحظة حول هذه المعاملة...">{{ $transaction->notes }}</textarea>
                            </div>

                            <div class="alert alert-info">
                                <strong>معلومات المعاملة:</strong><br>
                                <small>
                                    النوع: 
                                    @if($transaction->type == 'charge')
                                        <span class="badge bg-success">شحن</span>
                                    @elseif($transaction->type == 'deduct')
                                        <span class="badge bg-danger">خصم</span>
                                    @elseif($transaction->type == 'debt')
                                        <span class="badge bg-warning text-dark">دين</span>
                                    @else
                                        <span class="badge bg-info">استرداد</span>
                                    @endif
                                    | المبلغ: ₪{{ number_format($transaction->amount, 2) }}<br>
                                    المرجع: {{ $transaction->reference }}
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

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
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#quickChargeModal">
                    <i class="bi bi-wallet"></i> ابدأ بشحن المحفظة
                </button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#quickDeductModal">
                    <i class="bi bi-wallet2"></i> خصم من المحفظة
                </button>
            </div>
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
                        <div class="form-control-plaintext fw-bold text-success" style="font-size: 1.1rem;">
                            ₪{{ number_format($wallet->balance ?? 0, 2) }}
                        </div>
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

<!-- Modal خصم سريع -->
<div class="modal fade" id="quickDeductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-dash-circle"></i>
                    خصم من محفظة {{ $user->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.deduct-wallet', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الرصيد الحالي</label>
                        <div class="form-control-plaintext fw-bold text-success" style="font-size: 1.1rem;">
                            ₪{{ number_format($wallet->balance ?? 0, 2) }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deduct_amount" class="form-label">المبلغ المراد خصمه</label>
                        <input type="number" step="0.01" class="form-control" id="deduct_amount" name="amount" 
                               placeholder="0.00" required min="0.01">
                        <small class="text-muted">الحد الأقصى للخصم: ₪{{ number_format($wallet->balance ?? 0, 2) }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="deduct_notes" class="form-label">ملاحظات <small class="text-muted">(اختياري)</small></label>
                        <textarea class="form-control" id="deduct_notes" name="notes" rows="3" 
                                  placeholder="أضف ملاحظة حول عملية الخصم..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">خصم من المحفظة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal تسجيل دين -->
<div class="modal fade" id="addDebtModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-credit-card"></i>
                    تسجيل دين على {{ $user->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.add-debt', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if(($wallet->debt ?? 0) > 0)
                    <div class="alert alert-warning">
                        <strong>الدين الحالي:</strong> ₪{{ number_format($wallet->debt, 2) }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="debt_amount" class="form-label">مبلغ الدين</label>
                        <input type="number" step="0.01" class="form-control" id="debt_amount" name="debt_amount" 
                               placeholder="0.00" required min="0.01">
                        @if(($wallet->debt ?? 0) > 0)
                        <small class="text-muted">
                            بعد التسجيل سيصبح إجمالي الدين: ₪<span id="total_debt_preview">{{ number_format($wallet->debt, 2) }}</span>
                        </small>
                        @else
                        <small class="text-muted">
                            إجمالي الدين بعد التسجيل: ₪<span id="total_debt_preview">0.00</span>
                        </small>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="debt_notes" class="form-label">ملاحظات <small class="text-muted">(اختياري)</small></label>
                        <textarea class="form-control" id="debt_notes" name="notes" rows="3" 
                                  placeholder="أضف ملاحظة حول هذا الدين..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            <i class="bi bi-info-circle"></i>
                            عند شحن المحفظة، سيتم خصم الدين تلقائياً من المبلغ المشحون.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning">تسجيل الدين</button>
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

    // حساب إجمالي الدين عند إدخال المبلغ
    const debtAmountInput = document.getElementById('debt_amount');
    const totalDebtPreview = document.getElementById('total_debt_preview');
    
    if (debtAmountInput && totalDebtPreview) {
        const currentDebt = {{ $wallet->debt ?? 0 }};
        
        debtAmountInput.addEventListener('input', function() {
            const newDebt = parseFloat(this.value) || 0;
            const total = currentDebt + newDebt;
            totalDebtPreview.textContent = total.toFixed(2);
        });
    }
});
</script>

<!-- Modal حذف جميع الحركات -->
<div class="modal fade" id="deleteAllTransactionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i>
                    تأكيد حذف جميع الحركات المالية
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.wallet-transactions.delete-all', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h6><i class="bi bi-exclamation-triangle me-2"></i>تحذير!</h6>
                        <p class="mb-0">
                            أنت على وشك حذف <strong>جميع الحركات المالية</strong> لهذا المستخدم.
                        </p>
                    </div>
                    <div class="mb-3">
                        <p><strong>عدد الحركات المالية:</strong> {{ number_format($transactions->total()) }} حركة</p>
                        <p><strong>المستخدم:</strong> {{ $user->name }}</p>
                        <p class="text-danger"><strong>هذا الإجراء لا يمكن التراجع عنه!</strong></p>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label" for="confirmDelete">
                            أنا أؤكد أنني أريد حذف جميع الحركات المالية
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger" id="deleteAllBtn" disabled>
                        <i class="bi bi-trash"></i> حذف جميع الحركات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmCheckbox = document.getElementById('confirmDelete');
    const deleteBtn = document.getElementById('deleteAllBtn');
    
    if (confirmCheckbox && deleteBtn) {
        confirmCheckbox.addEventListener('change', function() {
            deleteBtn.disabled = !this.checked;
        });
    }
});
</script>
@endsection