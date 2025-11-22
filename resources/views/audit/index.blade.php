@extends('layouts.app')

@section('title', 'سجلات التدقيق')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-clock-history"></i>
        سجلات التدقيق
    </h1>
    <div>
        <a href="{{ route('audit.export', request()->query()) }}" class="btn btn-success">
            <i class="bi bi-download"></i> تصدير CSV
        </a>
    </div>
</div>

<!-- الإحصائيات -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ number_format($stats['total_logs']) }}</h4>
                        <p class="card-text">إجمالي السجلات</p>
                    </div>
                    <div>
                        <i class="bi bi-list-ul fs-1"></i>
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
                        <h4>{{ number_format($stats['today_logs']) }}</h4>
                        <p class="card-text">سجلات اليوم</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-day fs-1"></i>
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
                        <h4>{{ number_format($stats['this_week_logs']) }}</h4>
                        <p class="card-text">سجلات هذا الأسبوع</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-week fs-1"></i>
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
                        <h4>{{ number_format($stats['this_month_logs']) }}</h4>
                        <p class="card-text">سجلات هذا الشهر</p>
                    </div>
                    <div>
                        <i class="bi bi-calendar-month fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلاتر البحث -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-funnel"></i>
            فلاتر البحث
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('audit.index') }}" id="filterForm">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="session_id" class="form-label">الجلسة</label>
                    <select name="session_id" id="session_id" class="form-select">
                        <option value="">جميع الجلسات</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                الجلسة #{{ $session->id }}
                                @if($session->user)
                                    - {{ $session->user->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="user_id" class="form-label">المستخدم</label>
                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">جميع المستخدمين</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="action" class="form-label">نوع العملية</label>
                    <select name="action" id="action" class="form-select">
                        <option value="">جميع العمليات</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ $action }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="action_type" class="form-label">نوع العنصر</label>
                    <select name="action_type" id="action_type" class="form-select">
                        <option value="">جميع الأنواع</option>
                        @foreach($actionTypes as $actionType)
                            <option value="{{ $actionType }}" {{ request('action_type') == $actionType ? 'selected' : '' }}>
                                {{ $actionType }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="date_from" class="form-label">من تاريخ</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="date_to" class="form-label">إلى تاريخ</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="search" class="form-label">بحث في الوصف</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="ابحث في الوصف..." value="{{ request('search') }}">
                </div>
                
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <div class="w-100">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> بحث
                        </button>
                    </div>
                </div>
            </div>
            
            @if(request()->hasAny(['session_id', 'user_id', 'action', 'action_type', 'date_from', 'date_to', 'search']))
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('audit.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> إزالة الفلاتر
                    </a>
                </div>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- سجلات التدقيق -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul"></i>
            سجلات التدقيق ({{ $auditLogs->total() }} سجل)
        </h5>
    </div>
    <div class="card-body">
        @if($auditLogs->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>التاريخ والوقت</th>
                        <th>الجلسة</th>
                        <th>المستخدم</th>
                        <th>العملية</th>
                        <th>نوع العنصر</th>
                        <th>الوصف</th>
                        <th>عنوان IP</th>
                        <th>التفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auditLogs as $log)
                    <tr>
                        <td>
                            <div>{{ $log->created_at->format('Y-m-d') }}</div>
                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                        </td>
                        <td>
                            @if($log->session)
                                <a href="{{ route('sessions.show', $log->session) }}" class="text-decoration-none">
                                    <span class="text-primary fw-bold">#{{ $log->session->id }}</span>
                                    <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                                </a>
                            @else
                                <span class="text-muted">غير محدد</span>
                            @endif
                        </td>
                        <td>
                            @if($log->user)
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2"></i>
                                    {{ $log->user->name }}
                                </div>
                                <small class="text-muted">{{ $log->user->email }}</small>
                            @else
                                <span class="text-muted">غير محدد</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $actionColors = [
                                    'create' => 'success',
                                    'update' => 'warning',
                                    'delete' => 'danger',
                                    'add_drink' => 'info',
                                    'remove_drink' => 'danger',
                                    'toggle_payment' => 'primary',
                                    'update_internet_cost' => 'warning',
                                    'end_session' => 'secondary',
                                    'create_payment' => 'success',
                                    'update_payment' => 'warning',
                                    'full_bank_payment' => 'success',
                                ];
                                $color = $actionColors[$log->action] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">
                                {{ $log->getActionDisplayName() }}
                            </span>
                        </td>
                        <td>
                            @php
                                $typeColors = [
                                    'session' => 'primary',
                                    'payment' => 'success',
                                    'drink' => 'info',
                                    'internet_cost' => 'warning',
                                ];
                                $color = $typeColors[$log->action_type] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">
                                {{ $log->getActionTypeDisplayName() }}
                            </span>
                        </td>
                        <td>
                            <div>{{ $log->description }}</div>
                            @if($log->hasAuditChanges())
                                <small class="text-muted">{{ $log->getChangesSummary() }}</small>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $log->ip_address ?? 'غير محدد' }}</small>
                        </td>
                        <td>
                            @if($log->hasAuditChanges())
                                <button class="btn btn-sm btn-outline-info" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#changesModal{{ $log->id }}">
                                    <i class="bi bi-eye"></i> التفاصيل
                                </button>
                            @else
                                <span class="text-muted">لا توجد تغييرات</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $auditLogs->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-2">لا توجد سجلات تدقيق</p>
            @if(request()->hasAny(['session_id', 'user_id', 'action', 'action_type', 'date_from', 'date_to', 'search']))
                <a href="{{ route('audit.index') }}" class="btn btn-outline-primary mt-2">
                    <i class="bi bi-arrow-left"></i> عرض جميع السجلات
                </a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Modals للتفاصيل -->
@foreach($auditLogs as $log)
    @if($log->hasAuditChanges())
    <div class="modal fade" id="changesModal{{ $log->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-left-right"></i>
                        تفاصيل التغييرات
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger">
                                <i class="bi bi-dash-circle"></i>
                                القيم القديمة
                            </h6>
                            @if($log->old_values)
                                @php
                                    $oldValues = is_string($log->old_values) ? json_decode($log->old_values, true) : $log->old_values;
                                    $oldValues = is_array($oldValues) ? $oldValues : [];
                                @endphp
                                @if(!empty($oldValues))
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>الحقل</th>
                                                    <th>القيمة</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($oldValues as $field => $value)
                                                <tr>
                                                    <td><strong>{{ $field }}</strong></td>
                                                    <td>{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">لا توجد قيم قديمة</p>
                                @endif
                            @else
                                <p class="text-muted">لا توجد قيم قديمة</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">
                                <i class="bi bi-plus-circle"></i>
                                القيم الجديدة
                            </h6>
                            @if($log->new_values)
                                @php
                                    $newValues = is_string($log->new_values) ? json_decode($log->new_values, true) : $log->new_values;
                                    $newValues = is_array($newValues) ? $newValues : [];
                                @endphp
                                @if(!empty($newValues))
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>الحقل</th>
                                                    <th>القيمة</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($newValues as $field => $value)
                                                <tr>
                                                    <td><strong>{{ $field }}</strong></td>
                                                    <td>{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">لا توجد قيم جديدة</p>
                                @endif
                            @else
                                <p class="text-muted">لا توجد قيم جديدة</p>
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6>
                                <i class="bi bi-info-circle"></i>
                                معلومات إضافية
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>المستخدم:</strong> {{ $log->user->name ?? 'غير محدد' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>عنوان IP:</strong> {{ $log->ip_address ?? 'غير محدد' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>التاريخ:</strong> {{ $log->created_at->format('Y-m-d H:i:s') }}
                                </div>
                            </div>
                            @if($log->session)
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <strong>الجلسة:</strong> 
                                    <a href="{{ route('sessions.show', $log->session) }}" class="text-decoration-none">
                                        الجلسة #{{ $log->session->id }}
                                        <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection

