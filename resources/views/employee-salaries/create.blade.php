@extends('layouts.app')

@section('title', 'إضافة راتب جديد')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إضافة راتب جديد</h1>
    <a href="{{ route('employee-salaries.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">بيانات الراتب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('employee-salaries.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="employee_name" class="form-label">اسم الموظف <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('employee_name') is-invalid @enderror" 
                               id="employee_name" 
                               name="employee_name" 
                               value="{{ old('employee_name') }}" 
                               placeholder="مثال: أحمد محمد" 
                               maxlength="255" 
                               required>
                        @error('employee_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="salary_date" class="form-label">تاريخ الراتب</label>
                        <input type="date" 
                               class="form-control @error('salary_date') is-invalid @enderror" 
                               id="salary_date" 
                               name="salary_date" 
                               value="{{ old('salary_date', date('Y-m-d')) }}">
                        <div class="form-text">يمكنك تحديد تاريخ الراتب يدوياً، وإذا لم تقم بتحديد تاريخ، سيتم استخدام التاريخ الحالي تلقائياً</div>
                        @error('salary_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cash_amount" class="form-label">المبلغ الكاش (شيكل) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('cash_amount') is-invalid @enderror" 
                                       id="cash_amount" 
                                       name="cash_amount" 
                                       value="{{ old('cash_amount', 0) }}" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="0.00" 
                                       required>
                                <span class="input-group-text">₪</span>
                            </div>
                            @error('cash_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bank_amount" class="form-label">المبلغ البنكي (شيكل) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('bank_amount') is-invalid @enderror" 
                                       id="bank_amount" 
                                       name="bank_amount" 
                                       value="{{ old('bank_amount', 0) }}" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="0.00" 
                                       required>
                                <span class="input-group-text">₪</span>
                            </div>
                            @error('bank_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="transfer_type" class="form-label">نوع الحوالة <span class="text-danger">*</span></label>
                        <select class="form-select @error('transfer_type') is-invalid @enderror" 
                                id="transfer_type" 
                                name="transfer_type" 
                                required>
                            <option value="">اختر نوع الحوالة</option>
                            <option value="full" {{ old('transfer_type') === 'full' ? 'selected' : '' }}>راتب كامل</option>
                            <option value="partial" {{ old('transfer_type') === 'partial' ? 'selected' : '' }}>راتب جزئي</option>
                        </select>
                        @error('transfer_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" 
                                  name="notes" 
                                  rows="4" 
                                  maxlength="1000" 
                                  placeholder="اكتب أي ملاحظات إضافية...">{{ old('notes') }}</textarea>
                        <div class="form-text">الحد الأقصى 1000 حرف</div>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employee-salaries.index') }}" class="btn btn-secondary">إلغاء</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>حفظ الراتب
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
                    <strong>ملاحظة:</strong> سيتم ربط هذا الراتب بحسابك الحالي.
                </div>
                
                <div class="mb-3 p-3 bg-light rounded">
                    <label class="form-label fw-bold text-muted small mb-2">سيتم تسجيل الإدخال باسم:</label>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle me-2 text-primary fs-5"></i>
                        <div>
                            <strong>{{ Auth::user()->name }}</strong>
                            @if(Auth::user()->email)
                                <br>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>تنبيه:</strong> تأكد من صحة البيانات قبل الحفظ.
                </div>

                <div class="mt-3">
                    <h6>نصائح:</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success me-2"></i>أدخل اسم الموظف بشكل صحيح</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>تأكد من صحة المبالغ</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>اختر نوع الحوالة المناسب</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Character counter for notes textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('notes');
        if (textarea) {
            const maxLength = 1000;
            
            function updateCounter() {
                const remaining = maxLength - textarea.value.length;
                const counter = textarea.nextElementSibling;
                if (counter && counter.classList.contains('form-text')) {
                    counter.textContent = `الحد الأقصى 1000 حرف (متبقي: ${remaining})`;
                    
                    if (remaining < 50) {
                        counter.classList.add('text-warning');
                    } else {
                        counter.classList.remove('text-warning');
                    }
                }
            }
            
            textarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
</script>
@endsection

