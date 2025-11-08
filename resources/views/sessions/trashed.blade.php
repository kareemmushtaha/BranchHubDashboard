@extends('layouts.app')

@section('title', 'الجلسات المحذوفة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-trash text-danger"></i>
        الجلسات المحذوفة
    </h1>
    <div>
        <a href="{{ route('sessions.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> العودة للجلسات
        </a>
    </div>
</div>

<!-- إحصائيات الجلسات المحذوفة -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_deleted'] }}</h4>
                        <p class="card-text">الجلسات المحذوفة</p>
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
                        <h4>{{ $stats['active_sessions'] }}</h4>
                        <p class="card-text">الجلسات النشطة</p>
                    </div>
                    <div>
                        <i class="bi bi-play-circle fs-1"></i>
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
                        <h4>{{ $stats['total_sessions'] }}</h4>
                        <p class="card-text">إجمالي الجلسات</p>
                    </div>
                    <div>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($trashedSessions->count() > 0)
<!-- أزرار العمليات الجماعية -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="mb-2">
                            <i class="bi bi-arrow-clockwise text-success"></i>
                            العمليات الجماعية للجلسات المحذوفة
                        </h6>
                        <small class="text-muted">حدد الجلسات واختر العملية المطلوبة</small>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check-all"></i> تحديد الكل
                            </button>
                            <button type="button" id="deselectAllBtn" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-square"></i> إلغاء التحديد
                            </button>
                            
                            <form id="bulkRestoreForm" action="{{ route('sessions.bulk-restore') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" id="bulkRestoreBtn" class="btn btn-sm btn-outline-success" disabled>
                                    <i class="bi bi-arrow-clockwise"></i> استرجاع المحددة
                                </button>
                            </form>
                            
                            <form id="bulkForceDeleteForm" action="{{ route('sessions.bulk-force-delete') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="bulkForceDeleteBtn" class="btn btn-sm btn-outline-danger" disabled>
                                    <i class="bi bi-x-circle"></i> حذف نهائي للمحددة
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

<!-- جدول الجلسات المحذوفة -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-list"></i>
            قائمة الجلسات المحذوفة
        </h5>
    </div>
    <div class="card-body">
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
                        <th>رقم الجلسة</th>
                        <th>المستخدم</th>

                        <th>الفئة</th>
                        <th>بداية الجلسة</th>
                        <th>نهاية الجلسة</th>
                        <th>تاريخ الحذف</th>
                        <th>التكلفة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedSessions as $session)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input session-checkbox" type="checkbox" 
                                       name="session_ids[]" value="{{ $session->id }}" 
                                       id="session_{{ $session->id }}">
                            </div>
                        </td>
                        <td>#{{ $session->id }}</td>
                        <td>{{ $session->user->name ?? 'غير محدد' }}</td>
                        
                        <td>
                            @if($session->session_category == 'hourly')
                                <span class="badge bg-info">ساعي</span>
                            
                            @else
                                <span class="badge bg-secondary">عادي</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <strong>{{ $session->start_at->format('Y-m-d') }}</strong><br>
                                <span class="text-muted">{{ $session->start_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($session->end_at)
                            <div class="small">
                                <strong>{{ $session->end_at->format('Y-m-d') }}</strong><br>
                                <span class="text-muted">{{ $session->end_at->format('H:i') }}</span>
                            </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="small text-danger">
                                <strong>{{ $session->deleted_at->format('Y-m-d') }}</strong><br>
                                <span class="text-muted">{{ $session->deleted_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($session->payment)
                                <strong class="text-success">${{ number_format($session->payment->total_price, 2) }}</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('sessions.show', $session) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                <form action="{{ route('sessions.restore', $session->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" 
                                            onclick="return confirm('هل تريد استرجاع هذه الجلسة؟')">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('sessions.force-delete', $session->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('هل تريد حذف هذه الجلسة نهائياً؟ هذا الإجراء لا يمكن التراجع عنه!')">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $trashedSessions->links() }}
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body">
        <div class="text-center py-5">
            <i class="bi bi-check-circle display-1 text-success"></i>
            <h5 class="mt-3">لا توجد جلسات محذوفة</h5>
            <p class="text-muted">جميع الجلسات متاحة حالياً</p>
            <a href="{{ route('sessions.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> العودة للجلسات
            </a>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const bulkRestoreBtn = document.getElementById('bulkRestoreBtn');
    const bulkForceDeleteBtn = document.getElementById('bulkForceDeleteBtn');
    const selectedCount = document.getElementById('selectedCount');
    const bulkRestoreForm = document.getElementById('bulkRestoreForm');
    const bulkForceDeleteForm = document.getElementById('bulkForceDeleteForm');

    function getSessionCheckboxes() {
        return document.querySelectorAll('.session-checkbox');
    }

    function updateSelectedCount() {
        const sessionCheckboxes = getSessionCheckboxes();
        const checkedBoxes = document.querySelectorAll('.session-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (selectedCount) {
            selectedCount.textContent = count + ' محدد';
        }
        
        if (bulkRestoreBtn) bulkRestoreBtn.disabled = count === 0;
        if (bulkForceDeleteBtn) bulkForceDeleteBtn.disabled = count === 0;
        
        // Update select all checkbox state
        if (selectAllCheckbox) {
            if (count === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (count === sessionCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }
    }

    function addCheckboxListeners() {
        const sessionCheckboxes = getSessionCheckboxes();
        sessionCheckboxes.forEach(checkbox => {
            checkbox.removeEventListener('change', updateSelectedCount); // Remove old listeners
            checkbox.addEventListener('change', updateSelectedCount);
        });
    }

    // Handle select all checkbox
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const sessionCheckboxes = getSessionCheckboxes();
            sessionCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });
    }

    // Handle select all button
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            const sessionCheckboxes = getSessionCheckboxes();
            sessionCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = true;
            }
            
            updateSelectedCount();
        });
    }

    // Handle deselect all button
    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function() {
            const sessionCheckboxes = getSessionCheckboxes();
            sessionCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = false;
            }
            
            updateSelectedCount();
        });
    }

    // Handle bulk restore form submission
    if (bulkRestoreForm) {
        bulkRestoreForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.session-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('يرجى تحديد جلسة واحدة على الأقل');
                return;
            }
            
            // Clear previous hidden inputs
            const existingInputs = this.querySelectorAll('input[name="session_ids[]"]');
            existingInputs.forEach(input => input.remove());
            
            // Add checked session IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'session_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
            
            if (!confirm(`هل تريد استرجاع ${checkedBoxes.length} جلسة؟`)) {
                e.preventDefault();
            }
        });
    }

    // Handle bulk force delete form submission
    if (bulkForceDeleteForm) {
        bulkForceDeleteForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.session-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('يرجى تحديد جلسة واحدة على الأقل');
                return;
            }
            
            // Clear previous hidden inputs
            const existingInputs = this.querySelectorAll('input[name="session_ids[]"]');
            existingInputs.forEach(input => input.remove());
            
            // Add checked session IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'session_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
            
            if (!confirm(`هل تريد حذف ${checkedBoxes.length} جلسة نهائياً؟ هذا الإجراء لا يمكن التراجع عنه!`)) {
                e.preventDefault();
            }
        });
    }

    // Initialize
    addCheckboxListeners();
    updateSelectedCount();
});
</script>
@endsection