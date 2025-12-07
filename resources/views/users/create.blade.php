@extends('layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إضافة مستخدم جديد</h1>
    <div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">بيانات المستخدم</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">الاسم بالانجليزي</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name_ar" class="form-label">الاسم بالعربي <small class="text-muted">(اختياري)</small></label>
                            <input type="text" class="form-control @error('name_ar') is-invalid @enderror" 
                                   id="name_ar" name="name_ar" value="{{ old('name_ar') }}">
                            @error('name_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني <small class="text-muted">(اختياري)</small></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="user_type" class="form-label">نوع المستخدم</label>
                            <select class="form-select @error('user_type') is-invalid @enderror" 
                                    id="user_type" name="user_type" required>
                                <option value="">اختر نوع المستخدم</option>
                                <optgroup label="عملاء">
                                    <option value="hourly" {{ old('user_type') == 'hourly' ? 'selected' : '' }}>ساعي</option>
                                    <option value="prepaid" {{ old('user_type') == 'prepaid' ? 'selected' : '' }}>مسبق الدفع</option>
                                    <option value="subscription" {{ old('user_type') == 'subscription' ? 'selected' : '' }}>اشتراك</option>
                                </optgroup>
                                <optgroup label="إدارة النظام">
                                    <option value="manager" {{ old('user_type') == 'manager' ? 'selected' : '' }}>مدير إداري</option>
                                    <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>مدير النظام (صلاحيات كاملة)</option>
                                </optgroup>
                            </select>
                            @error('user_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">الحالة</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">اختر الحالة</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>معلق</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary me-md-2">إلغاء</a>
                        <button type="submit" class="btn btn-primary">حفظ المستخدم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">ملاحظات</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-info-circle text-info"></i> سيتم إنشاء محفظة رقمية تلقائياً للمستخدم</li>
                    <li><i class="bi bi-key text-warning"></i> كلمة المرور الافتراضية: password (تأكد من تغييرها عند التسليم)</li>
                    <li><i class="bi bi-envelope text-primary"></i> البريد الإلكتروني اختياري ولكن يجب أن يكون فريد إذا تم إدخاله</li>
                    <li><i class="bi bi-calendar text-success"></i> تاريخ انتهاء الاشتراك للمشتركين فقط</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection