@extends('layouts.app')

@section('title', 'بدء جلسة جديدة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">بدء جلسة جديدة</h1>
    <div>
        <a href="{{ route('sessions.index') }}" class="btn btn-secondary">
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
                <form action="{{ route('sessions.store') }}" method="POST">
                    @csrf
                    <div class="row">
                    <div class="col-md-6 mb-3">
                            <label for="session_category" class="form-label">فئة الجلسة</label>
                            <select class="form-select @error('session_category') is-invalid @enderror"
                                    id="session_category" name="session_category" required>
                                <option value="">اختر الفئة</option>
                                <option value="hourly"  selected >ساعي</option>

                                <option value="subscription" {{ old('session_category') == 'subscription' ? 'selected' : '' }}>اشتراك</option>
                                <option value="overtime" {{ old('session_category') == 'overtime' ? 'selected' : '' }}>وقت إضافي</option>
                            </select>
                            @error('session_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">المستخدم</label>
                            @if($users->count() > 0)
                                <select class="form-select select2 @error('user_id') is-invalid @enderror"
                                        id="user_id" name="user_id" required
                                        data-placeholder="اختر المستخدم أو ابحث...">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            data-user-type="{{ $user->user_type }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                        <span class="badge bg-{{ in_array($user->user_type, ['hourly', 'prepaid']) ? 'info' : 'success' }} ms-2">
                                            {{ $user->user_type == 'hourly' ? 'ساعي' : ($user->user_type == 'prepaid' ? 'مسبق الدفع' : 'اشتراك') }}
                                        </span>
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle"></i>
                                    اكتب للبحث أو اضغط  للفتح السريع
                                </small>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <strong>لا يوجد مستخدمين متاحين!</strong><br>
                                    <small class="text-muted">
                                        المستخدمين المؤهلين لبدء جلسة جديدة يجب أن يكونوا:
                                        <ul class="mb-0 mt-1">
                                            <li>نوع المستخدم: <span class="badge bg-info">ساعي</span> أو <span class="badge bg-success">اشتراك</span></li>
                                            <li>لا يكون لديهم جلسة نشطة حالياً</li>
                                        </ul>
                                    </small>
                                </div>
                            @endif
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="session_owner" class="form-label">صاحب الجلسة</label>
                            <input type="text" class="form-control @error('session_owner') is-invalid @enderror"
                                   id="session_owner" name="session_owner" value="{{ old('session_owner') }}"
                                   placeholder="اسم صاحب الجلسة (اختياري)">
                            @error('session_owner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="note" class="form-label">ملاحظات</label>
                            <input type="text" class="form-control @error('note') is-invalid @enderror"
                                   id="note" name="note" value="{{ old('note') }}"
                                   placeholder="ملاحظات إضافية (اختياري)">
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('sessions.index') }}" class="btn btn-secondary me-md-2">إلغاء</a>
                        <button type="submit" class="btn btn-primary" {{ $users->count() == 0 ? 'disabled' : '' }}>
                            <i class="bi bi-play-circle"></i> بدء الجلسة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات مهمة</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-info-circle text-info"></i> سيتم بدء الجلسة فوراً</li>
                    <li><i class="bi bi-clock text-primary"></i> يمكن إضافة المشروبات لاحقاً</li>
                    <li><i class="bi bi-calculator text-success"></i> سيتم حساب التكلفة عند الإنهاء</li>
                    <li><i class="bi bi-pencil text-warning"></i> يمكن تعديل الجلسة قبل الإنهاء</li>
                </ul>

                <hr>

                <h6>متطلبات المستخدم:</h6>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-check-circle text-success"></i> نوع المستخدم: <span class="badge bg-info">ساعي</span> أو <span class="badge bg-success">اشتراك</span></li>
                    <li><i class="bi bi-check-circle text-success"></i> لا يكون لديه جلسة نشطة حالياً</li>
                    <li><i class="bi bi-check-circle text-success"></i> حالة المستخدم: نشط</li>
                </ul>

                <h6>قواعد التصفية:</h6>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-funnel text-primary"></i> <strong>ساعي:</strong> يظهر المستخدمين من نوع <span class="badge bg-info">ساعي</span> فقط</li>
                    <li><i class="bi bi-funnel text-primary"></i> <strong>اشتراك/وقت إضافي:</strong> يظهر المستخدمين من نوع <span class="badge bg-success">اشتراك</span> فقط</li>
                </ul>

                <div id="user-count-info" class="alert alert-info mt-2" style="display: none;">
                    <small>
                        <i class="bi bi-people"></i>
                        <span id="user-count-text"></span>
                    </small>
                </div>

                <div id="debug-info" class="alert alert-secondary mt-2" style="display: none;">
                    <small>
                        <i class="bi bi-bug"></i>
                        <span id="debug-text"></span>
                    </small>
                </div>

                <hr>

                @php
                    $publicPrices = \App\Models\PublicPrice::first();
                    $currentHour = now()->hour;
                    $isNightTime = $currentHour >= 18 || $currentHour <= 6;
                @endphp

                <h6>أسعار الخدمة:</h6>
                <ul class="list-unstyled small">
                    <li>• ساعي: ₪{{ number_format($publicPrices->hourly_rate ?? 5.00, 2) }}/ساعة</li>
                    <li>• إضافي صباحي: ₪{{ number_format($publicPrices->price_overtime_morning ?? 5.00, 2) }}/ساعة</li>
                    <li>• إضافي ليلي: ₪{{ number_format($publicPrices->price_overtime_night ?? 7.00, 2) }}/ساعة</li>
                    <li>• اشتراك: مجاني (30 يوم)</li>
                    <li>• مدفوع مسبقاً: مجاني (24 ساعة)</li>
                </ul>

                <h6>معلومات الجلسات الاشتراكية:</h6>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-calendar-check text-success"></i> مدة الجلسة: 30 يوم</li>
                    <li><i class="bi bi-clock text-info"></i> يمكن تحديد تاريخ انتهاء مخصص</li>
                    <li><i class="bi bi-stop-circle text-warning"></i> يمكن إنهاؤها في أي وقت</li>
                    <li><i class="bi bi-exclamation-triangle text-danger"></i> تنبيه عند انتهاء المدة</li>
                </ul>

                <div class="alert alert-info mt-3">
                    <small>
                        <i class="bi bi-clock"></i>
                        الوقت الحالي:
                        @if($isNightTime)
                            <span class="badge bg-dark">ليلي</span>
                            السعر: ₪{{ number_format($publicPrices->price_overtime_night ?? 7.00, 2) }}/ساعة
                        @else
                            <span class="badge bg-light text-dark">صباحي</span>
                            السعر: ₪{{ number_format($publicPrices->price_overtime_morning ?? 5.00, 2) }}/ساعة
                        @endif
                    </small>
                </div>
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
        minimumInputLength: 0, // إظهار جميع المستخدمين مباشرة
        maximumResultsForSearch: 50, // إظهار حتى 50 نتيجة
        templateResult: formatUser,
        templateSelection: formatUserSelection,
        dropdownParent: $('body') // لضمان ظهور القائمة بشكل صحيح
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
        return user.text.split(' - ')[0]; // عرض الاسم فقط
    }

    // البحث السريع بالكيبورد
    $('#user_id').on('keydown', function(e) {
        if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            const searchTerm = $(this).val();
            if (searchTerm.length > 0) {
                // البحث في القائمة
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
                    // إذا لم يتم العثور على مطابقة، اختر أول خيار
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
        // Ctrl + U للانتقال السريع لحقل المستخدم
        if (e.ctrlKey && e.keyCode === 85) {
            e.preventDefault();
            $('#user_id').select2('open');
        }
    });

    // متغير عام لحفظ الخيارات الأصلية
    let allOriginalOptions = [];

    // حفظ الخيارات الأصلية عند تحميل الصفحة
    $(document).ready(function() {
        const userSelect = $('#user_id');
        userSelect.find('option').each(function() {
            allOriginalOptions.push({
                value: $(this).val(),
                text: $(this).text(),
                userType: $(this).attr('data-user-type'),
                selected: $(this).is(':selected')
            });
        });
        console.log('تم حفظ الخيارات الأصلية:', allOriginalOptions.length);
    });

    // تصفية المستخدمين بناءً على فئة الجلسة المختارة
    $('#session_category').on('change', function() {
        console.log('تم تغيير فئة الجلسة:', $(this).val());

        const selectedCategory = $(this).val();
        const userSelect = $('#user_id');

        // حفظ القيمة المختارة حالياً
        const currentValue = userSelect.val();
        console.log('القيمة المختارة حالياً:', currentValue);

        console.log('استخدام الخيارات الأصلية المحفوظة:', allOriginalOptions.length);

        // إعادة بناء قائمة الخيارات بناءً على الفئة المختارة
        userSelect.empty();
        userSelect.append('<option value=""></option>'); // إضافة الخيار الفارغ

        // إضافة الخيارات المناسبة
        let filteredCount = 0;

        if (selectedCategory === 'hourly') {
            // إضافة المستخدمين من نوع ساعي ومسبق الدفع فقط
            allOriginalOptions.forEach(function(option) {
                if (option.userType === 'hourly' || option.userType === 'prepaid') {
                    userSelect.append(`<option value="${option.value}" data-user-type="${option.userType}">${option.text}</option>`);
                    filteredCount++;
                }
            });
            console.log('المستخدمين من نوع ساعي ومسبق الدفع:', filteredCount);
        } else if (selectedCategory === 'subscription' || selectedCategory === 'overtime') {
            // إضافة المستخدمين من نوع اشتراك فقط
            allOriginalOptions.forEach(function(option) {
                if (option.userType === 'subscription') {
                    userSelect.append(`<option value="${option.value}" data-user-type="${option.userType}">${option.text}</option>`);
                    filteredCount++;
                }
            });
            console.log('المستخدمين من نوع اشتراك:', filteredCount);
        } else {
            // إذا لم يتم اختيار فئة، إظهار جميع المستخدمين
            allOriginalOptions.forEach(function(option) {
                if (option.userType) {
                    userSelect.append(`<option value="${option.value}" data-user-type="${option.userType}">${option.text}</option>`);
                    filteredCount++;
                }
            });
            console.log('جميع المستخدمين:', filteredCount);
        }

        // إعادة تعيين القيمة المختارة إذا كانت متاحة في القائمة الجديدة
        if (currentValue && userSelect.find(`option[value="${currentValue}"]`).length > 0) {
            userSelect.val(currentValue);
            console.log('تم الاحتفاظ بالقيمة المختارة:', currentValue);
        } else {
            userSelect.val(''); // إعادة تعيين إذا لم تعد القيمة متاحة
            console.log('تم إعادة تعيين القيمة المختارة');
        }

        // تحديث Select2
        userSelect.select2('destroy');
        userSelect.select2({
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

        // إظهار رسالة تأكيد للمستخدم
        const visibleOptions = userSelect.find('option[value!=""]').length;
        console.log(`تم تصفية المستخدمين: ${visibleOptions} مستخدم متاح للفئة "${selectedCategory}"`);

        // تحديث معلومات عدد المستخدمين
        const userCountInfo = $('#user-count-info');
        const userCountText = $('#user-count-text');
        const debugInfo = $('#debug-info');
        const debugText = $('#debug-text');

        if (selectedCategory) {
            const categoryName = selectedCategory === 'hourly' ? 'ساعي' :
                                selectedCategory === 'subscription' ? 'اشتراك' :
                                selectedCategory === 'overtime' ? 'وقت إضافي' : selectedCategory;

            userCountText.text(`${visibleOptions} مستخدم متاح للفئة "${categoryName}"`);
            userCountInfo.show();

            // معلومات التصحيح
            const hourlyCount = allOriginalOptions.filter(opt => opt.userType === 'hourly' || opt.userType === 'prepaid').length;
            const subscriptionCount = allOriginalOptions.filter(opt => opt.userType === 'subscription').length;
            debugText.text(`الفئة: ${selectedCategory}, المستخدمين: ${visibleOptions}, القيمة المختارة: ${currentValue || 'لا شيء'} | إجمالي ساعي ومسبق الدفع: ${hourlyCount}, إجمالي اشتراك: ${subscriptionCount}`);
            debugInfo.show();
        } else {
            userCountInfo.hide();
            debugInfo.hide();
        }
    });


    // تشغيل التصفية عند تحميل الصفحة إذا كانت هناك قيمة محفوظة
    $(document).ready(function() {
        // انتظار لحظة للتأكد من تحميل جميع العناصر
        setTimeout(function() {
            if ($('#session_category').val()) {
                console.log('تشغيل التصفية الأولية...');
                $('#session_category').trigger('change');
            }
        }, 100);
    });
});
</script>
@endsection
