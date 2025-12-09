@extends('layouts.app')

@section('title', 'تفاصيل فاتورة المشروبات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">فاتورة المشروبات #{{ $drinkInvoice->id }}</h1>
    <div>
        <a href="{{ route('drink-invoices.invoice', $drinkInvoice) }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> تصدير PDF
        </a>
        <a href="{{ route('drink-invoices.invoice.show', $drinkInvoice) }}" target="_blank" class="btn btn-info">
            <i class="bi bi-printer"></i> عرض للطباعة
        </a>
        <a href="{{ route('drink-invoices.edit', $drinkInvoice) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> انهاء الفاتورة ودفع
        </a>
        <a href="{{ route('drink-invoices.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

@if($drinkInvoice->payment_status == 'paid')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-left: 6px solid #155724; box-shadow: 0 4px 10px rgba(0,0,0,0.2); padding: 16px 32px; border-radius: 8px;">
            <i class="bi bi-shield-check text-white me-3" style="font-size: 1.5rem;"></i>
            <span class="text-white fw-bold" style="font-size: 1.25rem;">✓ هذه الفاتورة مدفوعة بالكامل</span>
        </div>
    </div>
</div>
@endif

<div class="row">
    <!-- معلومات الفاتورة -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات الفاتورة</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6"><strong>رقم الفاتورة:</strong></div>
                    <div class="col-sm-6">#{{ $drinkInvoice->id }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>المستخدم:</strong></div>
                    <div class="col-sm-6">
                        <a href="{{ route('users.show', $drinkInvoice->user) }}" class="text-decoration-none">
                            <span class="text-primary fw-bold">{{ $drinkInvoice->user->name }}</span>
                            <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>تاريخ الإنشاء:</strong></div>
                    <div class="col-sm-6">{{ $drinkInvoice->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>حالة الفاتورة المالية:</strong></div>
                    <div class="col-sm-6">
                        @if($drinkInvoice->payment_status == 'pending')
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded" style="background-color: #fff3cd; border: 2px solid #ffc107;">
                                <i class="bi bi-clock-history text-warning" style="font-size: 1.2rem;"></i>
                                <span class="fw-bold text-dark">قيد الانتظار</span>
                            </div>
                        @elseif($drinkInvoice->payment_status == 'paid')
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded" style="background-color: #d1e7dd; border: 2px solid #198754;">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 1.2rem;"></i>
                                <span class="fw-bold text-dark">مدفوع بالكامل</span>
                            </div>
                        @elseif($drinkInvoice->payment_status == 'partial')
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded" style="background-color: #cff4fc; border: 2px solid #0dcaf0;">
                                <i class="bi bi-pause-circle-fill text-info" style="font-size: 1.2rem;"></i>
                                <span class="fw-bold text-dark">مدفوع جزئياً</span>
                                <small class="text-muted">(متبقي: ₪{{ number_format($drinkInvoice->remaining_amount, 2) }})</small>
                            </div>
                        @else
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded" style="background-color: #f8d7da; border: 2px solid #dc3545;">
                                <i class="bi bi-x-circle-fill text-danger" style="font-size: 1.2rem;"></i>
                                <span class="fw-bold text-dark">ملغي</span>
                            </div>
                        @endif
                    </div>
                </div>
                @if($drinkInvoice->note)
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>ملاحظات:</strong></div>
                    <div class="col-sm-6">{{ $drinkInvoice->note }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- معلومات الدفع -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات الدفع</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6"><strong>إجمالي المبلغ:</strong></div>
                    <div class="col-sm-6">
                        <span class="fw-bold text-primary total-cost-display">₪{{ number_format($drinkInvoice->total_price, 2) }}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>مدفوع بنك:</strong></div>
                    <div class="col-sm-6">₪{{ number_format($drinkInvoice->amount_bank, 2) }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>مدفوع نقد:</strong></div>
                    <div class="col-sm-6">₪{{ number_format($drinkInvoice->amount_cash, 2) }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>المتبقي:</strong></div>
                    <div class="col-sm-6 remaining-amount-display {{ $drinkInvoice->remaining_amount > 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">₪{{ number_format($drinkInvoice->remaining_amount, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- المشروبات -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">المشروبات المطلوبة</h5>
                @if($drinkInvoice->payment_status != 'paid')
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDrinkModal">
                    <i class="bi bi-plus-circle"></i> إضافة مشروب للفاتورة
                </button>
                @else
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small me-2">
                        <i class="bi bi-info-circle"></i> لا يمكن إضافة مشروبات للفاتورة المدفوعة بالكامل
                    </span>
                    <a href="{{ route('drink-invoices.create') }}?user_id={{ $drinkInvoice->user_id }}" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-plus"></i>فتح فاتورة جديدة 
                    </a>
                   
                </div>
                @endif
            </div>
            <div class="card-body">
                @if($drinkInvoice->payment_status == 'paid')
                <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>
                        <strong>تنبيه:</strong> لا يمكن إضافة مشروبات لأن الفاتورة مدفوعة بالكامل.
                        يمكنك <a href="{{ route('drink-invoices.create') }}?user_id={{ $drinkInvoice->user_id }}" class="alert-link">فتح فاتورة جديدة</a>
                        أو <a href="{{ route('drink-invoices.edit', $drinkInvoice) }}" class="alert-link">تغيير حالة الفاتورة</a> إلى غير مدفوعة بالكامل.
                    </div>
                </div>
                @endif
                @if($drinkInvoice->items && $drinkInvoice->items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>المشروب</th>
                                <th>الكمية</th>
                                <th>سعر الواحد</th>
                                <th>السعر الإجمالي</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>وقت الطلب</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drinkInvoice->items->sortBy('created_at') as $item)
                            <tr>
                                <td>{{ $item->drink->name ?? 'غير محدد' }}</td>
                                <td>{{ $item->quantity ?? 1 }}</td>
                                <td>
                                    ₪{{ number_format($item->unit_price ?? $item->drink->price ?? 0, 2) }}
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#editDrinkPriceModal{{ $item->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </td>
                                <td>₪{{ number_format($item->price, 2) }}</td>
                                <td>
                                    @if($item->status == 'ordered')
                                        <span class="badge bg-warning">مطلوب</span>
                                    @elseif($item->status == 'served')
                                        <span class="badge bg-success">تم التقديم</span>
                                    @else
                                        <span class="badge bg-danger">ملغي</span>
                                    @endif
                                </td>
                                <td>{{ $item->note ?: '-' }}</td>
                                <td>
                                    {{ $item->created_at->format('Y-m-d H:i') }}
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#editDrinkDateModal{{ $item->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </td>
                                <td>
                                    <form action="{{ route('drink-invoices.remove-drink', ['drinkInvoice' => $drinkInvoice, 'item' => $item]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل تريد حذف هذا المشروب من الفاتورة؟')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="table-info">
                                <td><strong>إجمالي المشروبات:</strong></td>
                                <td><strong>{{ $drinkInvoice->items->sum('quantity') }}</strong></td>
                                <td></td>
                                <td><strong>₪{{ number_format($drinkInvoice->items->sum('price'), 2) }}</strong></td>
                                <td colspan="4"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">لم يتم طلب أي مشروبات بعد</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة مشروب -->
<div class="modal fade" id="addDrinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مشروب للفاتورة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('drink-invoices.add-drink', $drinkInvoice) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if($drinkInvoice->payment_status == 'paid')
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>تنبيه:</strong> لا يمكن إضافة مشروبات للفاتورة المدفوعة بالكامل.
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="drink_id" class="form-label">المشروب</label>
                        <select class="form-select" id="drink_id" name="drink_id" {{ $drinkInvoice->payment_status == 'paid' ? 'disabled' : 'required' }}>
                            <option value="">اختر المشروب</option>
                            @foreach($drinks as $drink)
                            <option value="{{ $drink->id }}" data-price="{{ $drink->price }}">
                                {{ $drink->name }} - ₪{{ number_format($drink->price, 2) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">عدد المشروبات</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               min="1" value="1" {{ $drinkInvoice->payment_status == 'paid' ? 'disabled' : 'required' }}>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر الإجمالي</label>
                        <div class="form-control-plaintext" id="total_price_display">₪0.00</div>
                    </div>
                    <div class="mb-3">
                        <label for="drink_date" class="form-label">تاريخ إضافة المشروب</label>
                        <input type="datetime-local" class="form-control" id="drink_date" name="created_at"
                               value="{{ date('Y-m-d\TH:i') }}" {{ $drinkInvoice->payment_status == 'paid' ? 'disabled' : 'required' }}>
                    </div>
                    <div class="mb-3">
                        <label for="drink_note" class="form-label">ملاحظات</label>
                        <input type="text" class="form-control" id="drink_note" name="note"
                               placeholder="ملاحظات إضافية (اختياري)" {{ $drinkInvoice->payment_status == 'paid' ? 'disabled' : '' }}>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary" {{ $drinkInvoice->payment_status == 'paid' ? 'disabled' : '' }}>إضافة المشروب</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal تعديل تاريخ ووقت المشروب -->
@foreach($drinkInvoice->items as $item)
<div class="modal fade" id="editDrinkDateModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل تاريخ ووقت المشروب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('drink-invoices.update-drink-date', ['drinkInvoice' => $drinkInvoice, 'item' => $item]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">المشروب:</label>
                        <div class="form-control-plaintext">{{ $item->drink->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="drink_date_{{ $item->id }}" class="form-label">تاريخ ووقت الطلب</label>
                        <input type="datetime-local" class="form-control" id="drink_date_{{ $item->id }}"
                               name="created_at"
                               value="{{ $item->created_at->format('Y-m-d\TH:i') }}" required>
                        <div class="form-text">اختر التاريخ والوقت الجديد لطلب المشروب</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">التاريخ والوقت الحالي:</label>
                        <div class="form-control-plaintext">{{ $item->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal تعديل سعر الواحدة والكمية -->
@foreach($drinkInvoice->items as $item)
<div class="modal fade" id="editDrinkPriceModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل السعر والكمية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('drink-invoices.update-drink-price', ['drinkInvoice' => $drinkInvoice, 'item' => $item]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">المشروب:</label>
                        <div class="form-control-plaintext">{{ $item->drink->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity_{{ $item->id }}" class="form-label">الكمية</label>
                        <input type="number" step="1" min="1" class="form-control" id="quantity_{{ $item->id }}"
                               name="quantity"
                               value="{{ $item->quantity ?? 1 }}" required>
                        <div class="form-text">الكمية الحالية: {{ $item->quantity ?? 1 }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="unit_price_{{ $item->id }}" class="form-label">سعر الواحدة (₪)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="unit_price_{{ $item->id }}"
                               name="unit_price"
                               value="{{ $item->unit_price ?? $item->drink->price ?? 0 }}" required>
                        <div class="form-text">السعر الحالي: ₪{{ number_format($item->unit_price ?? $item->drink->price ?? 0, 2) }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر الإجمالي الحالي:</label>
                        <div class="form-control-plaintext">₪{{ number_format($item->price, 2) }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر الإجمالي الجديد:</label>
                        <div class="form-control-plaintext fw-bold text-primary" id="new_total_price_{{ $item->id }}">₪{{ number_format($item->price, 2) }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    const drinkSelect = document.getElementById('drink_id');
    const quantityInput = document.getElementById('quantity');

    function updateTotalPrice() {
        const selectedOption = drinkSelect.options[drinkSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value) || 1;
        const totalPrice = price * quantity;

        const totalPriceDisplay = document.getElementById('total_price_display');
        if (totalPriceDisplay) {
            totalPriceDisplay.textContent = '₪' + totalPrice.toFixed(2);
        }
    }

    if (drinkSelect) {
        drinkSelect.addEventListener('change', updateTotalPrice);
    }

    if (quantityInput) {
        quantityInput.addEventListener('input', updateTotalPrice);
    }

    // حساب السعر الإجمالي الجديد عند تعديل سعر الواحدة أو الكمية
    @foreach($drinkInvoice->items as $item)
    (function() {
        const unitPriceInput{{ $item->id }} = document.getElementById('unit_price_{{ $item->id }}');
        const quantityInput{{ $item->id }} = document.getElementById('quantity_{{ $item->id }}');
        const newTotalPriceDisplay{{ $item->id }} = document.getElementById('new_total_price_{{ $item->id }}');

        if (unitPriceInput{{ $item->id }} && quantityInput{{ $item->id }} && newTotalPriceDisplay{{ $item->id }}) {
            function updateNewTotalPrice{{ $item->id }}() {
                const unitPrice = parseFloat(unitPriceInput{{ $item->id }}.value) || 0;
                const quantity = parseInt(quantityInput{{ $item->id }}.value) || 1;
                const newTotalPrice = unitPrice * quantity;
                newTotalPriceDisplay{{ $item->id }}.textContent = '₪' + newTotalPrice.toFixed(2);
            }

            unitPriceInput{{ $item->id }}.addEventListener('input', updateNewTotalPrice{{ $item->id }});
            unitPriceInput{{ $item->id }}.addEventListener('change', updateNewTotalPrice{{ $item->id }});
            quantityInput{{ $item->id }}.addEventListener('input', updateNewTotalPrice{{ $item->id }});
            quantityInput{{ $item->id }}.addEventListener('change', updateNewTotalPrice{{ $item->id }});
        }
    })();
    @endforeach
});
</script>

@endsection

