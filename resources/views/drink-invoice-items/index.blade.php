@extends('layouts.app')

@section('title', 'عناصر فواتير المشروبات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"> عناصر فواتير المشروبات (للمشتركين شهري)</h1>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('drink-invoice-items.index') }}" class="row g-3">
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">من تاريخ</label>
                        <input type="date" class="form-control" name="date_from" id="date_from" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">إلى تاريخ</label>
                        <input type="date" class="form-control" name="date_to" id="date_to" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-3">
                        <label for="user_id" class="form-label">المستخدم</label>
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
                        <label for="drink_id" class="form-label">نوع المشروب</label>
                        <select class="form-select select2" name="drink_id" id="drink_id" data-placeholder="اختر المشروب أو ابحث...">
                            <option value="">جميع المشروبات</option>
                            @foreach($drinks as $drink)
                                <option value="{{ $drink->id }}" {{ request('drink_id') == $drink->id ? 'selected' : '' }}>
                                    {{ $drink->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i> بحث
                        </button>
                        <a href="{{ route('drink-invoice-items.index') }}" class="btn btn-secondary">
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
                    <h5 class="card-title mb-0">قائمة العناصر</h5>
                    <div class="text-muted">
                        <small>
                            <i class="bi bi-list-ul"></i>
                            إجمالي النتائج: <strong>{{ $items->total() }}</strong> عنصر
                            @if($items->count() < $items->total())
                                (عرض {{ $items->count() }} في هذه الصفحة)
                            @endif
                            | 
                            <i class="bi bi-currency-exchange"></i>
                            إجمالي المبيعات: <strong>₪{{ number_format($totalPrice, 2) }}</strong>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المشروب</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>رقم الفاتورة</th>
                                <th>المستخدم</th>
                                <th>تاريخ الإضافة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    @if($item->drink)
                                        {{ $item->drink->name }}
                                    @else
                                        <span class="text-muted">غير متوفر</span>
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>₪{{ number_format($item->price, 2) }}</td>
                                <td>
                                    @if($item->invoice)
                                        <a href="{{ route('drink-invoices.show', $item->invoice) }}" class="text-decoration-none">
                                            #{{ $item->invoice->id }}
                                        </a>
                                    @else
                                        <span class="text-muted">غير متوفر</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->invoice && $item->invoice->user)
                                        <a href="{{ route('users.show', $item->invoice->user) }}" class="text-decoration-none">
                                            {{ $item->invoice->user->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">غير متوفر</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $items->links() }}
                </div>
                @else
                <p class="text-muted text-center">لا توجد عناصر في هذا التاريخ</p>
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

    // Initialize Select2 for Drink dropdown
    $('#drink_id').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dir: 'rtl',
        language: 'ar',
        placeholder: 'اختر المشروب أو ابحث...',
        allowClear: true,
        minimumInputLength: 0,
        maximumResultsForSearch: 50,
        dropdownParent: $('body')
    });
});
</script>
@endsection

