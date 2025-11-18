@extends('layouts.app')

@section('title', 'إضافة قراءة عداد كهرباء جديدة')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إضافة قراءة عداد كهرباء جديدة</h1>
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
                <form action="{{ route('electricity-meter-readings.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="morning_reading" class="form-label">
                                <i class="bi bi-sunrise me-2"></i>قراءة العداد صباحاً
                            </label>
                            <input type="number" 
                                   class="form-control @error('morning_reading') is-invalid @enderror" 
                                   id="morning_reading" 
                                   name="morning_reading" 
                                   value="{{ old('morning_reading') }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="اتركه فارغاً إذا لم تدخله">
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
                                   value="{{ old('afternoon_reading') }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="اتركه فارغاً إذا لم تدخله">
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
                                   value="{{ old('evening_reading') }}" 
                                   step="0.01" 
                                   min="0" 
                                   placeholder="اتركه فارغاً إذا لم تدخله">
                            @error('evening_reading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>ملاحظة:</strong> يمكنك إدخال قراءة واحدة أو أكثر في نفس الوقت. سيتم حفظ تاريخ وساعة الإدخال تلقائياً في قاعدة البيانات.
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('electricity-meter-readings.index') }}" class="btn btn-secondary">إلغاء</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>حفظ القراءة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات إضافية</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>تنبيه:</strong> تأكد من صحة القراءات قبل الحفظ.
                </div>

                <div class="mt-3">
                    <h6>نصائح:</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success me-2"></i>يمكنك إدخال قراءة واحدة في كل مرة</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>سجل القراءة الصباحية في الصباح</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>سجل القراءة العصرية في العصر</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>سجل القراءة المسائية في المساء</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>تأكد من قراءة العداد بدقة</li>
                    </ul>
                </div>

                <div class="mt-3">
                    <h6>أوقات التسجيل:</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-sunrise text-info me-2"></i><strong>صباحاً:</strong> في الصباح</li>
                        <li><i class="bi bi-sun text-warning me-2"></i><strong>عصراً:</strong> في فترة العصر</li>
                        <li><i class="bi bi-moon text-primary me-2"></i><strong>مساءً:</strong> في المساء</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

