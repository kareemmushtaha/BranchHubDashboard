@extends('layouts.app')

@section('title', 'إضافة مشروب جديد')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إضافة مشروب جديد</h1>
    <div>
        <a href="{{ route('drinks.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">بيانات المشروب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('drinks.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">اسم المشروب</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="مثال: شاي، قهوة، عصير">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">السعر (₪)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" required min="0"
                                   placeholder="0.00">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label">الحجم</label>
                            <select class="form-select @error('size') is-invalid @enderror" 
                                    id="size" name="size" required>
                                <option value="">اختر الحجم</option>
                                <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>صغير</option>
                                <option value="medium" {{ old('size') == 'medium' ? 'selected' : '' }}>متوسط</option>
                                <option value="large" {{ old('size') == 'large' ? 'selected' : '' }}>كبير</option>
                            </select>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">الحالة</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">اختر الحالة</option>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متوفر</option>
                                <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>غير متوفر</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('drinks.index') }}" class="btn btn-secondary me-md-2">إلغاء</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> إضافة المشروب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">نصائح</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-info-circle text-info"></i> اختر اسماً واضحاً ومفهوماً</li>
                    <li><i class="bi bi-currency-dollar text-success"></i> ضع سعراً مناسباً ومربحاً</li>
                    <li><i class="bi bi-box text-primary"></i> حدد الحجم المناسب</li>
                    <li><i class="bi bi-check-circle text-warning"></i> تأكد من توفر المشروب</li>
                </ul>
                
                <hr>
                
                <h6>أمثلة على المشروبات:</h6>
                <ul class="list-unstyled small">
                    <li>• شاي - ₪2.00 - متوسط</li>
                    <li>• قهوة - ₪3.00 - كبير</li>
                    <li>• عصير برتقال - ₪4.00 - كبير</li>
                    <li>• مياه - ₪1.00 - صغير</li>
                    <li>• مشروب غازي - ₪2.50 - متوسط</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection