@extends('layouts.app')

@section('title', 'تعديل المشروب')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تعديل المشروب: {{ $drink->name }}</h1>
    <div>
        <a href="{{ route('drinks.show', $drink) }}" class="btn btn-info">
            <i class="bi bi-eye"></i> عرض
        </a>
        <a href="{{ route('drinks.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">تعديل بيانات المشروب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('drinks.update', $drink) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">اسم المشروب</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $drink->name) }}" required
                                   placeholder="مثال: شاي، قهوة، عصير">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">السعر (₪)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $drink->price) }}" required min="0"
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
                                <option value="small" {{ old('size', $drink->size) == 'small' ? 'selected' : '' }}>صغير</option>
                                <option value="medium" {{ old('size', $drink->size) == 'medium' ? 'selected' : '' }}>متوسط</option>
                                <option value="large" {{ old('size', $drink->size) == 'large' ? 'selected' : '' }}>كبير</option>
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
                                <option value="available" {{ old('status', $drink->status) == 'available' ? 'selected' : '' }}>متوفر</option>
                                <option value="unavailable" {{ old('status', $drink->status) == 'unavailable' ? 'selected' : '' }}>غير متوفر</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('drinks.show', $drink) }}" class="btn btn-secondary me-md-2">إلغاء</a>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
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
                <p><strong>تاريخ الإضافة:</strong><br>{{ $drink->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>آخر تحديث:</strong><br>{{ $drink->updated_at->format('Y-m-d H:i') }}</p>
                <p><strong>عدد المبيعات:</strong><br>{{ $drink->sessionDrinks()->count() }} مرة</p>
                <p><strong>إجمالي الإيرادات:</strong><br>₪{{ number_format($drink->sessionDrinks()->sum('price'), 2) }}</p>
                
                <hr>
                
                <div class="d-grid">
                    <form action="{{ route('drinks.destroy', $drink) }}" method="POST" 
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروب؟\nسيتم منع حذفه إذا كان له طلبات مرتبطة.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> حذف المشروب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection