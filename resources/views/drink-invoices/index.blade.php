@extends('layouts.app')

@section('title', 'فواتير المشروبات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">فواتير المشروبات</h1>
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
                <form method="GET" action="{{ route('drink-invoices.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" placeholder="بحث..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="payment_status">
                            <option value="">جميع الحالات</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                            <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>مدفوع جزئياً</option>
                            <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> بحث
                        </button>
                        <a href="{{ route('drink-invoices.index') }}" class="btn btn-secondary">
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
            <div class="card-body">
                @if($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>المستخدم</th>
                                <th>إجمالي المبلغ</th>
                                <th>حالة الدفع</th>
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
                                    @if($invoice->user)
                                        <a href="{{ route('users.show', $invoice->user) }}" class="text-decoration-none">
                                            {{ $invoice->user->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">مستخدم محذوف</span>
                                    @endif
                                </td>
                                <td>₪{{ number_format($invoice->total_price, 2) }}</td>
                                <td>
                                    @if($invoice->payment_status == 'pending')
                                        <span class="badge bg-warning">قيد الانتظار</span>
                                    @elseif($invoice->payment_status == 'paid')
                                        <span class="badge bg-success">مدفوع</span>
                                    @elseif($invoice->payment_status == 'partial')
                                        <span class="badge bg-info">مدفوع جزئياً</span>
                                    @else
                                        <span class="badge bg-danger">ملغي</span>
                                    @endif
                                </td>
                                <td class="{{ $invoice->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">
                                    ₪{{ number_format($invoice->remaining_amount, 2) }}
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
                <p class="text-muted text-center">لا توجد فواتير</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

