@extends('layouts.app')

@section('title', 'الفواتير المعلقة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">الفواتير المعلقة</h1>
    <div>
        <a href="{{ route('drink-invoices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إنشاء فاتورة جديدة
        </a>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('drink-invoices.pending') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" placeholder="بحث..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select select2" name="user_id" id="user_id" data-placeholder="اختر المستخدم أو ابحث...">
                            <option value="">جميع المستخدمين</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> بحث
                        </button>
                        <a href="{{ route('drink-invoices.pending') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> إعادة تعيين
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">قائمة الفواتير المعلقة</h5>
                    <div class="text-muted">
                        <small>
                            <i class="bi bi-list-ul"></i>
                            إجمالي النتائج: <strong>{{ $invoices->total() }}</strong> فاتورة
                            @if($invoices->count() < $invoices->total())
                                (عرض {{ $invoices->count() }} في هذه الصفحة)
                            @endif
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>المستخدم</th>
                                <th>إجمالي المبلغ</th>
                                <th>المتبقي</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>#{{ $invoice->id }}</td>
                                <td>
                                    <a href="{{ route('users.show', $invoice->user) }}" class="text-decoration-none">
                                        {{ $invoice->user->name }}
                                    </a>
                                </td>
                                <td>₪{{ number_format($invoice->total_price, 2) }}</td>
                                <td class="text-danger">
                                    <strong>₪{{ number_format($invoice->remaining_amount, 2) }}</strong>
                                </td>
                                <td>{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('drink-invoices.show', $invoice) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @can('edit drink invoices')
                                        <a href="{{ route('drink-invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @endcan
                                        @can('delete drink invoices')
                                        <form action="{{ route('drink-invoices.destroy', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذه الفاتورة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $invoices->links() }}
                </div>
                @else
                <p class="text-muted text-center">لا توجد فواتير معلقة</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for User dropdown
    $('#user_id').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dir: 'rtl',
        language: 'ar',
        placeholder: 'اختر المستخدم أو ابحث...',
        allowClear: true,
        minimumInputLength: 0,
        maximumResultsForSearch: 50,
        dropdownParent: $('body')
    });
});
</script>
@endsection

