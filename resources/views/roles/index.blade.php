@extends('layouts.app')

@section('title', 'إدارة الأدوار والصلاحيات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إدارة الأدوار والصلاحيات</h1>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            <i class="bi bi-plus-circle"></i> إضافة دور جديد
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Roles List -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة الأدوار</h5>
    </div>
    <div class="card-body">
        @if($roles->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>اسم الدور</th>
                        <th>عدد الصلاحيات</th>
                        <th>الصلاحيات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>
                            <strong>{{ $role->name }}</strong>
                            @if($role->name === 'admin')
                                <span class="badge bg-danger">مدير النظام</span>
                            @endif
                        </td>
                        <td>{{ $role->permissions->count() }}</td>
                        <td>
                            @if($role->permissions->count() > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($role->permissions->take(5) as $permission)
                                        <span class="badge bg-secondary">{{ $permission->name }}</span>
                                    @endforeach
                                    @if($role->permissions->count() > 5)
                                        <span class="badge bg-info">+{{ $role->permissions->count() - 5 }} أكثر</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">لا توجد صلاحيات</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> تعديل
                                </a>
                                @if($role->name !== 'admin')
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('هل أنت متأكد من حذف هذا الدور؟')">
                                        <i class="bi bi-trash"></i> حذف
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-shield-check display-1 text-muted"></i>
            <h5 class="mt-3">لا توجد أدوار</h5>
            <p class="text-muted">ابدأ بإضافة دور جديد</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="bi bi-plus-circle"></i> إضافة دور جديد
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">إضافة دور جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="role_name" class="form-label">اسم الدور</label>
                        <input type="text" class="form-control" id="role_name" name="name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الصلاحيات</label>
                        <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
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
                                                           id="perm_{{ $permission->id }}">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Toggle all checkboxes in a category
    function toggleCategory(category) {
        const checkboxes = document.querySelectorAll(`.category-${category}`);
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
        });
    }
</script>
@endsection

