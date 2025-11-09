@extends('layouts.app')

@section('title', 'سجلات التدقيق - الجلسة #' . $session->id)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-clock-history"></i>
        سجلات التدقيق - الجلسة #{{ $session->id }}
    </h1>
    <div>
        <a href="{{ route('sessions.show', $session) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة للجلسة
        </a>
        <a href="{{ route('audit.export') }}?session_id={{ $session->id }}" class="btn btn-success">
            <i class="bi bi-download"></i> تصدير CSV
        </a>
    </div>
</div>

<!-- معلومات الجلسة -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-info-circle"></i>
            معلومات الجلسة
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <strong>المستخدم:</strong> 
                @if($session->user)
                    <a href="{{ route('users.show', $session->user) }}" class="text-decoration-none">
                        <span class="text-primary fw-bold">{{ $session->user->name }}</span>
                        <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                    </a>
                @else
                    <span class="text-muted">غير محدد</span>
                @endif
            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">
                <strong>الحالة:</strong>
                @if($session->session_status == 'active')
                    <span class="badge bg-success">نشط</span>
                @elseif($session->session_status == 'completed')
                    <span class="badge bg-primary">مكتمل</span>
                @else
                    <span class="badge bg-danger">ملغي</span>
                @endif
            </div>
            <div class="col-md-3">
                <strong>تاريخ البداية:</strong> {{ $session->start_at->format('Y-m-d H:i') }}
            </div>
        </div>
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
            {{ $auditLogs->links() }}
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-2">لا توجد سجلات تدقيق لهذه الجلسة</p>
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
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>الحقل</th>
                                                <th>القيمة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($log->old_values as $field => $value)
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
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">
                                <i class="bi bi-plus-circle"></i>
                                القيم الجديدة
                            </h6>
                            @if($log->new_values)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>الحقل</th>
                                                <th>القيمة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($log->new_values as $field => $value)
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