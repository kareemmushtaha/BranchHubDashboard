@extends('layouts.app')

@section('title', 'تصنيفات المصروفات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تصنيفات المصروفات</h1>
    @can('create expense categories')
    <div>
        <a href="{{ route('expense-categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة تصنيف مصروف
        </a>
    </div>
    @endcan
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة تصنيفات المصروفات</h5>
    </div>
    <div class="card-body p-0">
        @if($expenseCategories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th>عدد المصروفات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenseCategories as $expenseCategory)
                    <tr>
                        <td><strong>{{ $expenseCategory->name }}</strong></td>
                        <td>
                            <span class="badge {{ $expenseCategory->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $expenseCategory->status === 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td>{{ $expenseCategory->expenses_count }}</td>
                        <td>
                            @can('edit expense categories')
                            <a href="{{ route('expense-categories.edit', $expenseCategory) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endcan

                            @can('delete expense categories')
                            <form action="{{ route('expense-categories.destroy', $expenseCategory) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذا التصنيف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($expenseCategories->hasPages())
        <div class="p-3 border-top">
            {{ $expenseCategories->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-5">
            <i class="bi bi-tags display-4 text-muted"></i>
            <h5 class="mt-3">لا توجد تصنيفات للمصروفات</h5>
            @can('create expense categories')
            <a href="{{ route('expense-categories.create') }}" class="btn btn-primary mt-2"><i class="bi bi-plus-circle"></i> إضافة تصنيف مصروف</a>
            @endcan
        </div>
        @endif
    </div>
</div>
@endsection
