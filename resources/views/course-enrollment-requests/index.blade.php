@extends('layouts.app')

@section('title', 'طلبات الالتحاق بالدورات')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
/* تحسين البطاقات */
.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #0d6efd, #0a58ca);
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
    border: none;
    padding: 1rem 1.5rem;
}

.table th {
    font-weight: 600;
    background-color: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
}

.table td {
    vertical-align: middle;
}

/* البادجات */
.badge {
    font-size: 0.8rem;
    padding: 0.45em 0.7em;
    border-radius: 0.5rem;
}

.badge-pending {
    background-color: #ffc107;
    color: #000;
}
.badge-confirmed {
    background-color: #198754;
    color: #fff;
}
.badge-cancelled {
    background-color: #dc3545;
    color: #fff;
}

/* أزرار الإجراءات */
.btn-sm {
    border-radius: 0.4rem;
    padding: 0.3rem 0.6rem;
    font-size: 0.8rem;
}
.btn-outline-secondary {
    color: #495057;
}

/* مودال التفاصيل */
#detailsModal .modal-content {
    border-radius: 1rem;
    border: none;
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}

#detailsModal .modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 1rem 1rem 0 0;
}

#detailsModal .modal-body {
    padding: 2rem;
}

/* تحسين البطاقات داخل المودال */
#detailsModal .card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.2s ease;
}

#detailsModal .card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

#detailsModal .card-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

#detailsModal .form-label {
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

#detailsModal .btn {
    border-radius: 0.5rem;
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}

/* تحسين الـ Spinner */
.spinner-border {
    width: 3rem;
    height: 3rem;
}

/* تحسين الـ Alert */
.alert {
    border-radius: 0.75rem;
    border: none;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

/* تحسين الـ Dropdown Menu */
.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.5rem;
    padding: 0.5rem 0;
    min-width: 160px;
    z-index: 1050;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    color: #495057;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #0d6efd;
}

.dropdown-item i {
    width: 16px;
    text-align: center;
}

/* تحسين أزرار الإجراءات */
.btn-group {
    position: relative;
}

.btn-group .dropdown-toggle::after {
    margin-right: 0.5rem;
}

/* تحسين الـ DataTables */
.dataTables_wrapper {
    direction: rtl;
}

.dataTables_filter {
    text-align: left;
    float: left;
}

.dataTables_length {
    text-align: right;
    float: right;
}

.dataTables_filter input {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    margin-right: 0.5rem;
}

.dataTables_length select {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.25rem 0.5rem;
    margin-right: 0.5rem;
}

/* تحسين الـ Pagination */
.dataTables_paginate {
    text-align: left;
    clear: both;
    padding-top: 1rem;
}

.dataTables_paginate .paginate_button {
    margin: 0 2px;
    padding: 0.5rem 0.75rem;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    color: #0d6efd;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
}

.dataTables_paginate .paginate_button:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #0d6efd;
}

.dataTables_paginate .paginate_button.current {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

/* تحسين أزرار التصدير */
.dt-buttons {
    margin-bottom: 1rem;
    text-align: center;
}

.dt-buttons .btn {
    margin: 0 0.25rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
}

/* تحسين المعلومات */
.dataTables_info {
    text-align: right;
    clear: both;
    padding-top: 0.5rem;
    color: #6c757d;
    font-size: 0.875rem;
}

/* بطاقات الإحصائيات */
.stat-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
}
</style>
@endsection

