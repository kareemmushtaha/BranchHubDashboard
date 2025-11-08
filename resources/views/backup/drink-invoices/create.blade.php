@extends('layouts.app')

@section('title', 'إنشاء فاتورة مشروبات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إنشاء فاتورة مشروبات جديدة</h1>
    <div>
        @if($user)
            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> العودة
            </a>
        @else
            <a href="{{ route('drink-invoices.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> العودة
            </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات الفاتورة</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('drink-invoices.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="user_id" class="form-label">المستخدم <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">اختر المستخدم</option>
                            @if($user)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @else
                                @foreach(\App\Models\User::where('status', 'active')->get() as $u)
                                    <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">ملاحظات</label>
                        <textarea class="form-control" id="note" name="note" rows="3">{{ old('note') }}</textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> إنشاء الفاتورة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

