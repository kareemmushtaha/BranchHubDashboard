@extends('layouts.app')

@section('title', 'إدارة رواتب الموظفين')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إدارة رواتب الموظفين</h1>
    @can('create employee salaries')
    <a href="{{ route('employee-salaries.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>إضافة راتب جديد
    </a>
    @endcan
</div>

<div class="card">
    <div class="card-body">
        @if($employeeSalaries->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الموظف</th>
                            <th>تاريخ الراتب</th>
                            <th>المبلغ الكاش</th>
                            <th>المبلغ البنكي</th>
                            <th>الإجمالي</th>
                            <th>نوع الحوالة</th>
                            <th>تم الإدخال بواسطة</th>
                            <th>تاريخ الإضافة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employeeSalaries as $salary)
                        <tr>
                            <td>{{ $salary->id }}</td>
                            <td>
                                <strong>{{ $salary->employee_name }}</strong>
                            </td>
                            <td>
                                <i class="bi bi-calendar me-1"></i>
                                {{ $salary->salary_date ? $salary->salary_date->format('Y-m-d') : $salary->created_at->format('Y-m-d') }}
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    {{ number_format($salary->cash_amount, 2) }} ₪
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info fs-6">
                                    {{ number_format($salary->bank_amount, 2) }} ₪
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary fs-6">
                                    {{ number_format($salary->total_amount, 2) }} ₪
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $salary->transfer_type === 'full' ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ $salary->transfer_type_arabic }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>
                                    <div>
                                        <strong>{{ $salary->user->name }}</strong>
                                        @if($salary->user->email)
                                            <br>
                                            <small class="text-muted">{{ $salary->user->email }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $salary->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @can('view employee salaries')
                                    <a href="{{ route('employee-salaries.show', $salary) }}" class="btn btn-sm btn-outline-info" title="عرض">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @endcan
                                    @can('edit employee salaries')
                                    <a href="{{ route('employee-salaries.edit', $salary) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('delete employee salaries')
                                    <form action="{{ route('employee-salaries.destroy', $salary) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الراتب؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $employeeSalaries->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-wallet2 display-1 text-muted"></i>
                <h4 class="mt-3 text-muted">لا توجد رواتب موظفين</h4>
                <p class="text-muted">لم يتم إضافة أي رواتب موظفين بعد</p>
                @can('create employee salaries')
                <a href="{{ route('employee-salaries.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>إضافة أول راتب
                </a>
                @endcan
            </div>
        @endif
    </div>
</div>

<!-- Summary Cards -->
@if($employeeSalaries->count() > 0)
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">إجمالي الرواتب</h5>
                        <h3 class="mb-0">{{ number_format($employeeSalaries->sum(function($s) { return $s->cash_amount + $s->bank_amount; }), 2) }} ₪</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-exchange display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">إجمالي الكاش</h5>
                        <h3 class="mb-0">{{ number_format($employeeSalaries->sum('cash_amount'), 2) }} ₪</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cash-coin display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">إجمالي البنكي</h5>
                        <h3 class="mb-0">{{ number_format($employeeSalaries->sum('bank_amount'), 2) }} ₪</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-bank display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">عدد الرواتب</h5>
                        <h3 class="mb-0">{{ $employeeSalaries->total() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

