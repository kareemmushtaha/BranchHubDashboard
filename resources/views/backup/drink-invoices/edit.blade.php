@extends('layouts.app')

@section('title', 'تعديل فاتورة المشروبات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تعديل فاتورة المشروبات #{{ $drinkInvoice->id }}</h1>
    <div>
        <a href="{{ route('drink-invoices.show', $drinkInvoice) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات الدفع</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('drink-invoices.update', $drinkInvoice) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">المستخدم:</label>
                        <div class="form-control-plaintext">{{ $drinkInvoice->user->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">إجمالي المبلغ:</label>
                        <div class="form-control-plaintext fw-bold text-primary">₪{{ number_format($drinkInvoice->total_price, 2) }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="amount_bank" class="form-label">المدفوع بنك</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('amount_bank') is-invalid @enderror" 
                               id="amount_bank" name="amount_bank" value="{{ old('amount_bank', $drinkInvoice->amount_bank) }}">
                        @error('amount_bank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount_cash" class="form-label">المدفوع نقد</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('amount_cash') is-invalid @enderror" 
                               id="amount_cash" name="amount_cash" value="{{ old('amount_cash', $drinkInvoice->amount_cash) }}">
                        @error('amount_cash')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">حالة الدفع</label>
                        <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                            <option value="pending" {{ old('payment_status', $drinkInvoice->payment_status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="paid" {{ old('payment_status', $drinkInvoice->payment_status) == 'paid' ? 'selected' : '' }}>مدفوع</option>
                            <option value="partial" {{ old('payment_status', $drinkInvoice->payment_status) == 'partial' ? 'selected' : '' }}>مدفوع جزئياً</option>
                            <option value="cancelled" {{ old('payment_status', $drinkInvoice->payment_status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">ملاحظات</label>
                        <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $drinkInvoice->note) }}</textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

