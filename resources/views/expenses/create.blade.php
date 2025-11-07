@extends('layouts.app')

@section('title', 'إضافة مصروف جديد')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إضافة مصروف جديد</h1>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">بيانات المصروف</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">قيمة المبلغ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" 
                                       name="amount" 
                                       value="{{ old('amount') }}" 
                                       step="0.01" 
                                       min="0.01" 
                                       required>
                                <span class="input-group-text">₪</span>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="payment_type" class="form-label">نوع الدفع <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_type') is-invalid @enderror" 
                                    id="payment_type" 
                                    name="payment_type" 
                                    required>
                                <option value="">اختر نوع الدفع</option>
                                <option value="bank" {{ old('payment_type') === 'bank' ? 'selected' : '' }}>بنكي</option>
                                <option value="cash" {{ old('payment_type') === 'cash' ? 'selected' : '' }}>نقدي</option>
                            </select>
                            @error('payment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label">التفاصيل <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('details') is-invalid @enderror" 
                                  id="details" 
                                  name="details" 
                                  rows="4" 
                                  maxlength="1000" 
                                  placeholder="اكتب تفاصيل المصروف هنا..." 
                                  required>{{ old('details') }}</textarea>
                        <div class="form-text">الحد الأقصى 1000 حرف</div>
                        @error('details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">إلغاء</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>حفظ المصروف
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات إضافية</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>ملاحظة:</strong> سيتم ربط هذا المصروف بحسابك الحالي.
                </div>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>تنبيه:</strong> تأكد من صحة البيانات قبل الحفظ.
                </div>

                <div class="mt-3">
                    <h6>نصائح:</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success me-2"></i>اكتب تفاصيل واضحة للمصروف</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>اختر نوع الدفع المناسب</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>تأكد من صحة المبلغ</li>
                    </ul>
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
