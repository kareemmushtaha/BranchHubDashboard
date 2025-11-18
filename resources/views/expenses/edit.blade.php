@extends('layouts.app')

@section('title', 'تعديل المصروف')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تعديل المصروف</h1>
    <div>
        <a href="{{ route('expenses.show', $expense) }}" class="btn btn-info me-2">
            <i class="bi bi-eye me-2"></i>عرض
        </a>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">تعديل بيانات المصروف</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('expenses.update', $expense) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="item_name" class="form-label">اسم البند <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('item_name') is-invalid @enderror" 
                               id="item_name" 
                               name="item_name" 
                               value="{{ old('item_name', $expense->item_name ?? '') }}" 
                               placeholder="مثال: شراء كرسي" 
                               maxlength="255" 
                               required>
                        @error('item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">سعر البند (شيكل) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" 
                                       name="amount" 
                                       value="{{ old('amount', $expense->amount) }}" 
                                       step="0.01" 
                                       min="0.01" 
                                       placeholder="105" 
                                       required>
                                <span class="input-group-text">₪</span>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="payment_type" class="form-label">طريقة الدفع <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_type') is-invalid @enderror" 
                                    id="payment_type" 
                                    name="payment_type" 
                                    required>
                                <option value="">اختر طريقة الدفع</option>
                                <option value="bank" {{ old('payment_type', $expense->payment_type) === 'bank' ? 'selected' : '' }}>بنكي</option>
                                <option value="cash" {{ old('payment_type', $expense->payment_type) === 'cash' ? 'selected' : '' }}>كاش</option>
                            </select>
                            @error('payment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="payment_date" class="form-label">تاريخ الدفع</label>
                        <input type="date" 
                               class="form-control @error('payment_date') is-invalid @enderror" 
                               id="payment_date" 
                               name="payment_date" 
                               value="{{ old('payment_date', $expense->payment_date ? $expense->payment_date->format('Y-m-d') : date('Y-m-d')) }}">
                        <div class="form-text">إذا لم تقم بتحديد تاريخ، سيتم استخدام التاريخ الحالي تلقائياً</div>
                        @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label">وصف عن المنتج الذي تم شراؤه <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('details') is-invalid @enderror" 
                                  id="details" 
                                  name="details" 
                                  rows="4" 
                                  maxlength="1000" 
                                  placeholder="اكتب وصفاً عن المنتج الذي تم شراؤه..." 
                                  required>{{ old('details', $expense->details) }}</textarea>
                        <div class="form-text">الحد الأقصى 1000 حرف</div>
                        @error('details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('expenses.show', $expense) }}" class="btn btn-secondary">إلغاء</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات المصروف</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">رقم المصروف:</label>
                    <p class="form-control-plaintext">{{ $expense->id }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">تم الإدخال بواسطة:</label>
                    <div class="d-flex align-items-center p-2 bg-light rounded">
                        <i class="bi bi-person-circle me-2 text-primary"></i>
                        <div>
                            <strong>{{ $expense->user->name }}</strong>
                            @if($expense->user->email)
                                <br>
                                <small class="text-muted">{{ $expense->user->email }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">تاريخ الإضافة:</label>
                    <p class="form-control-plaintext">
                        <i class="bi bi-calendar me-2"></i>
                        {{ $expense->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>

                @if($expense->updated_at != $expense->created_at)
                <div class="mb-3">
                    <label class="form-label fw-bold">آخر تعديل:</label>
                    <p class="form-control-plaintext">
                        <i class="bi bi-clock-history me-2"></i>
                        {{ $expense->updated_at->format('Y-m-d H:i') }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">تنبيهات</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>تنبيه:</strong> تأكد من صحة البيانات قبل الحفظ.
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>ملاحظة:</strong> سيتم حفظ تاريخ آخر تعديل.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Character counter for details textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('details');
        const maxLength = 1000;
        
        function updateCounter() {
            const remaining = maxLength - textarea.value.length;
            const counter = document.querySelector('.form-text');
            counter.textContent = `الحد الأقصى 1000 حرف (متبقي: ${remaining})`;
            
            if (remaining < 50) {
                counter.classList.add('text-warning');
            } else {
                counter.classList.remove('text-warning');
            }
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    });
</script>
@endsection
