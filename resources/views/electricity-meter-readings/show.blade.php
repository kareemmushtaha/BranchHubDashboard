@extends('layouts.app')

@section('title', 'عرض قراءة عداد كهرباء')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">عرض قراءة عداد كهرباء</h1>
    <div>
        <a href="{{ route('electricity-meter-readings.edit', $electricityMeterReading) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>تعديل
        </a>
        <a href="{{ route('electricity-meter-readings.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">تفاصيل القراءة</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card {{ $electricityMeterReading->morning_reading !== null ? 'bg-info text-white' : 'bg-light' }}">
                            <div class="card-body text-center">
                                <i class="bi bi-sunrise display-4 mb-2"></i>
                                <h5 class="card-title">قراءة صباحاً</h5>
                                <h2 class="mb-0">
                                    @if($electricityMeterReading->morning_reading !== null)
                                        {{ number_format($electricityMeterReading->morning_reading, 2) }}
                                    @else
                                        <span class="text-muted">غير مدخلة</span>
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card {{ $electricityMeterReading->afternoon_reading !== null ? 'bg-warning text-white' : 'bg-light' }}">
                            <div class="card-body text-center">
                                <i class="bi bi-sun display-4 mb-2"></i>
                                <h5 class="card-title">قراءة عصراً</h5>
                                <h2 class="mb-0">
                                    @if($electricityMeterReading->afternoon_reading !== null)
                                        {{ number_format($electricityMeterReading->afternoon_reading, 2) }}
                                    @else
                                        <span class="text-muted">غير مدخلة</span>
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card {{ $electricityMeterReading->evening_reading !== null ? 'bg-primary text-white' : 'bg-light' }}">
                            <div class="card-body text-center">
                                <i class="bi bi-moon display-4 mb-2"></i>
                                <h5 class="card-title">قراءة مساءً</h5>
                                <h2 class="mb-0">
                                    @if($electricityMeterReading->evening_reading !== null)
                                        {{ number_format($electricityMeterReading->evening_reading, 2) }}
                                    @else
                                        <span class="text-muted">غير مدخلة</span>
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="40%">المستخدم:</th>
                                    <td>{{ $electricityMeterReading->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإدخال:</th>
                                    <td>{{ $electricityMeterReading->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>ساعة الإدخال:</th>
                                    <td>{{ $electricityMeterReading->created_at->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>آخر تحديث:</th>
                                    <td>{{ $electricityMeterReading->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">إجمالي القراءات المدخلة</h6>
                                <h3 class="text-primary">
                                    @php
                                        $total = 0;
                                        if ($electricityMeterReading->morning_reading !== null) {
                                            $total += $electricityMeterReading->morning_reading;
                                        }
                                        if ($electricityMeterReading->afternoon_reading !== null) {
                                            $total += $electricityMeterReading->afternoon_reading;
                                        }
                                        if ($electricityMeterReading->evening_reading !== null) {
                                            $total += $electricityMeterReading->evening_reading;
                                        }
                                    @endphp
                                    {{ number_format($total, 2) }}
                                </h3>
                                <p class="text-muted mb-0">مجموع القراءات المدخلة</p>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <a href="{{ route('electricity-meter-readings.edit', $electricityMeterReading) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>تعديل القراءة
                    </a>
                    <form action="{{ route('electricity-meter-readings.destroy', $electricityMeterReading) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه القراءة؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>حذف القراءة
                        </button>
                    </form>
                    <a href="{{ route('electricity-meter-readings.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

