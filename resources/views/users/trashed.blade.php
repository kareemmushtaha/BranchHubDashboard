@extends('layouts.app')

@section('title', 'المستخدمين المحذوفين')

@section('content')
@php
    $userTypeBadges = [
        'hourly' => ['label' => 'ساعي', 'class' => 'bg-info'],
        'subscription' => ['label' => 'اشتراك', 'class' => 'bg-success'],
        'prepaid' => ['label' => 'مدفوع مسبقاً', 'class' => 'bg-primary'],
        'manager' => ['label' => 'مدير إداري', 'class' => 'bg-warning text-dark'],
        'admin' => ['label' => 'مدير النظام', 'class' => 'bg-danger'],
    ];
@endphp
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">المستخدمين المحذوفين (سلة المحذوفات)</h1>
    <div>
        <a href="{{ route('users.index') }}" class="btn btn-primary">
            <i class="bi bi-people"></i> المستخدمين النشطين
        </a>
    </div>
</div>

<!-- إحصائيات المستخدمين المحذوفين -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_deleted'] }}</h4>
                        <p class="card-text">مستخدمين محذوفين</p>
                    </div>
                    <div>
                        <i class="bi bi-trash fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['active_users'] }}</h4>
                        <p class="card-text">مستخدمين نشطين</p>
                    </div>
                    <div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_users'] }}</h4>
                        <p class="card-text">إجمالي المستخدمين</p>
                    </div>
                    <div>
                        <i class="bi bi-person-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلاتر البحث والفلترة للمحذوفين -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-search text-danger"></i>
                    البحث والفلترة في المحذوفين
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('users.trashed') }}" id="filterForm">
                    <div class="row g-3 align-items-end">
                        <!-- البحث -->
                        <div class="col-md-4">
                            <label class="form-label">البحث</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="اسم، إيميل، أو هاتف" 
                                   value="{{ request('search') }}">
                        </div>
                        
                        <!-- فلترة نوع المستخدم -->
                        <div class="col-md-2">
                            <label class="form-label">نوع المستخدم</label>
                            <select name="user_type" class="form-select">
                                <option value="">الكل</option>
                                <option value="hourly" {{ request('user_type') == 'hourly' ? 'selected' : '' }}>ساعي</option>
                                <option value="prepaid" {{ request('user_type') == 'prepaid' ? 'selected' : '' }}>مسبق الدفع</option>
                                <option value="subscription" {{ request('user_type') == 'subscription' ? 'selected' : '' }}>اشتراك</option>
                                <option value="manager" {{ request('user_type') == 'manager' ? 'selected' : '' }}>مدير إداري</option>
                                <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>مدير النظام</option>
                            </select>
                        </div>
                        
                        <!-- ترتيب -->
                        <div class="col-md-2">
                            <label class="form-label">ترتيب حسب</label>
                            <select name="sort_by" class="form-select">
                                <option value="deleted_at" {{ request('sort_by') == 'deleted_at' ? 'selected' : '' }}>تاريخ الحذف</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>الاسم</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>الإيميل</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>تاريخ التسجيل</option>
                                <option value="user_type" {{ request('sort_by') == 'user_type' ? 'selected' : '' }}>النوع</option>
                            </select>
                        </div>
                        
                        <!-- اتجاه الترتيب -->
                        <div class="col-md-2">
                            <label class="form-label">الاتجاه</label>
                            <select name="sort_direction" class="form-select">
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>↓</option>
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>↑</option>
                            </select>
                        </div>
                        
                        <!-- أزرار -->
                        <div class="col-md-2">
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-search"></i> بحث
                                </button>
                                <a href="{{ route('users.trashed') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-x-circle"></i> مسح
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- أزرار العمليات الجماعية للمحذوفين -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="mb-2">
                            <i class="bi bi-recycle text-success"></i>
                            العمليات الجماعية للمحذوفين
                        </h6>
                        <small class="text-muted">حدد المستخدمين واختر العملية المطلوبة</small>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check-all"></i> تحديد الكل
                            </button>
                            <button type="button" id="deselectAllBtn" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-square"></i> إلغاء التحديد
                            </button>
                            
                            <form id="bulkRestoreForm" action="{{ route('users.bulk-restore') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" id="bulkRestoreBtn" class="btn btn-sm btn-outline-success" disabled>
                                    <i class="bi bi-arrow-clockwise"></i> استرجاع المحددين
                                </button>
                            </form>
                            
                            <form id="bulkForceDeleteForm" action="{{ route('users.bulk-force-delete') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" id="bulkForceDeleteBtn" class="btn btn-sm btn-outline-danger" disabled>
                                    <i class="bi bi-trash3"></i> حذف نهائي
                                </button>
                            </form>
                            
                            <span class="badge bg-info" id="selectedCount">0 محدد</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- جدول المستخدمين المحذوفين -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة المستخدمين المحذوفين</h5>
    </div>
    <div class="card-body">
        @if($trashedUsers->count() > 0)
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-triangle"></i>
            <strong>تنبيه:</strong> هؤلاء المستخدمين محذوفين مؤقتاً ويمكن استرجاعهم أو حذفهم نهائياً.
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="50">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                <label class="form-check-label" for="selectAllCheckbox">
                                    <small>الكل</small>
                                </label>
                            </div>
                        </th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الهاتف</th>
                        <th>نوع المستخدم</th>
                        <th>رصيد المحفظة</th>
                        <th>تاريخ الحذف</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedUsers as $user)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input user-checkbox" type="checkbox" 
                                       name="user_ids[]" value="{{ $user->id }}" 
                                       id="user_{{ $user->id }}">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-slash text-danger me-2"></i>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?: '-' }}</td>
                        <td>
                            @php
                                $typeInfo = $userTypeBadges[$user->user_type] ?? ['label' => 'غير معروف', 'class' => 'bg-secondary'];
                            @endphp
                            <span class="badge {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
                        </td>
                        <td>
                            @if($user->wallet)
                                <span class="badge bg-secondary">${{ number_format($user->wallet->balance, 2) }}</span>
                            @else
                                <span class="text-muted">لا توجد محفظة</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $user->deleted_at->format('Y-m-d H:i') }}
                                <br>
                                <em>{{ $user->deleted_at->diffForHumans() }}</em>
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <!-- زر الاسترجاع -->
                                <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" 
                                            onclick="return confirm('هل تريد استرجاع هذا المستخدم؟')">
                                        <i class="bi bi-arrow-clockwise"></i> استرجاع
                                    </button>
                                </form>
                                
                                <!-- زر الحذف النهائي -->
                                <form action="{{ route('users.force-delete', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('هل أنت متأكد من الحذف النهائي؟ هذا الإجراء لا يمكن التراجع عنه!')">
                                        <i class="bi bi-trash3"></i> حذف نهائي
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- معلومات النتائج والتحكم في عدد العناصر للمحذوفين -->
        <div class="row align-items-center mt-4">
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0">عرض:</label>
                    <form method="GET" class="d-inline" id="perPageForm">
                        @foreach(request()->query() as $key => $value)
                            @if($key !== 'per_page')
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>
                    <span class="ms-2 text-muted">محذوف في الصفحة</span>
                </div>
            </div>
            
            <div class="col-md-4 text-center">
                <div class="text-muted">
                    @if($trashedUsers->total() > 0)
                        عرض {{ $trashedUsers->firstItem() }} إلى {{ $trashedUsers->lastItem() }} 
                        من أصل {{ number_format($trashedUsers->total()) }} محذوف
                        @if(request()->hasAny(['search', 'user_type']))
                            <small class="text-danger">(مفلتر من {{ number_format($stats['total_deleted']) }} إجمالي)</small>
                        @endif
                    @else
                        لا توجد نتائج
                    @endif
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="d-flex justify-content-end">
                    {{ $trashedUsers->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-trash display-1 text-muted"></i>
            <h5 class="mt-3">لا توجد مستخدمين محذوفين</h5>
            <p class="text-muted">جميع المستخدمين نشطين</p>
            <a href="{{ route('users.index') }}" class="btn btn-primary">
                <i class="bi bi-people"></i> عرض المستخدمين النشطين
            </a>
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkRestoreForm = document.getElementById('bulkRestoreForm');
    const bulkForceDeleteForm = document.getElementById('bulkForceDeleteForm');
    const bulkRestoreBtn = document.getElementById('bulkRestoreBtn');
    const bulkForceDeleteBtn = document.getElementById('bulkForceDeleteBtn');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const selectedCount = document.getElementById('selectedCount');

    // تحديث عداد المحددين وحالة الأزرار
    function updateUI() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const count = checkedBoxes.length;
        
        // تحديث العداد
        selectedCount.textContent = count + ' محدد';
        
        // تفعيل/إلغاء تفعيل الأزرار
        bulkRestoreBtn.disabled = count === 0;
        bulkForceDeleteBtn.disabled = count === 0;
        
        // تحديث حالة checkbox "تحديد الكل"
        if (count === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (count === userCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
        
        // تحديث hidden inputs للفورمين
        [bulkRestoreForm, bulkForceDeleteForm].forEach(form => {
            if (form) {
                // إزالة hidden inputs القديمة
                form.querySelectorAll('input[name="user_ids[]"]').forEach(input => input.remove());
                
                // إضافة hidden inputs جديدة
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_ids[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });
            }
        });
    }

    // checkbox "تحديد الكل"
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateUI();
        });
    }

    // checkboxes المستخدمين الفردية
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateUI);
    });

    // زر "تحديد الكل"
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateUI();
        });
    }

    // زر "إلغاء التحديد"
    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateUI();
        });
    }

    // تأكيد الاسترجاع الجماعي
    if (bulkRestoreForm) {
        bulkRestoreForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('يرجى تحديد مستخدم واحد على الأقل');
                return;
            }

            const count = checkedBoxes.length;
            const confirmed = confirm(`هل تريد استرجاع ${count} مستخدم؟\n\nسيتم إعادتهم للقائمة النشطة`);
            
            if (!confirmed) {
                e.preventDefault();
            }
        });
    }

    // تأكيد الحذف النهائي الجماعي
    if (bulkForceDeleteForm) {
        bulkForceDeleteForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('يرجى تحديد مستخدم واحد على الأقل');
                return;
            }

            const count = checkedBoxes.length;
            const confirmed = confirm(`⚠️ تحذير خطير!\n\nهل تريد حذف ${count} مستخدم نهائياً؟\n\nهذا الإجراء لا يمكن التراجع عنه وسيتم حذف جميع بياناتهم!`);
            
            if (!confirmed) {
                e.preventDefault();
            }
        });
    }

    // تأكيد الحذف النهائي الفردي
    const forceDeleteForms = document.querySelectorAll('form[action*="force-delete"]');
    forceDeleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const confirmed = confirm('⚠️ تحذير: هذا سيحذف المستخدم نهائياً مع جميع بياناته!\n\nهل أنت متأكد من المتابعة؟');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });

    // تحديث UI في البداية
    updateUI();
});
</script>
@endsection