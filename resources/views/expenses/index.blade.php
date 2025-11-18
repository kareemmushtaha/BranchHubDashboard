@extends('layouts.app')

@section('title', 'المصروفات المالية')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">المصروفات المالية</h1>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>إضافة مصروف جديد
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($expenses->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم البند</th>
                            <th>سعر البند</th>
                            <th>طريقة الدفع</th>
                            <th>تاريخ الدفع</th>
                            <th>الوصف</th>
                            <th>تم الإدخال بواسطة</th>
                            <th>تاريخ الإضافة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->id }}</td>
                            <td>
                                <strong>{{ $expense->item_name ?? 'غير محدد' }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-danger fs-6">
                                    {{ number_format($expense->amount, 2) }} ₪
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $expense->payment_type === 'bank' ? 'bg-info' : 'bg-success' }}">
                                    {{ $expense->payment_type_arabic }}
                                </span>
                            </td>
                            <td>
                                <i class="bi bi-calendar me-1"></i>
                                {{ $expense->payment_date ? $expense->payment_date->format('Y-m-d') : $expense->created_at->format('Y-m-d') }}
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $expense->details }}">
                                    {{ $expense->details }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>
                                    <div>
                                        <strong>{{ $expense->user->name }}</strong>
                                        @if($expense->user->email)
                                            <br>
                                            <small class="text-muted">{{ $expense->user->email }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $expense->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('expenses.show', $expense) }}" class="btn btn-sm btn-outline-info" title="عرض">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المصروف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
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
            <div class="d-flex justify-content-center mt-4">
                {{ $expenses->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-receipt display-1 text-muted"></i>
                <h4 class="mt-3 text-muted">لا توجد مصروفات مالية</h4>
                <p class="text-muted">لم يتم إضافة أي مصروفات مالية بعد</p>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>إضافة أول مصروف
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Summary Card -->
@if($expenses->count() > 0)
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">إجمالي المصروفات</h5>
                        <h3 class="mb-0">{{ number_format($expenses->sum('amount'), 2) }} ₪</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-exchange display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">المصروفات البنكية</h5>
                        <h3 class="mb-0">{{ number_format($expenses->where('payment_type', 'bank')->sum('amount'), 2) }} ₪</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-bank display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">المصروفات النقدية</h5>
                        <h3 class="mb-0">{{ number_format($expenses->where('payment_type', 'cash')->sum('amount'), 2) }} ₪</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cash-coin display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
