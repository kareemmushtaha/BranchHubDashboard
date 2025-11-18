@extends('layouts.app')

@section('title', 'قراءات عداد الكهرباء')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">قراءات عداد الكهرباء</h1>
    <a href="{{ route('electricity-meter-readings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>إضافة قراءة جديدة
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($readings->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>قراءة صباحاً</th>
                            <th>قراءة عصراً</th>
                            <th>قراءة مساءً</th>
                            <th>المستخدم</th>
                            <th>تاريخ الإدخال</th>
                            <th>ساعة الإدخال</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readings as $reading)
                        <tr>
                            <td>{{ $reading->id }}</td>
                            <td>
                                @if($reading->morning_reading !== null)
                                    <span class="badge bg-info fs-6">
                                        {{ number_format($reading->morning_reading, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($reading->afternoon_reading !== null)
                                    <span class="badge bg-warning fs-6">
                                        {{ number_format($reading->afternoon_reading, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($reading->evening_reading !== null)
                                    <span class="badge bg-primary fs-6">
                                        {{ number_format($reading->evening_reading, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $reading->user->name }}</td>
                            <td>{{ $reading->created_at->format('Y-m-d') }}</td>
                            <td>{{ $reading->created_at->format('H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('electricity-meter-readings.show', $reading) }}" class="btn btn-sm btn-outline-info" title="عرض">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('electricity-meter-readings.edit', $reading) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('electricity-meter-readings.destroy', $reading) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه القراءة؟')">
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
                {{ $readings->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-lightning-charge display-1 text-muted"></i>
                <h4 class="mt-3 text-muted">لا توجد قراءات</h4>
                <p class="text-muted">لم يتم إضافة أي قراءات لعداد الكهرباء بعد</p>
                <a href="{{ route('electricity-meter-readings.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>إضافة أول قراءة
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Summary Cards -->
@if($readings->count() > 0)
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">متوسط القراءة الصباحية</h5>
                        <h3 class="mb-0">
                            @php
                                $morningAvg = $readings->whereNotNull('morning_reading')->avg('morning_reading');
                            @endphp
                            {{ $morningAvg !== null ? number_format($morningAvg, 2) : '-' }}
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-sunrise display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">متوسط القراءة العصرية</h5>
                        <h3 class="mb-0">
                            @php
                                $afternoonAvg = $readings->whereNotNull('afternoon_reading')->avg('afternoon_reading');
                            @endphp
                            {{ $afternoonAvg !== null ? number_format($afternoonAvg, 2) : '-' }}
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-sun display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">متوسط القراءة المسائية</h5>
                        <h3 class="mb-0">
                            @php
                                $eveningAvg = $readings->whereNotNull('evening_reading')->avg('evening_reading');
                            @endphp
                            {{ $eveningAvg !== null ? number_format($eveningAvg, 2) : '-' }}
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-moon display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

