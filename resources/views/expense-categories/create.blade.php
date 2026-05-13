@extends('layouts.app')

@section('title', 'إضافة تصنيف مصروف')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إضافة تصنيف مصروف</h1>
    <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right"></i> العودة
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">بيانات تصنيف المصروف</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('expense-categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
