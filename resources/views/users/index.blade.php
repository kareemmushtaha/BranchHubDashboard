@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

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
    <h1 class="h2">{{ $pageTitle ?? 'إدارة المستخدمين' }}</h1>
    <div>
        <a href="{{ route('users.trashed') }}" class="btn btn-outline-danger me-2">
            <i class="bi bi-trash"></i> المستخدمين المحذوفين
        </a>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة مستخدم جديد
        </a>
    </div>
</div>

<!-- إحصائيات المستخدمين -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_users'] }}</h4>
                        <p class="card-text">إجمالي المستخدمين</p>
                    </div>
                    <div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['active_users'] }}</h4>
                        <p class="card-text">مستخدمين نشطين</p>
                    </div>
                    <div>
                        <i class="bi bi-person-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['hourly_users'] }}</h4>
                        <p class="card-text">مستخدمين ساعيين</p>
                    </div>
                    <div>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['subscription_users'] }}</h4>
                        <p class="card-text">مستخدمين اشتراك</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['manager_users'] }}</h4>
                        <p class="card-text">مديرين إداريين</p>
                    </div>
                    <div>
                        <i class="bi bi-shield-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['admin_users'] }}</h4>
                        <p class="card-text">مديرو النظام</p>
                    </div>
                    <div>
                        <i class="bi bi-person-gear fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلاتر البحث والفلترة -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-search text-primary"></i>
                    البحث والفلترة
                    <span id="filterLoading" class="spinner-border spinner-border-sm text-primary ms-2" style="display: none;" role="status">
                        <span class="visually-hidden">جاري التحميل...</span>
                    </span>
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ $userTypeFilter == 'subscription' ? route('users.monthly') : ($userTypeFilter == 'hourly' ? route('users.hourly') : route('users.index')) }}" id="filterForm" autocomplete="off">
                    <div class="row g-3 align-items-end">
                        <!-- البحث -->
                        <div class="col-md-3">
                            <label class="form-label">البحث</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="اسم، إيميل، أو هاتف" 
                                       value="{{ request('search') }}"
                                       autocomplete="off">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                            </div>
                            <small class="text-muted">البحث بعد الانتهاء من الكتابة</small>
                        </div>
                        
                        <!-- فلترة نوع المستخدم -->
                        @if(!isset($userTypeFilter))
                        <div class="col-md-2">
                            <label class="form-label">نوع المستخدم</label>
                            <select name="user_type" class="form-select">
                                <option value="">الكل</option>
                                <option value="hourly" {{ request('user_type') == 'hourly' ? 'selected' : '' }}>ساعي</option>
                                <option value="subscription" {{ request('user_type') == 'subscription' ? 'selected' : '' }}>اشتراك</option>
                                <option value="manager" {{ request('user_type') == 'manager' ? 'selected' : '' }}>مدير إداري</option>
                                <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>مدير النظام</option>
                            </select>
                            <small class="text-muted">فلترة فورية</small>
                        </div>
                        @else
                        <input type="hidden" name="user_type" value="{{ $userTypeFilter }}">
                        @endif
                        
                        <!-- فلترة الحالة -->
                        <div class="col-md-2">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">الكل</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>معلق</option>
                            </select>
                            <small class="text-muted">فلترة فورية</small>
                        </div>
                        
                        <!-- ترتيب -->
                        <div class="col-md-2">
                            <label class="form-label">ترتيب حسب</label>
                            <select name="sort_by" class="form-select">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>تاريخ التسجيل</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>الاسم</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>الإيميل</option>
                                <option value="user_type" {{ request('sort_by') == 'user_type' ? 'selected' : '' }}>النوع</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>الحالة</option>
                            </select>
                            <small class="text-muted">ترتيب فوري</small>
                        </div>
                        
                        <!-- اتجاه الترتيب -->
                        <div class="col-md-2">
                            <label class="form-label">الاتجاه</label>
                            <select name="sort_direction" class="form-select">
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>↓</option>
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>↑</option>
                            </select>
                            <small class="text-muted">ترتيب فوري</small>
                        </div>
                        
                        <!-- أزرار -->
                        <div class="col-md-2">
                            <div class="d-flex gap-1">
                                <a href="{{ $userTypeFilter == 'subscription' ? route('users.monthly') : ($userTypeFilter == 'hourly' ? route('users.hourly') : route('users.index')) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-x-circle"></i> مسح الفلاتر
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- أزرار العمليات الجماعية -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="mb-2">
                            <i class="bi bi-check-square text-primary"></i>
                            العمليات الجماعية
                        </h6>
                        <small class="text-muted">حدد المستخدمين واختر العملية المطلوبة</small>
                    </div>
                    <div class="col-md-6">
                        <form id="bulkActionsForm" action="{{ route('users.bulk-destroy') }}" method="POST" class="d-inline">
                            @csrf
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-check-all"></i> تحديد الكل
                                </button>
                                <button type="button" id="deselectAllBtn" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-x-square"></i> إلغاء التحديد
                                </button>
                                <button type="submit" id="bulkDeleteBtn" class="btn btn-sm btn-outline-danger" disabled>
                                    <i class="bi bi-trash"></i> حذف المحددين
                                </button>
                                <span class="badge bg-info" id="selectedCount">0 محدد</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- جدول المستخدمين -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة المستخدمين</h5>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
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
                        <th>الاسم بالانجليزي</th>
                        <th>الاسم بالعربي</th>
                        <th>نوع المستخدم</th>
                        <th>الحالة</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input user-checkbox" type="checkbox" 
                                       name="user_ids[]" value="{{ $user->id }}" 
                                       id="user_{{ $user->id }}">
                            </div>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @php
                                $typeInfo = $userTypeBadges[$user->user_type] ?? ['label' => 'غير معروف', 'class' => 'bg-secondary'];
                            @endphp
                            <span class="badge {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
                        </td>
                        <td>
                            @if($user->status == 'active')
                                <span class="badge bg-success">نشط</span>
                            @elseif($user->status == 'inactive')
                                <span class="badge bg-secondary">غير نشط</span>
                            @else
                                <span class="badge bg-danger">معلق</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#chargeWalletModal{{ $user->id }}" 
                                        title="شحن المحفظة">
                                    <i class="bi bi-wallet"></i>
                                </button>
                                <a href="{{ route('users.wallet-history', $user) }}" class="btn btn-sm btn-outline-info" 
                                   title="تاريخ المحفظة">
                                    <i class="bi bi-clock-history"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('هل تريد حذف هذا المستخدم؟\n\nملاحظة: سيتم الحذف المؤقت ويمكن استرجاعه لاحقاً')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal شحن المحفظة -->
                    <div class="modal fade" id="chargeWalletModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">شحن محفظة {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('users.charge-wallet', $user) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">الرصيد الحالي</label>
                                            <input type="text" class="form-control" value="${{ number_format($user->wallet->balance ?? 0, 2) }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="amount{{ $user->id }}" class="form-label">مبلغ الشحن</label>
                                            <input type="number" step="0.01" class="form-control" id="amount{{ $user->id }}" name="amount" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="payment_method{{ $user->id }}" class="form-label">طريقة الدفع</label>
                                            <select class="form-select" id="payment_method{{ $user->id }}" name="payment_method" required>
                                                <option value="">اختر طريقة الدفع</option>
                                                <option value="cash">💵 كاش</option>
                                                <option value="bank_transfer">🏦 حوالة بنكية</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="notes{{ $user->id }}" class="form-label">ملاحظات <small class="text-muted">(اختياري)</small></label>
                                            <textarea class="form-control" id="notes{{ $user->id }}" name="notes" rows="3" 
                                                      placeholder="أضف ملاحظة حول هذه العملية..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-success">شحن المحفظة</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- معلومات النتائج والتحكم في عدد العناصر -->
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
                        <select name="per_page" class="form-select form-select-sm" style="width: auto;">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>
                    <span class="ms-2 text-muted">عنصر في الصفحة</span>
                </div>
            </div>
            
            <div class="col-md-4 text-center">
                <div class="text-muted">
                    @if($users->total() > 0)
                        عرض {{ $users->firstItem() }} إلى {{ $users->lastItem() }} 
                        من أصل {{ number_format($users->total()) }} 
                        @if(request()->hasAny(['search', 'user_type', 'status']))
                            <small class="text-primary">(مفلتر من {{ number_format($stats['total_users']) }} إجمالي)</small>
                        @endif
                    @else
                        لا توجد نتائج
                    @endif
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="d-flex justify-content-end">
                    {{ $users->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-people display-1 text-muted"></i>
            <h5 class="mt-3">لا يوجد مستخدمين</h5>
            <p class="text-muted">ابدأ بإضافة مستخدم جديد</p>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> إضافة مستخدم جديد
            </a>
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // عناصر الفلترة التلقائية
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.querySelector('input[name="search"]');
    const userTypeSelect = document.querySelector('select[name="user_type"]');
    const statusSelect = document.querySelector('select[name="status"]');
    const sortBySelect = document.querySelector('select[name="sort_by"]');
    const sortDirectionSelect = document.querySelector('select[name="sort_direction"]');
    const perPageSelect = document.querySelector('select[name="per_page"]');
    
    // متغير لتأخير البحث
    let searchTimeout;
    
    // دالة إظهار مؤشر التحميل
    function showLoading() {
        const loadingIndicator = document.getElementById('filterLoading');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'inline-block';
        }
    }
    
    // دالة تطبيق الفلترة
    function applyFilters() {
        // إزالة التأخير السابق إذا وجد
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        
        // إظهار مؤشر التحميل
        showLoading();
        
        // تطبيق الفلترة فوراً
        filterForm.submit();
    }
    
    // دالة تطبيق الفلترة مع تأخير للبحث النصي
    function applyFiltersWithDelay() {
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        
        searchTimeout = setTimeout(() => {
            // إظهار مؤشر التحميل
            showLoading();
            filterForm.submit();
        }, 1500); // تأخير 1.5 ثانية بعد الانتهاء من الكتابة
    }
    
    // مراقبة التغييرات في حقول الفلترة
    if (searchInput) {
        // البحث مع تأخير أثناء الكتابة
        searchInput.addEventListener('input', applyFiltersWithDelay);
        
        // البحث فوراً عند الضغط على Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                // إلغاء التأخير والبحث فوراً
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                showLoading();
                filterForm.submit();
            }
        });
        
        // البحث فوراً عند فقدان التركيز (blur)
        searchInput.addEventListener('blur', function() {
            // إلغاء التأخير والبحث فوراً
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            showLoading();
            filterForm.submit();
        });
    }
    
    if (userTypeSelect) {
        userTypeSelect.addEventListener('change', applyFilters);
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', applyFilters);
    }
    
    if (sortBySelect) {
        sortBySelect.addEventListener('change', applyFilters);
    }
    
    if (sortDirectionSelect) {
        sortDirectionSelect.addEventListener('change', applyFilters);
    }
    
    if (perPageSelect) {
        perPageSelect.addEventListener('change', applyFilters);
    }
    
    // عناصر العمليات الجماعية
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActionsForm = document.getElementById('bulkActionsForm');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const selectedCount = document.getElementById('selectedCount');

    // تحديث عداد المحددين وحالة الأزرار
    function updateUI() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const count = checkedBoxes.length;
        
        // تحديث العداد
        selectedCount.textContent = count + ' محدد';
        
        // تفعيل/إلغاء تفعيل زر الحذف الجماعي
        bulkDeleteBtn.disabled = count === 0;
        
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
        
        // إضافة/إزالة IDs من الفورم
        const formData = new FormData(bulkActionsForm);
        formData.delete('user_ids[]');
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'user_ids[]';
            input.value = checkbox.value;
            
            // إزالة أي input مخفي موجود للمستخدم
            const existingInput = bulkActionsForm.querySelector(`input[value="${checkbox.value}"]`);
            if (existingInput && existingInput !== checkbox) {
                existingInput.remove();
            }
            
            bulkActionsForm.appendChild(input);
        });
    }

    // checkbox "تحديد الكل"
    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateUI();
    });

    // checkboxes المستخدمين الفردية
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateUI);
    });

    // زر "تحديد الكل"
    selectAllBtn.addEventListener('click', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateUI();
    });

    // زر "إلغاء التحديد"
    deselectAllBtn.addEventListener('click', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateUI();
    });

    // تأكيد الحذف الجماعي
    bulkActionsForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('يرجى تحديد مستخدم واحد على الأقل');
            return;
        }

        const count = checkedBoxes.length;
        const confirmed = confirm(`هل تريد حذف ${count} مستخدم؟\n\nملاحظة: سيتم الحذف المؤقت ويمكن استرجاعهم لاحقاً`);
        
        if (!confirmed) {
            e.preventDefault();
        }
    });

    // تحديث UI في البداية
    updateUI();
});
</script>
@endsection