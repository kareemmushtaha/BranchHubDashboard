@extends('layouts.app')

@section('title', 'تعديل الجلسة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تعديل الجلسة</h1>
    <div>
        <a href="{{ route('sessions.show', $session) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">بيانات الجلسة</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sessions.update', $session) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">المستخدم</label>
                            <select class="form-select select2 @error('user_id') is-invalid @enderror" 
                                    id="user_id" name="user_id" required 
                                    data-placeholder="اختر المستخدم أو ابحث...">
                                <option value=""></option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $session->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="bi bi-info-circle"></i> 
                                اكتب للبحث أو اضغط <kbd>Ctrl+U</kbd> للفتح السريع
                            </small>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="session_category" class="form-label">فئة الجلسة</label>
                            <select class="form-select @error('session_category') is-invalid @enderror" 
                                    id="session_category" name="session_category" required>
                                <option value="">اختر الفئة</option>
                                <option value="hourly" {{ old('session_category', $session->session_category) == 'hourly' ? 'selected' : '' }}>ساعي</option>

                                <option value="subscription" {{ old('session_category', $session->session_category) == 'subscription' ? 'selected' : '' }}>اشتراك</option>
                            </select>
                            @error('session_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="session_owner" class="form-label">صاحب الجلسة</label>
                            <input type="text" class="form-control @error('session_owner') is-invalid @enderror" 
                                   id="session_owner" name="session_owner" value="{{ old('session_owner', $session->session_owner) }}" 
                                   placeholder="اسم صاحب الجلسة (اختياري)">
                            @error('session_owner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="note" class="form-label">ملاحظات</label>
                            <input type="text" class="form-control @error('note') is-invalid @enderror" 
                                   id="note" name="note" value="{{ old('note', $session->note) }}" 
                                   placeholder="ملاحظات إضافية (اختياري)">
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    @if($session->session_category == 'hourly')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="custom_internet_cost" class="form-label">تكلفة الإنترنت المخصصة</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('custom_internet_cost') is-invalid @enderror" 
                                       id="custom_internet_cost" 
                                       name="custom_internet_cost" 
                                       value="{{ old('custom_internet_cost', $session->custom_internet_cost) }}" 
                                       placeholder="0.00">
                            </div>
                            <small class="form-text text-muted">
                                اترك الحقل فارغاً لاستخدام الحساب التلقائي
                                @if($session->hasCustomInternetCost())
                                    <br><span class="text-warning">هناك تكلفة مخصصة حالياً</span>
                                @endif
                            </small>
                            @error('custom_internet_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('sessions.show', $session) }}" class="btn btn-secondary me-md-2">إلغاء</a>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات الجلسة</h5>
            </div>
            <div class="card-body">
                <p><strong>بداية الجلسة:</strong><br>{{ $session->start_at->format('Y-m-d H:i:s') }}</p>
                @if($session->end_at)
                <p><strong>نهاية الجلسة:</strong><br>{{ $session->end_at->format('Y-m-d H:i:s') }}</p>
                @endif
                <p><strong>المدة:</strong><br>
                    @if($session->end_at)
                        {{ $session->start_at->diffForHumans($session->end_at, true) }}
                    @else
                        {{ $session->start_at->diffForHumans(now(), true) }}
                    @endif
                </p>
                <p><strong>الحالة:</strong><br>
                    @if($session->session_status == 'active')
                        <span class="badge bg-success">نشطة</span>
                    @elseif($session->session_status == 'completed')
                        <span class="badge bg-info">مكتملة</span>
                    @else
                        <span class="badge bg-warning">ملغاة</span>
                    @endif
                </p>
                <p><strong>فئة الجلسة:</strong><br>
                    @switch($session->session_category)
                        @case('hourly')
                            <span class="badge bg-primary">ساعي</span>
                            @break

                        @case('subscription')
                            <span class="badge bg-info">اشتراك</span>
                            @break
                    @endswitch
                </p>
                
                @if($session->note)
                <p><strong>ملاحظات:</strong><br>{{ $session->note }}</p>
                @endif
                
                <hr>
                
                <h6>إحصائيات الجلسة:</h6>
                @php
                    $drinksStats = $session->getDrinksStats();
                @endphp
                <ul class="list-unstyled small">
                    <li><i class="bi bi-cup-straw"></i> المشروبات: {{ $drinksStats['total_count'] }}</li>
                    <li><i class="bi bi-currency-dollar"></i> تكلفة المشروبات: ${{ number_format($drinksStats['total_cost'], 2) }}</li>
                    <li><i class="bi bi-wifi"></i> تكلفة الإنترنت: ${{ number_format($session->calculateInternetCost(), 2) }}</li>
                    <li><i class="bi bi-calculator"></i> الإجمالي: ${{ number_format($drinksStats['total_cost'] + $session->calculateInternetCost(), 2) }}</li>
                </ul>
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
    // تهيئة Select2 للمستخدمين
    $('#user_id').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dir: 'rtl',
        language: 'ar',
        placeholder: 'اختر المستخدم أو ابحث...',
        allowClear: true,
        minimumInputLength: 0,
        maximumResultsForSearch: 50,
        templateResult: formatUser,
        templateSelection: formatUserSelection,
        dropdownParent: $('body')
    });

    // تنسيق عرض المستخدمين في القائمة
    function formatUser(user) {
        if (!user.id) return user.text;
        const parts = user.text.split(' - ');
        const name = parts[0];
        const email = parts[1] || '';
        
        return $(`
            <div class="d-flex align-items-center py-1">
                <div class="flex-grow-1">
                    <div class="fw-bold text-primary">${name}</div>
                    ${email ? `<small class="text-muted"><i class="bi bi-envelope"></i> ${email}</small>` : ''}
                </div>
                <div class="ms-2">
                    <i class="bi bi-person-circle text-secondary"></i>
                </div>
            </div>
        `);
    }

    // تنسيق عرض المستخدم المختار
    function formatUserSelection(user) {
        if (!user.id) return user.text;
        return user.text.split(' - ')[0];
    }

    // البحث السريع بالكيبورد
    $('#user_id').on('keydown', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            const searchTerm = $(this).val();
            if (searchTerm.length > 0) {
                const options = $(this).find('option');
                let found = false;
                
                options.each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.includes(searchTerm.toLowerCase())) {
                        $(this).prop('selected', true);
                        $('#user_id').trigger('change');
                        found = true;
                        return false;
                    }
                });
                
                if (!found) {
                    const firstOption = options.not('[value=""]').first();
                    if (firstOption.length > 0) {
                        firstOption.prop('selected', true);
                        $('#user_id').trigger('change');
                    }
                }
            }
        }
    });

    // إضافة اختصار للبحث السريع
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.keyCode === 85) {
            e.preventDefault();
            $('#user_id').select2('open');
        }
    });
});
</script>
@endsection