@extends('layouts.app')

@section('title', 'تعديل قراءة عداد كهرباء')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تعديل قراءة عداد كهرباء</h1>
    <a href="{{ route('electricity-meter-readings.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">بيانات قراءة العداد</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('electricity-meter-readings.update', $electricityMeterReading) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="morning_reading" class="form-label">
                                <i class="bi bi-sunrise me-2"></i>قراءة العداد صباحاً
                            </label>
                            <input type="number" 
                                   class="form-control @error('morning_reading') is-invalid @enderror" 
                                   id="morning_reading" 
                                   name="morning_reading" 
                                   value="{{ old('morning_reading', $electricityMeterReading->morning_reading ?? '') }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="اتركه فارغاً لحذف القيمة">
                            @error('morning_reading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="afternoon_reading" class="form-label">
                                <i class="bi bi-sun me-2"></i>قراءة العداد عصراً
                            </label>
                            <input type="number" 
                                   class="form-control @error('afternoon_reading') is-invalid @enderror" 
                                   id="afternoon_reading" 
                                   name="afternoon_reading" 
                                   value="{{ old('afternoon_reading', $electricityMeterReading->afternoon_reading ?? '') }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="اتركه فارغاً لحذف القيمة">
                            @error('afternoon_reading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="evening_reading" class="form-label">
                                <i class="bi bi-moon me-2"></i>قراءة العداد مساءً
                            </label>
                            <input type="number" 
                                   class="form-control @error('evening_reading') is-invalid @enderror" 
                                   id="evening_reading" 
                                   name="evening_reading" 
                                   value="{{ old('evening_reading', $electricityMeterReading->evening_reading ?? '') }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="اتركه فارغاً لحذف القيمة">
                            @error('evening_reading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>ملاحظة:</strong> يمكنك تعديل أو حذف أي قراءة. تاريخ وساعة الإدخال الأصلي: {{ $electricityMeterReading->created_at->format('Y-m-d H:i') }}
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('electricity-meter-readings.index') }}" class="btn btn-secondary">إلغاء</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>تحديث القراءة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات القراءة</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>المستخدم:</strong><br>
                    {{ $electricityMeterReading->user->name }}
                </div>
                <div class="mb-3">
                    <strong>تاريخ الإدخال:</strong><br>
                    {{ $electricityMeterReading->created_at->format('Y-m-d') }}
                </div>
                <div class="mb-3">
                    <strong>ساعة الإدخال:</strong><br>
                    {{ $electricityMeterReading->created_at->format('H:i') }}
                </div>
                <div class="mb-3">
                    <strong>آخر تحديث:</strong><br>
                    {{ $electricityMeterReading->updated_at->format('Y-m-d H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

