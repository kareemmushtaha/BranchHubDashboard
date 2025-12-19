@extends('layouts.app')

@section('title', 'تعديل الدور')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تعديل الدور: {{ $role->name }}</h1>
    <div>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">معلومات الدور</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="role_name" class="form-label">اسم الدور</label>
                <input type="text" class="form-control" id="role_name" name="name" value="{{ old('name', $role->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">الصلاحيات</label>
                <div class="border rounded p-3" style="max-height: 500px; overflow-y: auto;">
                    @foreach($permissionsByCategory as $category => $categoryPermissions)
                        @php
                            $categorySlug = str_replace(' ', '-', strtolower($category));
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold text-primary mb-0">{{ $category }}</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="toggleCategory('{{ $categorySlug }}')">
                                    <i class="bi bi-check-all"></i> تحديد الكل
                                </button>
                            </div>
                            <div class="row">
                                @foreach($categoryPermissions as $permission)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input category-{{ $categorySlug }}" 
                                                   type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->name }}" 
                                                   id="perm_{{ $permission->id }}"
                                                   {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleCategory(category) {
        const checkboxes = document.querySelectorAll(`.category-${category}`);
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
        });
    }
</script>
@endsection

