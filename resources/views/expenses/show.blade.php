@extends('layouts.app')

@section('title', 'تفاصيل المصروف')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تفاصيل المصروف</h1>
    <div>
        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>تعديل
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
                <h5 class="card-title mb-0">بيانات المصروف</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">رقم المصروف:</label>
                        <p class="form-control-plaintext">{{ $expense->id }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">قيمة المبلغ:</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-danger fs-6">
                                {{ number_format($expense->amount, 2) }} ₪
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع الدفع:</label>
                        <p class="form-control-plaintext">
                            <span class="badge {{ $expense->payment_type === 'bank' ? 'bg-info' : 'bg-success' }} fs-6">
                                {{ $expense->payment_type_arabic }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">المستخدم:</label>
                        <p class="form-control-plaintext">{{ $expense->user->name }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">التفاصيل:</label>
                    <div class="border rounded p-3 bg-light">
                        <p class="mb-0">{{ $expense->details }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ الإضافة:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-calendar me-2"></i>
                            {{ $expense->created_at->format('Y-m-d') }}
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">وقت الإضافة:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-clock me-2"></i>
                            {{ $expense->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>

                @if($expense->updated_at != $expense->created_at)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ آخر تعديل:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-calendar-check me-2"></i>
                            {{ $expense->updated_at->format('Y-m-d') }}
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">وقت آخر تعديل:</label>
                        <p class="form-control-plaintext">
                            <i class="bi bi-clock-history me-2"></i>
                            {{ $expense->updated_at->format('H:i') }}
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
                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>تعديل المصروف
                    </a>
                    
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" 
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المصروف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>حذف المصروف
                        </button>
                    </form>
                    
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات إضافية</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>نوع الدفع:</strong> {{ $expense->payment_type_arabic }}
                </div>
                
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>تنبيه:</strong> لا يمكن التراجع عن حذف المصروف.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