@section('content')
<div class="container-fluid py-3">
    {{-- بطاقات الإحصائيات --}}
    @php
        $totalRequests = \App\Models\CourseEnrollmentRequest::count();
        $pendingCount  = \App\Models\CourseEnrollmentRequest::where('status', 'pending')->count();
        $approvedCount = \App\Models\CourseEnrollmentRequest::where('status', 'approved')->count();
        $rejectedCount = \App\Models\CourseEnrollmentRequest::where('status', 'rejected')->count();
    @endphp
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card stat-card bg-primary bg-gradient text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-mortarboard fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $totalRequests }}</h5>
                        <small>إجمالي الطلبات</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-warning bg-gradient text-dark">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $pendingCount }}</h5>
                        <small>في الانتظار</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-success bg-gradient text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $approvedCount }}</h5>
                        <small>مقبول</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-danger bg-gradient text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $rejectedCount }}</h5>
                        <small>مرفوض</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول الطلبات --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-mortarboard me-2"></i> طلبات الالتحاق بالدورات
            </div>
            <span class="badge bg-light text-dark">
                إجمالي: {{ $enrollmentRequests->total() }}
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="enrollmentRequestsTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>الدورة</th>
                            <th>الحالة</th>
                            <th>ملاحظات</th>
                            <th>التاريخ</th>
                            <th class="text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollmentRequests as $index => $request)
                        <tr>
                            <td>{{ $enrollmentRequests->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width:35px;height:35px;font-size:0.85rem;">
                                        {{ mb_substr($request->name, 0, 1) }}
                                    </div>
                                    <strong>{{ $request->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $request->email }}" class="text-decoration-none">
                                    <i class="bi bi-envelope me-1"></i>{{ $request->email }}
                                </a>
                            </td>
                            <td>
                                <a href="tel:{{ $request->phone }}" class="text-decoration-none">
                                    <i class="bi bi-telephone me-1"></i>{{ $request->phone }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">{{ Str::limit($request->course_title, 30) }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $request->status_badge_class }}">
                                    {{ $request->status_arabic }}
                                </span>
                            </td>
                            <td>
                                @if($request->message)
                                    <span title="{{ $request->message }}">
                                        {{ Str::limit($request->message, 25) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $request->created_at->format('Y/m/d H:i') }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus({{ $request->id }}, 'pending')"><i class="bi bi-clock text-warning me-2"></i>انتظار</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus({{ $request->id }}, 'approved')"><i class="bi bi-check-circle text-success me-2"></i>قبول</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus({{ $request->id }}, 'rejected')"><i class="bi bi-x-circle text-danger me-2"></i>رفض</a></li>
                                    </ul>
                                    <button class="btn btn-sm btn-outline-info" onclick="viewDetails({{ $request->id }})"><i class="bi bi-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRequest({{ $request->id }})"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal تفاصيل الطلب -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-mortarboard me-2"></i>تفاصيل طلب الالتحاق</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                جاري التحميل...
            </div>
        </div>
    </div>
</div>

@section('scripts')
<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#enrollmentRequestsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json"
        },
        "responsive": true,
        "pageLength": 15,
        "lengthMenu": [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "الكل"]],
        "order": [[7, "desc"]],
        "columnDefs": [
            {
                "targets": [8],
                "orderable": false,
                "searchable": false,
                "width": "140px",
                "className": "text-center"
            },
            {
                "targets": [0],
                "width": "50px",
                "className": "text-center"
            },
            {
                "targets": [1],
                "width": "160px"
            },
            {
                "targets": [2],
                "width": "180px"
            },
            {
                "targets": [3],
                "width": "130px"
            },
            {
                "targets": [4],
                "width": "150px",
                "className": "text-center"
            },
            {
                "targets": [5],
                "width": "100px",
                "className": "text-center"
            },
            {
                "targets": [6],
                "width": "150px"
            },
            {
                "targets": [7],
                "width": "130px",
                "className": "text-center"
            }
        ],
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"B>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "buttons": [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-excel"></i> تصدير Excel',
                className: 'btn btn-success btn-sm me-1'
            },
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-pdf"></i> تصدير PDF',
                className: 'btn btn-danger btn-sm me-1'
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> طباعة',
                className: 'btn btn-info btn-sm me-1'
            }
        ],
        "initComplete": function() {
            $('.dataTables_wrapper').addClass('mt-3');
            $('.dataTables_filter input').addClass('form-control');
            $('.dataTables_length select').addClass('form-select');
            $('.dropdown-toggle').dropdown();
        },
        "drawCallback": function() {
            $('.dropdown-toggle').dropdown();
        }
    });
});

function updateStatus(id, status) {
    if (confirm('هل أنت متأكد من تحديث حالة الطلب؟')) {
        fetch(`/course-enrollment-requests/${id}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#detailsModal').modal('hide');
                location.reload();
            } else {
                alert('حدث خطأ أثناء تحديث الحالة');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث الحالة');
        });
    }
}

function deleteRequest(id) {
    if (confirm('هل أنت متأكد من حذف هذا الطلب؟')) {
        fetch(`/course-enrollment-requests/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء حذف الطلب');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الطلب');
        });
    }
}

function viewDetails(id) {
    $('#detailsContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">جاري التحميل...</span>
            </div>
            <p class="mt-2 text-muted">جاري تحميل تفاصيل الطلب...</p>
        </div>
    `);
    
    $('#detailsModal').modal('show');
    
    fetch(`/course-enrollment-requests/${id}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const req = data.data;
            $('#detailsContent').html(`
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-person-circle me-2"></i>معلومات المتقدم
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الاسم:</label>
                                    <p class="mb-0">${req.name}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                    <p class="mb-0">
                                        <a href="mailto:${req.email}" class="text-decoration-none">
                                            <i class="bi bi-envelope me-1"></i>${req.email}
                                        </a>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">
                                        <a href="tel:${req.phone}" class="text-decoration-none">
                                            <i class="bi bi-telephone me-1"></i>${req.phone}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-journal-bookmark me-2"></i>معلومات الدورة
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الدورة:</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info text-dark">${req.course_title}</span>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الحالة:</label>
                                    <p class="mb-0">
                                        <span class="badge ${req.status_badge_class}">${req.status_arabic}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-chat-text me-2"></i>الملاحظات
                                </h6>
                                <p class="mb-0">${req.message || 'لا توجد ملاحظات'}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-clock me-2"></i>معلومات الوقت
                                </h6>
                                <div class="mb-2">
                                    <label class="form-label fw-bold">تاريخ الإنشاء:</label>
                                    <p class="mb-0">${req.created_at}</p>
                                    <small class="text-muted">${req.created_at_human}</small>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold">آخر تحديث:</label>
                                    <p class="mb-0">${req.updated_at}</p>
                                    <small class="text-muted">${req.updated_at_human}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-gear me-2"></i>الإجراءات السريعة
                                </h6>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-warning btn-sm" onclick="updateStatus(${req.id}, 'pending')">
                                        <i class="bi bi-clock me-1"></i>وضع في الانتظار
                                    </button>
                                    <button class="btn btn-outline-success btn-sm" onclick="updateStatus(${req.id}, 'approved')">
                                        <i class="bi bi-check-circle me-1"></i>قبول الطلب
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="updateStatus(${req.id}, 'rejected')">
                                        <i class="bi bi-x-circle me-1"></i>رفض الطلب
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        } else {
            $('#detailsContent').html(`
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    حدث خطأ أثناء تحميل تفاصيل الطلب
                </div>
            `);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        $('#detailsContent').html(`
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle me-2"></i>
                حدث خطأ أثناء تحميل تفاصيل الطلب
            </div>
        `);
    });
}
</script>
@endsection
@endsection
