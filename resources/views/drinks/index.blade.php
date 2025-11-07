@extends('layouts.app')

@section('title', 'إدارة المشروبات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إدارة المشروبات</h1>
    <div>
        <a href="{{ route('drinks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة مشروب جديد
        </a>
    </div>
</div>

<!-- إحصائيات المشروبات -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_drinks'] }}</h4>
                        <p class="card-text">إجمالي المشروبات</p>
                    </div>
                    <div>
                        <i class="bi bi-cup fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['available_drinks'] }}</h4>
                        <p class="card-text">متوفر</p>
                    </div>
                    <div>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['unavailable_drinks'] }}</h4>
                        <p class="card-text">غير متوفر</p>
                    </div>
                    <div>
                        <i class="bi bi-x-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_sold'] }}</h4>
                        <p class="card-text">إجمالي المبيعات</p>
                    </div>
                    <div>
                        <i class="bi bi-graph-up fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- جدول المشروبات -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة المشروبات</h5>
    </div>
    <div class="card-body">
        @if($drinks->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>اسم المشروب</th>
                        <th>السعر</th>
                        <th>الحجم</th>
                        <th>الحالة</th>
                        <th>عدد المبيعات</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drinks as $drink)
                    <tr>
                        <td>{{ $drink->name }}</td>
                        <td>${{ number_format($drink->price, 2) }}</td>
                        <td>
                            @if($drink->size == 'small')
                                <span class="badge bg-secondary">صغير</span>
                            @elseif($drink->size == 'medium')
                                <span class="badge bg-primary">متوسط</span>
                            @else
                                <span class="badge bg-success">كبير</span>
                            @endif
                        </td>
                        <td>
                            @if($drink->status == 'available')
                                <span class="badge bg-success">متوفر</span>
                            @else
                                <span class="badge bg-danger">غير متوفر</span>
                            @endif
                        </td>
                        <td>{{ $drink->sessionDrinks()->count() }}</td>
                        <td>{{ $drink->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('drinks.show', $drink) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('drinks.edit', $drink) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('drinks.destroy', $drink) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المشروب؟')">
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
        <div class="d-flex justify-content-center">
            {{ $drinks->links() }}
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-cup display-1 text-muted"></i>
            <h5 class="mt-3">لا توجد مشروبات</h5>
            <p class="text-muted">ابدأ بإضافة مشروب جديد إلى القائمة</p>
            <a href="{{ route('drinks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> إضافة مشروب جديد
            </a>
        </div>
        @endif
    </div>
</div>

@endsection