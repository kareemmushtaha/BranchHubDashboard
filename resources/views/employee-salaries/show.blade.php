@extends('layouts.app')

@section('title', 'تفاصيل راتب الموظف')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تفاصيل راتب الموظف</h1>
    <div>
        <a href="{{ route('employee-salaries.edit', $employeeSalary) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>تعديل
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
                <h5 class="card-title mb-0">بيانات الراتب</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">رقم الراتب:</label>
                        <p class="form-control-plaintext">{{ $employeeSalary->id }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم الموظف:</label>
                        <p class="form-control-plaintext">
                            <strong class="fs-5">{{ $employeeSalary->employee_name }}</strong>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ الراتب:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-calendar me-2"></i>
                            {{ $employeeSalary->salary_date ? $employeeSalary->salary_date->format('Y-m-d') : $employeeSalary->created_at->format('Y-m-d') }}
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع الحوالة:</label>
                        <p class="form-control-plaintext">
                            <span class="badge {{ $employeeSalary->transfer_type === 'full' ? 'bg-warning' : 'bg-secondary' }} fs-6">
                                {{ $employeeSalary->transfer_type_arabic }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">المبلغ الكاش:</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-success fs-6">
                                {{ number_format($employeeSalary->cash_amount, 2) }} ₪
                            </span>
                        </p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">المبلغ البنكي:</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-info fs-6">
                                {{ number_format($employeeSalary->bank_amount, 2) }} ₪
                            </span>
                        </p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">الإجمالي:</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-primary fs-6">
                                {{ number_format($employeeSalary->total_amount, 2) }} ₪
                            </span>
                        </p>
                    </div>
                </div>

                @if($employeeSalary->notes)
                <div class="mb-3">
                    <label class="form-label fw-bold">ملاحظات:</label>
                    <div class="border rounded p-3 bg-light">
                        <p class="mb-0">{{ $employeeSalary->notes }}</p>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تم الإدخال بواسطة:</label>
                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle me-3 text-primary fs-4"></i>
                                <div>
                                    <strong class="fs-5">{{ $employeeSalary->user->name }}</strong>
                                    @if($employeeSalary->user->email)
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-envelope me-1"></i>{{ $employeeSalary->user->email }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ الإضافة:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-calendar me-2"></i>
                            {{ $employeeSalary->created_at->format('Y-m-d') }}
                        </p>
                        <p class="form-control-plaintext">
                            <i class="bi bi-clock me-2"></i>
                            {{ $employeeSalary->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>

                @if($employeeSalary->updated_at != $employeeSalary->created_at)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ آخر تعديل:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-calendar-check me-2"></i>
                            {{ $employeeSalary->updated_at->format('Y-m-d') }}
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">وقت آخر تعديل:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-clock-history me-2"></i>
                            {{ $employeeSalary->updated_at->format('H:i') }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">الإجراءات</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('employee-salaries.edit', $employeeSalary) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>تعديل الراتب
                    </a>
                    
                    <form action="{{ route('employee-salaries.destroy', $employeeSalary) }}" method="POST" 
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الراتب؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>حذف الراتب
                        </button>
                    </form>
                    
                    <a href="{{ route('employee-salaries.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">ملخص الراتب</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small">المبلغ الكاش:</label>
                    <p class="fs-4 text-success fw-bold">{{ number_format($employeeSalary->cash_amount, 2) }} ₪</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small">المبلغ البنكي:</label>
                    <p class="fs-4 text-info fw-bold">{{ number_format($employeeSalary->bank_amount, 2) }} ₪</p>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small">الإجمالي:</label>
                    <p class="fs-3 text-primary fw-bold">{{ number_format($employeeSalary->total_amount, 2) }} ₪</p>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>نوع الحوالة:</strong> {{ $employeeSalary->transfer_type_arabic }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

