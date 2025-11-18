@extends('layouts.app')

@section('title', 'تعديل راتب الموظف')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تعديل راتب الموظف</h1>
    <div>
        <a href="{{ route('employee-salaries.show', $employeeSalary) }}" class="btn btn-info me-2">
            <i class="bi bi-eye me-2"></i>عرض
        </a>
        <a href="{{ route('employee-salaries.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">تعديل بيانات الراتب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('employee-salaries.update', $employeeSalary) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="employee_name" class="form-label">اسم الموظف <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('employee_name') is-invalid @enderror" 
                               id="employee_name" 
                               name="employee_name" 
                               value="{{ old('employee_name', $employeeSalary->employee_name) }}" 
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
                               value="{{ old('salary_date', $employeeSalary->salary_date ? $employeeSalary->salary_date->format('Y-m-d') : date('Y-m-d')) }}">
                        <div class="form-text">يمكنك تحديد تاريخ الراتب يدوياً</div>
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
                                       value="{{ old('cash_amount', $employeeSalary->cash_amount) }}" 
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
                                       value="{{ old('bank_amount', $employeeSalary->bank_amount) }}" 
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
                            <option value="full" {{ old('transfer_type', $employeeSalary->transfer_type) === 'full' ? 'selected' : '' }}>راتب كامل</option>
                            <option value="partial" {{ old('transfer_type', $employeeSalary->transfer_type) === 'partial' ? 'selected' : '' }}>راتب جزئي</option>
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
                                  placeholder="اكتب أي ملاحظات إضافية...">{{ old('notes', $employeeSalary->notes) }}</textarea>
                        <div class="form-text">الحد الأقصى 1000 حرف</div>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employee-salaries.show', $employeeSalary) }}" class="btn btn-secondary">إلغاء</a>
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
                <h5 class="card-title mb-0">معلومات الراتب</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">رقم الراتب:</label>
                    <p class="form-control-plaintext">{{ $employeeSalary->id }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">تم الإدخال بواسطة:</label>
                    <div class="d-flex align-items-center p-2 bg-light rounded">
                        <i class="bi bi-person-circle me-2 text-primary"></i>
                        <div>
                            <strong>{{ $employeeSalary->user->name }}</strong>
                            @if($employeeSalary->user->email)
                                <br>
                                <small class="text-muted">{{ $employeeSalary->user->email }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">تاريخ الإضافة:</label>
                    <p class="form-control-plaintext">
                        <i class="bi bi-calendar me-2"></i>
                        {{ $employeeSalary->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>

                @if($employeeSalary->updated_at != $employeeSalary->created_at)
                <div class="mb-3">
                    <label class="form-label fw-bold">آخر تعديل:</label>
                    <p class="form-control-plaintext">
                        <i class="bi bi-clock-history me-2"></i>
                        {{ $employeeSalary->updated_at->format('Y-m-d H:i') }}
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

