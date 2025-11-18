@extends('layouts.app')

@section('title', 'تعديل مدفوعة الجلسة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تعديل مدفوعة الجلسة #{{ $sessionPayment->id }}</h1>
    <div>
        <a href="{{ route('session-payments.show', $sessionPayment) }}" class="btn btn-outline-info me-2">
            <i class="bi bi-eye"></i> عرض التفاصيل
        </a>
        <a href="{{ route('session-payments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> العودة للقائمة
        </a>
    </div>
</div>

<!-- معلومات الجلسة -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0">
            <i class="bi bi-info-circle"></i>
            معلومات الجلسة المرتبطة
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="detail-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-hash text-primary me-2"></i>
                        <div>
                            <strong class="text-muted small">رقم الجلسة:</strong><br>
                            @if($sessionPayment->session && !$sessionPayment->session->trashed())
                                <a href="{{ route('sessions.show', $sessionPayment->session->id) }}" class="text-decoration-none fw-bold">
                                    #{{ $sessionPayment->session->id }}
                                </a>
                            @elseif($sessionPayment->session)
                                <span class="text-muted fw-bold">
                                    #{{ $sessionPayment->session->id }}
                                    <small class="badge bg-secondary">محذوفة</small>
                                </span>
                            @else
                                <span class="text-muted">غير موجودة</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person text-success me-2"></i>
                        <div>
                            <strong class="text-muted small">المستخدم:</strong><br>
                            <span class="fw-bold">{{ $sessionPayment->session->user->name ?? 'غير محدد' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-event text-info me-2"></i>
                        <div>
                            <strong class="text-muted small">نوع الجلسة:</strong><br>
    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock text-warning me-2"></i>
                        <div>
                            <strong class="text-muted small">تاريخ الجلسة:</strong><br>
                            <span class="fw-bold">{{ $sessionPayment->session && $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format('Y-m-d H:i') : 'غير محدد' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- تفاصيل تكلفة الإنترنت -->
        @if($sessionPayment->session)
            @php
                $internetCost = $sessionPayment->session->calculateInternetCost();
                $hasCustomCost = $sessionPayment->session->hasCustomInternetCost();
                $totalDrinksCost = $sessionPayment->session->drinks->sum('price');
                $totalCost = $internetCost + $totalDrinksCost;
            @endphp
            <hr class="my-3">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="detail-item bg-light rounded p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-wifi text-info me-2 fs-4"></i>
                            <div>
                                <strong class="text-muted small">تكلفة الإنترنت:</strong><br>
                                <span class="h5 text-success mb-0">${{ number_format($internetCost, 2) }}</span>
                            </div>
                        </div>

                        @if($hasCustomCost)
                            <span class="badge bg-warning">
                                <i class="bi bi-gear"></i> مخصصة
                            </span>
                            <small class="text-warning d-block mt-1">
                                <i class="bi bi-exclamation-triangle"></i>
                                تم تعيين تكلفة مخصصة
                            </small>
                        @else
                            <span class="badge bg-info">
                                <i class="bi bi-calculator"></i> تلقائية
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="detail-item bg-light rounded p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cup-hot text-warning me-2 fs-4"></i>
                            <div>
                                <strong class="text-muted small">تكلفة المشروبات:</strong><br>
                                <span class="h5 text-success mb-0">${{ number_format($totalDrinksCost, 2) }}</span>
                            </div>
                        </div>
                        <span class="badge bg-secondary">{{ $sessionPayment->session->drinks->count() }} مشروب</span>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="detail-item bg-primary bg-opacity-10 rounded p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calculator text-primary me-2 fs-4"></i>
                            <div>
                                <strong class="text-muted small">إجمالي التكلفة:</strong><br>
                                <span class="h5 text-primary mb-0">${{ number_format($totalCost, 2) }}</span>
                            </div>
                        </div>
                        <span class="badge bg-primary">المبلغ المستحق</span>
                    </div>
                </div>
            </div>
        @endif
        </div>

</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">تعديل تفاصيل المدفوعة</h5>
    </div>
    <div class="card-body">
        @if($sessionPayment->session && $sessionPayment->session->session_status == 'active')
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>ملاحظة:</strong> الجلسة لا تزال نشطة. يمكنك تعديل المدفوعة في أي وقت.
                حالة الجلسة الحالية:
                <span class="badge bg-success">نشط</span>
            </div>
        @elseif($sessionPayment->session && $sessionPayment->session->session_status == 'cancelled')
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>تحذير:</strong> الجلسة ملغية. تأكد من صحة المدفوعة.
                حالة الجلسة الحالية:
                <span class="badge bg-danger">ملغي</span>
            </div>
        @endif
        <form action="{{ route('session-payments.update', $sessionPayment) }}" method="POST" id="payment-form">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="total_price" class="form-label">السعر الإجمالي <span class="text-danger">*</span></label>
                    @php
                        $totalPriceValue = old('total_price');
                        if ($totalPriceValue === null) {
                            $totalPriceValue = $sessionPayment->total_price !== null
                                ? number_format((float) $sessionPayment->total_price, 2, '.', '')
                                : '';
                        }
                    @endphp
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" step="0.01" min="0"
                               class="form-control @error('total_price') is-invalid @enderror"
                               id="total_price" name="total_price"
                               value="{{ $totalPriceValue }}" required>
                        @error('total_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        <i class="bi bi-info-circle"></i>
                        يجب أن يكون: <strong>سعر الإنترنت + إجمالي المشروبات</strong>
                    </small>
                    @if($sessionPayment->session)
                        @php
                            $internetCost = $sessionPayment->session->calculateInternetCost();
                            $totalDrinksCost = $sessionPayment->session->drinks->sum('price');
                            $suggestedTotal = $internetCost + $totalDrinksCost;

                            // حساب التفاصيل للعرض
                            $publicPrices = \App\Models\PublicPrice::first();
                            $startTime = $sessionPayment->session->start_at;
                            $endTime = $sessionPayment->session->end_at ?? now();
                            $durationInMinutes = $startTime->diffInMinutes($endTime);
                            $duration = $durationInMinutes / 60;

                            // حساب السعر بالساعة للعرض
                            $hourlyRate = 0;
                            switch ($sessionPayment->session->session_category) {
                                case 'hourly':
                                    $hourlyRate = $publicPrices->hourly_rate ?? 5.00;
                                    break;
                                case 'overtime':
                                    $hour = $startTime->hour;
                                    $isNight = $hour >= 18 || $hour <= 6;
                                    $hourlyRate = $isNight ? ($publicPrices->price_overtime_night ?? 7.00) : ($publicPrices->price_overtime_morning ?? 5.00);
                                    break;
                                case 'subscription':
                                    $hourlyRate = 0;
                                    break;
                            }
                        @endphp

                        <div class="alert alert-info mt-2 py-2">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-lightbulb text-warning me-2"></i>
                                        <strong class="text-primary">اقتراح السعر الإجمالي:</strong>
                                    </div>

                                    <!-- تفاصيل تكلفة الإنترنت -->
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-wifi text-info me-2"></i>
                                            <span class="fw-bold">تكلفة الإنترنت:</span>
                                            <span class="ms-2 fw-bold text-success">${{ number_format($internetCost, 2) }}</span>

                                            @if($sessionPayment->session->hasCustomInternetCost())
                                                <span class="badge bg-warning ms-2">
                                                    <i class="bi bi-gear"></i> مخصصة
                                                </span>
                                            @else
                                                <span class="badge bg-info ms-2">
                                                    <i class="bi bi-calculator"></i> تلقائية
                                                </span>
                                            @endif
                                        </div>

                                        @if(!$sessionPayment->session->hasCustomInternetCost() && $sessionPayment->session->session_category != 'subscription')
                                            <small class="text-muted ms-4">
                                                <i class="bi bi-clock"></i>
                                                {{ number_format($duration, 1) }} ساعة × ${{ number_format($hourlyRate, 2) }}/ساعة
                                                @if($sessionPayment->session->session_category == 'overtime')
                                                    @if($sessionPayment->session->start_at->hour >= 18 || $sessionPayment->session->start_at->hour <= 6)
                                                        <span class="badge bg-dark ms-1">سعر ليلي</span>
                                                    @else
                                                        <span class="badge bg-light text-dark ms-1">سعر صباحي</span>
                                                    @endif
                                                @endif
                                            </small>
                                        @endif

                                        @if($sessionPayment->session->hasCustomInternetCost())
                                            <small class="text-warning ms-4">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                تم تعيين تكلفة مخصصة بدلاً من الحساب التلقائي
                                            </small>
                                        @endif
                                    </div>

                                    <!-- تفاصيل المشروبات -->
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-cup-hot text-warning me-2"></i>
                                            <span class="fw-bold">تكلفة المشروبات:</span>
                                            <span class="ms-2 fw-bold text-success">${{ number_format($totalDrinksCost, 2) }}</span>
                                            <span class="badge bg-secondary ms-2">{{ $sessionPayment->session->drinks->count() }} مشروب</span>
                                        </div>
                                    </div>

                                    <!-- الإجمالي -->
                                    <div class="border-top pt-2">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calculator text-primary me-2"></i>
                                            <span class="fw-bold">الإجمالي المقترح:</span>
                                            <span class="ms-2 h5 fw-bold text-primary mb-0">${{ number_format($suggestedTotal, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex flex-column align-items-end gap-2 justify-content-center">
                                    <button type="button" class="btn btn-outline-primary w-100"
                                            onclick="setSuggestedTotal({{ $suggestedTotal }})">
                                        <i class="bi bi-check-circle me-1"></i>
                                        استخدم الإجمالي المقترح
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary w-100"
                                            onclick="setRemainingAsTotal({{ number_format((float) $sessionPayment->remaining_amount, 2, '.', '') }})">
                                        <i class="bi bi-cash-coin me-1"></i>
                                        استخدم المبلغ المتبقي
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label">حالة الدفع <span class="text-danger">*</span></label>
                    <select class="form-select @error('payment_status') is-invalid @enderror"
                            id="payment_status" name="payment_status" required>
                        <option value="">اختر حالة الدفع</option>
                        <option value="pending" {{ old('payment_status', $sessionPayment->payment_status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="paid" {{ old('payment_status', $sessionPayment->payment_status) == 'paid' ? 'selected' : '' }}>مدفوعة بالكامل</option>
                        <option value="partial" {{ old('payment_status', $sessionPayment->payment_status) == 'partial' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                        <option value="cancelled" {{ old('payment_status', $sessionPayment->payment_status) == 'cancelled' ? 'selected' : '' }}>ملغية</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">سيتم تحديث الحالة تلقائياً بناءً على المبالغ المدفوعة</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount_bank" class="form-label">المبلغ المدفوع بنكياً</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0"
                               class="form-control @error('amount_bank') is-invalid @enderror"
                               id="amount_bank" name="amount_bank"
                               value="{{ old('amount_bank', $sessionPayment->amount_bank) }}"
                               placeholder="0.00">
                        <button type="button" class="btn btn-outline-success" onclick="copyTotalToBank()" title="نسخ السعر الإجمالي">
                            <i class="bi bi-copy"></i>
                        </button>
                        @error('amount_bank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">المبلغ المدفوع عبر البنك أو التحويل الإلكتروني</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="amount_cash" class="form-label">المبلغ المدفوع كاش</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0"
                               class="form-control @error('amount_cash') is-invalid @enderror"
                               id="amount_cash" name="amount_cash"
                               value="{{ old('amount_cash', $sessionPayment->amount_cash) }}"
                               placeholder="0.00">
                        <button type="button" class="btn btn-outline-success" onclick="copyTotalToCash()" title="نسخ السعر الإجمالي">
                            <i class="bi bi-copy"></i>
                        </button>
                        @error('amount_cash')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">المبلغ المدفوع نقداً</small>
                </div>
            </div>

            <!-- ملخص المدفوعات -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-gradient rounded-circle p-2 me-3">
                            <i class="bi bi-calculator text-white fs-5"></i>
                        </div>
                        <div>
                            <h5 class="text-primary mb-1">ملخص المدفوعات والحسابات</h5>
                            <small class="text-muted">عرض تفصيلي للمبالغ المدفوعة والمستحقة</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-warning h-100 shadow-sm hover-shadow">
                        <div class="card-header bg-warning bg-gradient text-white text-center">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                المبلغ المتبقي
                            </h6>
                        </div>
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <div class="h2 text-danger fw-bold mb-3" id="remaining_amount_display">
                                ${{ number_format($sessionPayment->remaining_amount, 2) }}
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-calculator me-1"></i>
                                محسوب تلقائياً
                            </div>
                            <input type="hidden" id="remaining_amount" value="{{ $sessionPayment->remaining_amount }}">
                        </div>
                        <div class="card-footer bg-light text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                المبلغ المطلوب دفعه
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-success h-100 shadow-sm hover-shadow">
                        <div class="card-header bg-success bg-gradient text-white text-center">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-check-circle me-2"></i>
                                إجمالي المدفوع
                            </h6>
                        </div>
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <div class="h2 text-success fw-bold mb-3" id="total_paid_display">
                                ${{ number_format($sessionPayment->amount_bank + $sessionPayment->amount_cash, 2) }}
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-calculator me-1"></i>
                                محسوب تلقائياً
                            </div>
                            <input type="hidden" id="total_paid" value="{{ $sessionPayment->amount_bank + $sessionPayment->amount_cash }}">
                        </div>
                        <div class="card-footer bg-light text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                إجمالي المبالغ المدفوعة
                            </small>
                        </div>
                    </div>
                </div>

                <!-- المبلغ المستحق للزبون -->
                @if($sessionPayment->session)
                    @php
                        $sessionTotal = $sessionPayment->session->calculateInternetCost() + $sessionPayment->session->drinks->sum('price');
                        $totalPaid = $sessionPayment->amount_bank + $sessionPayment->amount_cash;
                        $refundAmount = max(0, $totalPaid - $sessionTotal);
                    @endphp
                    <div class="col-md-4 mb-3">
                        <div class="card border-info h-100 shadow-sm hover-shadow">
                            <div class="card-header bg-info bg-gradient text-white text-center">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-cash-coin me-2"></i>
                                    المبلغ المستحق للزبون
                                </h6>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div class="row g-2">
                                    <div class="col-12 text-center mb-3">
                                        <div class="h5 text-primary mb-1">
                                            <i class="bi bi-receipt me-1"></i>
                                            ${{ number_format($sessionTotal, 2) }}
                                        </div>
                                        <small class="text-muted">إجمالي تكلفة الجلسة</small>
                                    </div>

                                    <div class="col-12 text-center">
                                        <div class="h4 {{ $refundAmount > 0 ? 'text-success' : 'text-danger' }} fw-bold mb-1">
                                            <i class="bi {{ $refundAmount > 0 ? 'bi-arrow-up-circle' : 'bi-arrow-down-circle' }} me-1"></i>
                                            ${{ number_format($refundAmount, 2) }}
                                        </div>
                                        <small class="text-muted" id="refund_status_text">
                                            {{ $refundAmount > 0 ? 'مستحق للزبون' : 'لا يوجد مستحقات' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-center">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    {{ $refundAmount > 0 ? 'يجب إرجاع المبلغ للزبون' : 'لا توجد مستحقات للزبون' }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>



            <!-- حقل الملاحظة -->
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="note" class="form-label">
                        ملاحظة الدفع
                        <span id="note_required_indicator" class="text-danger d-none">*</span>
                    </label>
                    <textarea class="form-control @error('note') is-invalid @enderror"
                              id="note" name="note" rows="3"
                              placeholder="اكتب ملاحظة حول الدفع (اختياري)">{{ old('note', $sessionPayment->note) }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted" id="note_help_text">
                        يمكنك إضافة ملاحظة حول الدفع أو أي تفاصيل إضافية
                    </small>
                    <small class="form-text text-danger d-none" id="note_required_text">
                        <i class="bi bi-exclamation-triangle"></i>
                        الملاحظة مطلوبة عندما يكون هناك مبلغ مستحق للزبون
                    </small>
                </div>
            </div>

            <!-- معلومات إضافية -->
            <div class="alert alert-info">
                <h6><i class="bi bi-info-circle"></i> ملاحظات مهمة:</h6>
                <ul class="mb-0">
                    <li>سيتم حساب المبلغ المتبقي تلقائياً</li>
                    <li>سيتم تحديث حالة الدفع تلقائياً بناءً على المبالغ المدفوعة</li>
                    <li>إذا كان إجمالي المبلغ المدفوع يساوي أو يزيد عن السعر الإجمالي، ستصبح الحالة "مدفوعة بالكامل"</li>
                    <li>إذا كان هناك مبلغ مدفوع ولكن أقل من الإجمالي، ستصبح الحالة "مدفوعة جزئياً"</li>
                    <li>يمكنك تعديل المدفوعة في أي وقت بغض النظر عن حالة الجلسة</li>
                    <li>يمكنك ترك حقول المبالغ فارغة إذا لم يتم دفع أي مبلغ</li>
                </ul>
            </div>

            <!-- التاريخ والوقت -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">تاريخ الإنشاء</label>
                    <input type="text" class="form-control bg-light" readonly
                           value="{{ $sessionPayment->created_at->format('Y-m-d H:i:s') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">آخر تحديث</label>
                    <input type="text" class="form-control bg-light" readonly
                           value="{{ $sessionPayment->updated_at->format('Y-m-d H:i:s') }}">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('session-payments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> إلغاء
                </a>

                <button type="submit" class="btn btn-primary" id="submit-btn">
                    <i class="bi bi-save"></i> حفظ التحديثات
                </button>
            </div>
        </form>
    </div>
</div>

<!-- قسم تصدير الفاتورة -->
<div class="card mt-4">
    <div class="card-header bg-success text-white" data-bs-toggle="collapse" data-bs-target="#invoiceExportSection" aria-expanded="false" aria-controls="invoiceExportSection" style="cursor: pointer;">
        <h5 class="card-title mb-0 d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-whatsapp"></i>
                تصدير الفاتورة عبر الواتساب
            </span>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </h5>
    </div>
    <div class="collapse" id="invoiceExportSection">
        <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="customer_phone" class="form-label">رقم هاتف العميل</label>
                <div class="input-group phone-input-group">
                    <span class="input-group-text">
                        <i class="bi bi-phone"></i>
                    </span>
                    <input type="tel" 
                           class="form-control" 
                           id="customer_phone" 
                           placeholder="966501234567"
                           value="{{ $sessionPayment->session->user->phone ?? '' }}">
                    <button type="button" class="btn btn-outline-info" onclick="detectPhoneNumber()">
                        <i class="bi bi-search"></i>
                        استخراج من الجلسة
                    </button>
                </div>
                <small class="form-text text-muted">
                    أدخل رقم الهاتف مع رمز الدولة (مثال: 966501234567)
                </small>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="invoice_message" class="form-label">رسالة مخصصة (اختياري)</label>
                <textarea class="form-control" 
                          id="invoice_message" 
                          rows="3" 
                          placeholder="أضف رسالة مخصصة للفاتورة...">{{ $sessionPayment->session->user->name ?? 'العميل العزيز' }}، إليكم تفاصيل الفاتورة:"></textarea>
                <small class="form-text text-muted">
                    يمكنك تخصيص الرسالة المرسلة مع الفاتورة
                </small>
            </div>
        </div>

        <!-- معاينة الفاتورة -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card preview-card">
                    <div class="card-header text-white">
                        <h6 class="mb-0 text-dark">
                            <i class="bi bi-eye"></i>
                            معاينة الفاتورة
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="invoice_preview" class="invoice-preview bg-light p-3 rounded">
                            <!-- سيتم ملء هذا القسم بواسطة JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- أزرار التصدير -->
        <div class="row">
            <div class="col-md-3 mb-2">
                <button type="button" class="btn btn-success btn-lg w-100 whatsapp-export" onclick="exportToWhatsApp()">
                    <i class="bi bi-whatsapp"></i>
                    إرسال عبر الواتساب
                </button>
            </div>
            <div class="col-md-3 mb-2">
                <button type="button" class="btn btn-outline-success btn-lg w-100 copy-button" onclick="copyInvoiceText()">
                    <i class="bi bi-clipboard"></i>
                    نسخ نص الفاتورة
                </button>
            </div>
            <div class="col-md-3 mb-2">
                <a href="{{ route('session-payments.invoice', $sessionPayment) }}" class="btn btn-danger btn-lg w-100 pdf-export">
                    <i class="bi bi-file-pdf"></i>
                    تصدير PDF
                </a>
            </div>
            <div class="col-md-3 mb-2">
                <a href="{{ route('session-payments.invoice.show', $sessionPayment) }}" target="_blank" class="btn btn-info btn-lg w-100">
                    <i class="bi bi-printer"></i>
                    عرض للطباعة
                </a>
            </div>
        </div>

        <!-- معلومات إضافية -->
        <div class="alert alert-info mt-3">
            <h6><i class="bi bi-info-circle"></i> ملاحظات مهمة:</h6>
            <ul class="mb-0">
                <li>سيتم إرسال الفاتورة كرسالة نصية عبر الواتساب</li>
                <li>تأكد من صحة رقم الهاتف قبل الإرسال</li>
                <li>يمكنك تخصيص الرسالة حسب الحاجة</li>
                <li>الفاتورة تتضمن جميع التفاصيل المهمة</li>
                <li>يمكنك تصدير الفاتورة كملف PDF احترافي</li>
                <li>الفاتورة PDF تتضمن شعار المؤسسة وتصميم احترافي</li>
            </ul>
        </div>
        </div>
    </div>
</div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .card-header.bg-gradient {
        background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
    }

    .card-header.bg-warning.bg-gradient {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    }

    .card-header.bg-success.bg-gradient {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
    }

    .card-header.bg-info.bg-gradient {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
    }

    .bg-primary.bg-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    }

    .card-footer {
        border-top: 1px solid rgba(0,0,0,0.1);
    }

    .h2, .h4, .h5 {
        font-weight: 700;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-success {
        color: #198754 !important;
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .text-success {
        color: #198754 !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }

    /* Collapsible section styles */
    .collapse-icon {
        transition: transform 0.3s ease;
    }

    .card-header[aria-expanded="true"] .collapse-icon {
        transform: rotate(180deg);
    }

    .card-header:hover {
        opacity: 0.9;
    }

    /* تحسينات إضافية لعرض تكلفة الإنترنت */
    .alert-info {
        border-left: 4px solid #0dcaf0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%) !important;
        color: #000 !important;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%) !important;
        color: #fff !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-info {
        color: #0dcaf0 !important;
    }

    .text-success {
        color: #198754 !important;
    }

    /* تحسين عرض التفاصيل */
    .detail-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 8px 12px;
        margin-bottom: 8px;
    }

    .detail-item:hover {
        background-color: rgba(13, 202, 240, 0.1);
        transform: translateX(5px);
    }

    /* تحسين الأيقونات */
    .bi-wifi {
        color: #0dcaf0;
    }

    .bi-cup-hot {
        color: #fd7e14;
    }

    .bi-calculator {
        color: #6f42c1;
    }

    .bi-gear {
        color: #ffc107;
    }

    /* تحسينات إضافية للعرض */
    .bg-primary.bg-opacity-10 {
        background-color: rgba(13, 110, 253, 0.1) !important;
        border: 1px solid rgba(13, 110, 253, 0.2);
    }

    .detail-item.bg-light {
        border: 1px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .detail-item.bg-light:hover {
        border-color: rgba(13, 202, 240, 0.3);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .detail-item.bg-primary.bg-opacity-10:hover {
        background-color: rgba(13, 110, 253, 0.15) !important;
        border-color: rgba(13, 110, 253, 0.4);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .fs-4 {
        font-size: 1.5rem !important;
    }

    .h5 {
        font-weight: 700;
    }

    /* Pulse animation for custom cost badges */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* Fix for Bootstrap RTL */
    .me-2 {
        margin-left: 0.5rem !important;
        margin-right: 0 !important;
    }

    .ms-2 {
        margin-right: 0.5rem !important;
        margin-left: 0 !important;
    }

    .ms-4 {
        margin-right: 1.5rem !important;
        margin-left: 0 !important;
    }

    .me-md-2 {
        margin-left: 0.5rem !important;
        margin-right: 0 !important;
    }

    /* Fix for text alignment */
    .text-start {
        text-align: right !important;
    }

    .text-end {
        text-align: left !important;
    }

    /* Fix for flexbox RTL */
    .d-flex {
        flex-direction: row-reverse;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }

    .justify-content-end {
        justify-content: flex-start !important;
    }

    .align-items-center {
        align-items: center !important;
    }

    /* Fix for card layouts */
    .card-body {
        direction: rtl;
    }

    .row {
        direction: rtl;
    }

    /* Fix for form controls */
    .form-control, .form-select {
        text-align: right;
    }

    .input-group-text {
        border-radius: 0 0.375rem 0.375rem 0;
    }

    .input-group .form-control {
        border-radius: 0.375rem 0 0 0.375rem;
    }

    /* Fix for buttons */
    .btn {
        direction: rtl;
    }

    /* Fix for alerts */
    .alert {
        direction: rtl;
        text-align: right;
    }

    /* Fix for badges */
    .badge {
        direction: rtl;
    }

    /* Fix for small text */
    .small {
        direction: rtl;
    }

    /* Fix for strong elements */
    strong {
        direction: rtl;
    }

    /* Additional fixes for better RTL support */
    .col-md-3, .col-md-4, .col-md-6, .col-md-8, .col-12 {
        direction: rtl;
    }

    /* Fix for input groups */
    .input-group {
        direction: rtl;
    }

    /* Fix for form labels */
    .form-label {
        direction: rtl;
        text-align: right;
    }

    /* Fix for help text */
    .form-text {
        direction: rtl;
        text-align: right;
    }

    /* Fix for invalid feedback */
    .invalid-feedback {
        direction: rtl;
        text-align: right;
    }

    /* Fix for card headers */
    .card-header {
        direction: rtl;
        text-align: right;
    }

    /* Fix for card titles */
    .card-title {
        direction: rtl;
        text-align: right;
    }

    /* Fix for modal content */
    .modal-content {
        direction: rtl;
    }

    /* Fix for modal header */
    .modal-header {
        direction: rtl;
    }

    /* Fix for modal body */
    .modal-body {
        direction: rtl;
        text-align: right;
    }

    /* Fix for modal footer */
    .modal-footer {
        direction: rtl;
    }

    /* Fix for table content */
    table {
        direction: rtl;
    }

    /* Fix for list items */
    li {
        direction: rtl;
        text-align: right;
    }

    /* Fix for paragraph elements */
    p {
        direction: rtl;
        text-align: right;
    }

    /* Fix for div elements */
    div {
        direction: rtl;
    }

    /* Fix for span elements */
    span {
        direction: rtl;
    }

    /* Fix for small elements */
    small {
        direction: rtl;
        text-align: right;
    }

    /* Fix for h1, h2, h3, h4, h5, h6 */
    h1, h2, h3, h4, h5, h6 {
        direction: rtl;
        text-align: right;
    }

    /* Fix for Bootstrap utilities */
    .text-center {
        text-align: center !important;
    }

    .text-right {
        text-align: right !important;
    }

    .text-left {
        text-align: left !important;
    }

    /* Fix for flex utilities */
    .d-flex {
        display: flex !important;
    }

    .flex-column {
        flex-direction: column !important;
    }

    .flex-row {
        flex-direction: row-reverse !important;
    }

    /* Fix for spacing utilities */
    .mb-1, .mb-2, .mb-3, .mb-4, .mb-5 {
        margin-bottom: inherit !important;
    }

    .mt-1, .mt-2, .mt-3, .mt-4, .mt-5 {
        margin-top: inherit !important;
    }

    .py-1, .py-2, .py-3, .py-4, .py-5 {
        padding-top: inherit !important;
        padding-bottom: inherit !important;
    }

    .px-1, .px-2, .px-3, .px-4, .px-5 {
        padding-left: inherit !important;
        padding-right: inherit !important;
    }

    /* Fix for border utilities */
    .border-top {
        border-top: 1px solid rgba(0,0,0,.125) !important;
    }

    .border-bottom {
        border-bottom: 1px solid rgba(0,0,0,.125) !important;
    }

    /* Fix for background utilities */
    .bg-light {
        background-color: #f8f9fa !important;
    }

    .bg-primary {
        background-color: #0d6efd !important;
    }

    .bg-success {
        background-color: #198754 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .bg-info {
        background-color: #0dcaf0 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    /* Fix for text color utilities */
    .text-primary {
        color: #0d6efd !important;
    }

    .text-success {
        color: #198754 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-info {
        color: #0dcaf0 !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    /* Fix for font weight utilities */
    .fw-bold {
        font-weight: 700 !important;
    }

    .fw-normal {
        font-weight: 400 !important;
    }

    /* Fix for display utilities */
    .d-none {
        display: none !important;
    }

    .d-block {
        display: block !important;
    }

    .d-inline {
        display: inline !important;
    }

    .d-inline-block {
        display: inline-block !important;
    }

    /* WhatsApp export styles */
    .whatsapp-export {
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .whatsapp-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
    }

    .invoice-preview {
        font-family: 'Courier New', monospace;
        white-space: pre-wrap;
        line-height: 1.6;
        direction: ltr;
        text-align: left;
    }

    .invoice-preview br {
        display: block;
        content: "";
        margin-top: 0.5em;
    }

    /* Phone input styles */
    .phone-input-group .input-group-text {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        color: white;
        border: none;
    }

    /* Copy button styles */
    .copy-button {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .copy-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    }

    /* PDF export button styles */
    .pdf-export {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        transition: all 0.3s ease;
        color: white;
        text-decoration: none;
    }

    .pdf-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Print button styles */
    .btn-info {
        background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
        border: none;
        transition: all 0.3s ease;
        color: white;
        text-decoration: none;
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13, 202, 240, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Preview card styles */
    .preview-card {
        border: 2px solid #0dcaf0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
    }

    .preview-card .card-header {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        border: none;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Handle collapsible section icon rotation
        const collapseElement = document.getElementById('invoiceExportSection');
        const collapseIcon = document.querySelector('.collapse-icon');
        
        if (collapseElement && collapseIcon) {
            collapseElement.addEventListener('show.bs.collapse', function () {
                collapseIcon.style.transform = 'rotate(180deg)';
            });
            
            collapseElement.addEventListener('hide.bs.collapse', function () {
                collapseIcon.style.transform = 'rotate(0deg)';
            });
        }
        // Get form elements
        const totalPrice = document.getElementById('total_price');
        const amountBank = document.getElementById('amount_bank');
        const amountCash = document.getElementById('amount_cash');
        const remainingAmount = document.getElementById('remaining_amount');
        const totalPaid = document.getElementById('total_paid');
        const paymentStatus = document.getElementById('payment_status');

        // Check if elements exist before proceeding
        if (!totalPrice || !amountBank || !amountCash) {
            console.warn('Some form elements are missing');
            return;
        }

    function calculateAmounts() {
        try {
            const total = parseFloat(totalPrice.value) || 0;
            const bank = parseFloat(amountBank.value) || 0;
            const cash = parseFloat(amountCash.value) || 0;

            // Handle empty values properly
            if (amountBank.value === '') amountBank.value = '';
            if (amountCash.value === '') amountCash.value = '';
            
            // Force numeric values only if they contain invalid data
            if (amountBank.value !== '' && isNaN(bank)) amountBank.value = '0';
            if (amountCash.value !== '' && isNaN(cash)) amountCash.value = '0';

            const paid = bank + cash;
            const remaining = Math.max(0, total - paid);

        // Update hidden inputs if they exist
        if (remainingAmount) {
            remainingAmount.value = remaining.toFixed(2);
        }
        if (totalPaid) {
            totalPaid.value = paid.toFixed(2);
        }

        // Update display elements
        const remainingDisplay = document.getElementById('remaining_amount_display');
        const totalPaidDisplay = document.getElementById('total_paid_display');

        if (remainingDisplay) {
            remainingDisplay.textContent = '$' + remaining.toFixed(2);
            // Change color based on remaining amount
            if (remaining > 0) {
                remainingDisplay.className = 'h2 text-danger fw-bold mb-3';
            } else {
                remainingDisplay.className = 'h2 text-success fw-bold mb-3';
            }
        }

        if (totalPaidDisplay) {
            totalPaidDisplay.textContent = '$' + paid.toFixed(2);
        }

        // Calculate refund amount and update note requirement
        const sessionTotal = parseFloat(totalPrice.value) || 0;
        const refundAmount = Math.max(0, paid - sessionTotal);

        // Update refund display if elements exist
        const sessionTotalDisplay = document.getElementById('session_total_display');
        const totalPaidDisplayWallet = document.getElementById('total_paid_display_wallet');
        const refundAmountDisplay = document.getElementById('refund_amount_display');
        const refundStatusText = document.getElementById('refund_status_text');

        // Only update if elements exist to prevent errors
        if (sessionTotalDisplay) {
            sessionTotalDisplay.textContent = '$' + sessionTotal.toFixed(2);
        }
        
        if (totalPaidDisplayWallet) {
            totalPaidDisplayWallet.textContent = '$' + paid.toFixed(2);
        }
        
        if (refundAmountDisplay) {
            refundAmountDisplay.textContent = '$' + refundAmount.toFixed(2);

            // Change color based on refund amount
            if (refundAmount > 0) {
                refundAmountDisplay.className = 'h5 text-success fw-bold mb-1';
            } else {
                refundAmountDisplay.className = 'h5 text-danger fw-bold mb-1';
            }
        }

        // Update refund status text if element exists
        if (refundStatusText) {
            if (refundAmount > 0) {
                refundStatusText.textContent = 'مستحق للزبون';
                refundStatusText.className = 'text-muted text-success';
            } else {
                refundStatusText.textContent = 'لا يوجد مستحقات';
                refundStatusText.className = 'text-muted text-secondary';
            }
        }

        // Update note requirement based on refund amount
        try {
            updateNoteRequirement(refundAmount);
        } catch (error) {
            console.error('Error updating note requirement:', error);
        }

        // Auto-update payment status if element exists
        if (paymentStatus && total > 0) {
            if (paid >= total) {
                paymentStatus.value = 'paid';
            } else if (paid > 0) {
                paymentStatus.value = 'partial';
            } else {
                paymentStatus.value = 'pending';
            }
        }
    } catch (error) {
        console.error('Error in calculateAmounts:', error);
    }
    }

    // Add event listeners for real-time updates
    if (totalPrice) {
        totalPrice.addEventListener('input', function() {
            try {
                calculateAmounts();
            } catch (error) {
                console.error('Error in totalPrice input:', error);
            }
        });
        totalPrice.addEventListener('change', function() {
            try {
                calculateAmounts();
            } catch (error) {
                console.error('Error in totalPrice change:', error);
            }
        });
    }
    
    if (amountBank) {
        amountBank.addEventListener('input', function() {
            try {
                calculateAmounts();
            } catch (error) {
                console.error('Error in amountBank input:', error);
            }
        });
        amountBank.addEventListener('change', function() {
            try {
                calculateAmounts();
            } catch (error) {
                console.error('Error in amountBank change:', error);
            }
        });
        amountBank.addEventListener('paste', function() {
            setTimeout(function() {
                try {
                    calculateAmounts();
                } catch (error) {
                    console.error('Error in paste calculation:', error);
                }
            }, 100);
        });
    }
    
    if (amountCash) {
        amountCash.addEventListener('input', function() {
            try {
                calculateAmounts();
            } catch (error) {
                console.error('Error in amountCash input:', error);
            }
        });
        amountCash.addEventListener('change', function() {
            try {
                calculateAmounts();
            } catch (error) {
                console.error('Error in amountCash change:', error);
            }
        });
        amountCash.addEventListener('paste', function() {
            setTimeout(function() {
                try {
                    calculateAmounts();
                } catch (error) {
                    console.error('Error in paste calculation:', error);
                }
            }, 100);
        });
    }

    // Initial calculation with delay to ensure DOM is ready
    setTimeout(function() {
        try {
            calculateAmounts();
        } catch (error) {
            console.error('Error in initial calculation:', error);
        }
    }, 100);

    // Add form submission handler
    const form = document.getElementById('payment-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission started');
            
            // Show loading state
            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> جاري الحفظ...';
            }
            
            // Log form data
            const formData = new FormData(form);
            console.log('Form data being submitted:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            // Allow form submission
            console.log('Form submission allowed');
        });
    }
    
    console.log('Form initialization completed');

    // Add error handling for missing elements
    window.addEventListener('error', function(e) {
        console.warn('JavaScript error:', e.message);
    });

    // Add global error handler for unhandled promise rejections
    window.addEventListener('unhandledrejection', function(e) {
        console.warn('Unhandled promise rejection:', e.reason);
    });

    // Debug function to check if elements exist
    function debugElements() {
        console.log('Debugging elements:');
        console.log('totalPrice:', totalPrice);
        console.log('amountBank:', amountBank);
        console.log('amountCash:', amountCash);
        console.log('remainingAmount:', remainingAmount);
        console.log('totalPaid:', totalPaid);
        console.log('paymentStatus:', paymentStatus);
        console.log('refundAmountDisplay:', document.getElementById('refund_amount_display'));
        console.log('refundStatusText:', document.getElementById('refund_status_text'));
    }

    // Uncomment the line below to debug
    // debugElements();
    
    } catch (error) {
        console.error('Error initializing form:', error);
    }
});

// Function to update note requirement
function updateNoteRequirement(refundAmount) {
    const noteField = document.getElementById('note');
    const noteRequiredIndicator = document.getElementById('note_required_indicator');
    const noteHelpText = document.getElementById('note_help_text');
    const noteRequiredText = document.getElementById('note_required_text');

    // Check if elements exist before proceeding
    if (!noteField) {
        console.warn('Note field not found');
        return;
    }

    if (refundAmount > 0) {
        // Note is required
        noteField.required = true;
        
        if (noteRequiredIndicator) {
            noteRequiredIndicator.classList.remove('d-none');
        }
        
        if (noteHelpText) {
            noteHelpText.classList.add('d-none');
        }
        
        if (noteRequiredText) {
            noteRequiredText.classList.remove('d-none');
        }
        
        noteField.classList.add('border-warning');

        // Add validation on blur
        noteField.addEventListener('blur', validateNoteField);
    } else {
        // Note is optional
        noteField.required = false;
        
        if (noteRequiredIndicator) {
            noteRequiredIndicator.classList.add('d-none');
        }
        
        if (noteHelpText) {
            noteHelpText.classList.remove('d-none');
        }
        
        if (noteRequiredText) {
            noteRequiredText.classList.add('d-none');
        }
        
        noteField.classList.remove('border-warning', 'border-danger');
        noteField.classList.remove('is-invalid');
    }
}

// Function to validate note field
function validateNoteField() {
    const noteField = document.getElementById('note');
    
    if (!noteField) {
        console.warn('Note field not found for validation');
        return;
    }
    
    const noteValue = noteField.value.trim();

    if (noteField.required && noteValue === '') {
        noteField.classList.add('is-invalid', 'border-danger');
        noteField.classList.remove('border-warning');
    } else {
        noteField.classList.remove('is-invalid', 'border-danger');
        if (noteField.required) {
            noteField.classList.add('border-warning');
        }
    }
}



// Function to handle form submission
function handleFormSubmit(event) {
    try {
        console.log('Form submission handler called');
        
        // Show loading state
        const submitBtn = document.getElementById('submit-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> جاري الحفظ...';
        }
        
        // Log form data
        const form = event.target;
        const formData = new FormData(form);
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Always allow form submission
        console.log('Form submission allowed');
        return true;
        
    } catch (error) {
        console.error('Error in form submission handler:', error);
        return true; // Always allow submission
    }
}

// Function to validate form before submission
function validateForm() {
    try {
        console.log('Starting form validation');
        
        const totalPriceElement = document.getElementById('total_price');
        const amountBankElement = document.getElementById('amount_bank');
        const amountCashElement = document.getElementById('amount_cash');
        const noteField = document.getElementById('note');

        // Check if elements exist
        if (!totalPriceElement || !amountBankElement || !amountCashElement || !noteField) {
            console.warn('Some form elements are missing for validation');
            return true; // Allow submission if elements are missing
        }

        const totalPrice = parseFloat(totalPriceElement.value) || 0;
        const amountBank = parseFloat(amountBankElement.value) || 0;
        const amountCash = parseFloat(amountCashElement.value) || 0;

        console.log('Form values:', { totalPrice, amountBank, amountCash });

        const totalPaid = amountBank + amountCash;
        const refundAmount = Math.max(0, totalPaid - totalPrice);

        console.log('Calculated values:', { totalPaid, refundAmount });

        // Always allow submission - just show warnings
        if (refundAmount > 0 && noteField.value.trim() === '') {
            showCopyMessage('تحذير: يفضل إدخال ملاحظة عندما يكون هناك مبلغ مستحق للزبون', 'warning');
        }

        console.log('Form validation completed - allowing submission');
        return true;
    } catch (error) {
        console.error('Error in form validation:', error);
        return true; // Always allow submission
    }
}

// Function to set suggested total
function setSuggestedTotal(amount) {
    const totalPriceElement = document.getElementById('total_price');
    if (totalPriceElement) {
        totalPriceElement.value = amount.toFixed(2);

        // Clear other amount fields
        const amountBankElement = document.getElementById('amount_bank');
        const amountCashElement = document.getElementById('amount_cash');
        if (amountBankElement) amountBankElement.value = '';
        if (amountCashElement) amountCashElement.value = '';

        // Trigger calculation immediately
        setTimeout(function() {
            try {
                if (typeof calculateAmounts === 'function') {
                    calculateAmounts();
                }
            } catch (error) {
                console.error('Error in setSuggestedTotal calculation:', error);
            }
        }, 10);

        // Show success message
        showCopyMessage('تم تعيين السعر الإجمالي المقترح بنجاح');
    } else {
        console.warn('Total price element not found');
        showCopyMessage('حدث خطأ في النظام', 'danger');
    }
}

// Function to set remaining amount as total price
function setRemainingAsTotal(presetAmount) {
    const totalPriceElement = document.getElementById('total_price');
    if (!totalPriceElement) {
        console.warn('Total price element not found');
        showCopyMessage('حدث خطأ في النظام', 'danger');
        return;
    }

    let amount = typeof presetAmount === 'number' ? presetAmount : parseFloat(presetAmount);
    if (isNaN(amount)) {
        const remainingInput = document.getElementById('remaining_amount');
        amount = remainingInput ? parseFloat(remainingInput.value) : 0;
    }

    amount = isNaN(amount) ? 0 : amount;
    totalPriceElement.value = amount.toFixed(2);

    const amountBankElement = document.getElementById('amount_bank');
    const amountCashElement = document.getElementById('amount_cash');
    if (amountBankElement) amountBankElement.value = '';
    if (amountCashElement) amountCashElement.value = '';

    setTimeout(function() {
        try {
            if (typeof calculateAmounts === 'function') {
                calculateAmounts();
            }
        } catch (error) {
            console.error('Error in setRemainingAsTotal calculation:', error);
        }
    }, 10);

    showCopyMessage('تم تعيين المبلغ المتبقي كإجمالي الفاتورة');
}

// Function to copy total price to bank amount
function copyTotalToBank() {
    const totalPriceElement = document.getElementById('total_price');
    const amountBankElement = document.getElementById('amount_bank');
    const amountCashElement = document.getElementById('amount_cash');

            if (totalPriceElement && amountBankElement && amountCashElement) {
            const totalPrice = totalPriceElement.value;
            if (totalPrice && totalPrice > 0) {
                amountBankElement.value = parseFloat(totalPrice).toFixed(2);
                amountCashElement.value = '';

            // Trigger calculation immediately
            setTimeout(function() {
                try {
                    if (typeof calculateAmounts === 'function') {
                        calculateAmounts();
                    }
                } catch (error) {
                    console.error('Error in copyTotalToBank calculation:', error);
                }
            }, 10);

            // Show success message
            showCopyMessage('تم نسخ السعر الإجمالي إلى حقل الدفع البنكي بنجاح');
        } else {
            showCopyMessage('يرجى التأكد من وجود سعر إجمالي صحيح', 'warning');
        }
    } else {
        console.warn('Some form elements are missing');
        showCopyMessage('حدث خطأ في النظام', 'danger');
    }
}

// Function to copy total price to cash amount
function copyTotalToCash() {
    const totalPriceElement = document.getElementById('total_price');
    const amountCashElement = document.getElementById('amount_cash');
    const amountBankElement = document.getElementById('amount_bank');

            if (totalPriceElement && amountCashElement && amountBankElement) {
            const totalPrice = totalPriceElement.value;
            if (totalPrice && totalPrice > 0) {
                amountCashElement.value = parseFloat(totalPrice).toFixed(2);
                amountBankElement.value = '';

            // Trigger calculation immediately
            setTimeout(function() {
                try {
                    if (typeof calculateAmounts === 'function') {
                        calculateAmounts();
                    }
                } catch (error) {
                    console.error('Error in copyTotalToCash calculation:', error);
                }
            }, 10);

            // Show success message
            showCopyMessage('تم نسخ السعر الإجمالي إلى حقل الدفع النقدي بنجاح');
        } else {
            showCopyMessage('يرجى التأكد من وجود سعر إجمالي صحيح', 'warning');
        }
    } else {
        console.warn('Some form elements are missing');
        showCopyMessage('حدث خطأ في النظام', 'danger');
    }
}

// Function to show copy message
function showCopyMessage(message, type = 'success') {
    try {
        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        messageDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        
        const iconClass = type === 'success' ? 'check-circle' : 
                         type === 'danger' ? 'exclamation-triangle' : 
                         type === 'warning' ? 'exclamation-triangle' : 'info-circle';
        
        messageDiv.innerHTML = `
            <i class="bi bi-${iconClass}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Add to page
        document.body.appendChild(messageDiv);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 3000);
    } catch (error) {
        console.warn('Error showing message:', error);
        // Fallback to alert if there's an error
        alert(message);
    }
}

// Function to highlight custom internet cost
function highlightCustomInternetCost() {
    try {
        const customCostElements = document.querySelectorAll('.badge.bg-warning');
        customCostElements.forEach(element => {
            element.style.animation = 'pulse 2s infinite';
        });
    } catch (error) {
        console.warn('Error highlighting custom internet cost:', error);
    }
}

// Initialize highlighting on page load
document.addEventListener('DOMContentLoaded', function() {
    try {
        highlightCustomInternetCost();
        // Initialize invoice preview
        updateInvoicePreview();
    } catch (error) {
        console.warn('Error initializing highlighting:', error);
    }
});

// Function to detect phone number from session
function detectPhoneNumber() {
    try {
        const phoneInput = document.getElementById('customer_phone');
        const sessionUserPhone = '{{ $sessionPayment->session->user->phone ?? "" }}';
        
        if (sessionUserPhone) {
            phoneInput.value = sessionUserPhone;
            showCopyMessage('تم استخراج رقم الهاتف من بيانات الجلسة', 'success');
        } else {
            showCopyMessage('لا يوجد رقم هاتف مسجل في بيانات الجلسة', 'warning');
        }
    } catch (error) {
        console.error('Error detecting phone number:', error);
        showCopyMessage('حدث خطأ في استخراج رقم الهاتف', 'danger');
    }
}

// Function to generate invoice text
function generateInvoiceText() {
    try {
        const customMessage = document.getElementById('invoice_message').value || '';
        const totalPrice = document.getElementById('total_price').value || '0';
        const amountBank = document.getElementById('amount_bank').value || '0';
        const amountCash = document.getElementById('amount_cash').value || '0';
        const paymentStatus = document.getElementById('payment_status');
        const paymentStatusText = paymentStatus ? paymentStatus.options[paymentStatus.selectedIndex].text : 'غير محدد';
        
        // Get session details
        const sessionId = '{{ $sessionPayment->session->id ?? "" }}';
        const userName = '{{ $sessionPayment->session->user->name ?? "العميل" }}';
        const sessionDate = '{{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format("Y-m-d H:i") : "" }}';
        const sessionCategory = '{{ $sessionPayment->session->session_category ?? "" }}';
        
        // Calculate costs
        const internetCost = {{ $sessionPayment->session ? $sessionPayment->session->calculateInternetCost() : 0 }};
        const drinksCost = {{ $sessionPayment->session ? $sessionPayment->session->drinks->sum('price') : 0 }};
        const totalPaid = parseFloat(amountBank) + parseFloat(amountCash);
        const remaining = Math.max(0, parseFloat(totalPrice) - totalPaid);
        
        // Generate invoice text
        let invoiceText = '';
        
        if (customMessage) {
            invoiceText += customMessage + '\n\n';
        }
        
        invoiceText += `📋 *فاتورة الجلسة*\n`;
        invoiceText += `━━━━━━━━━━━━━━━━━━━━\n\n`;
        invoiceText += `🆔 رقم الجلسة: #${sessionId}\n`;
        invoiceText += `👤 العميل: ${userName}\n`;
        invoiceText += `📅 تاريخ الجلسة: ${sessionDate}\n`;
        invoiceText += `🏷️ نوع الجلسة: ${getSessionCategoryText(sessionCategory)}\n\n`;
        
        invoiceText += `💰 *تفاصيل التكلفة:*\n`;
        invoiceText += `🌐 تكلفة الإنترنت: $${internetCost.toFixed(2)}\n`;
        invoiceText += `☕ تكلفة المشروبات: $${drinksCost.toFixed(2)}\n`;
        invoiceText += `📊 السعر الإجمالي: $${parseFloat(totalPrice).toFixed(2)}\n\n`;
        
        invoiceText += `💳 *تفاصيل الدفع:*\n`;
        invoiceText += `🏦 دفع بنكي: $${parseFloat(amountBank).toFixed(2)}\n`;
        invoiceText += `💵 دفع نقدي: $${parseFloat(amountCash).toFixed(2)}\n`;
        invoiceText += `✅ إجمالي المدفوع: $${totalPaid.toFixed(2)}\n`;
        
        if (remaining > 0) {
            invoiceText += `⚠️ المبلغ المتبقي: $${remaining.toFixed(2)}\n`;
        }
        
        invoiceText += `📋 حالة الدفع: ${paymentStatusText}\n\n`;
        
        invoiceText += `━━━━━━━━━━━━━━━━━━━━\n`;
        invoiceText += `📞 للاستفسار: {{ config('app.phone', '966501234567') }}\n`;
        invoiceText += `🌐 {{ config('app.name', 'BranchHUB') }}\n`;
        invoiceText += `━━━━━━━━━━━━━━━━━━━━`;
        
        return invoiceText;
    } catch (error) {
        console.error('Error generating invoice text:', error);
        return 'حدث خطأ في إنشاء الفاتورة';
    }
}

// Function to get session category text
function getSessionCategoryText(category) {
    const categories = {
        'hourly': 'ساعي',

        'subscription': 'اشتراك',
        'overtime': 'إضافي'
    };
    return categories[category] || category;
}

// Function to update invoice preview
function updateInvoicePreview() {
    try {
        const previewElement = document.getElementById('invoice_preview');
        if (previewElement) {
            const invoiceText = generateInvoiceText();
            // Convert line breaks to HTML
            const htmlText = invoiceText.replace(/\n/g, '<br>');
            previewElement.innerHTML = htmlText;
        }
    } catch (error) {
        console.error('Error updating invoice preview:', error);
    }
}

// Function to export to WhatsApp
function exportToWhatsApp() {
    try {
        const phoneInput = document.getElementById('customer_phone');
        const phone = phoneInput.value.trim();
        
        if (!phone) {
            showCopyMessage('يرجى إدخال رقم الهاتف', 'warning');
            phoneInput.focus();
            return;
        }
        
        // Validate phone number format
        if (!/^\d{10,15}$/.test(phone.replace(/\D/g, ''))) {
            showCopyMessage('يرجى إدخال رقم هاتف صحيح', 'warning');
            phoneInput.focus();
            return;
        }
        
        const invoiceText = generateInvoiceText();
        const whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(invoiceText)}`;
        
        // Open WhatsApp in new tab
        window.open(whatsappUrl, '_blank');
        
        showCopyMessage('تم فتح الواتساب مع الفاتورة', 'success');
        
    } catch (error) {
        console.error('Error exporting to WhatsApp:', error);
        showCopyMessage('حدث خطأ في فتح الواتساب', 'danger');
    }
}

// Function to copy invoice text
function copyInvoiceText() {
    try {
        const invoiceText = generateInvoiceText();
        
        // Use clipboard API if available
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(invoiceText).then(() => {
                showCopyMessage('تم نسخ نص الفاتورة إلى الحافظة', 'success');
            }).catch(() => {
                fallbackCopyTextToClipboard(invoiceText);
            });
        } else {
            fallbackCopyTextToClipboard(invoiceText);
        }
    } catch (error) {
        console.error('Error copying invoice text:', error);
        showCopyMessage('حدث خطأ في نسخ النص', 'danger');
    }
}

// Fallback function for copying text
function fallbackCopyTextToClipboard(text) {
    try {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        const successful = document.execCommand('copy');
        document.body.removeChild(textArea);
        
        if (successful) {
            showCopyMessage('تم نسخ نص الفاتورة إلى الحافظة', 'success');
        } else {
            showCopyMessage('فشل في نسخ النص، يرجى النسخ يدوياً', 'warning');
        }
    } catch (error) {
        console.error('Error in fallback copy:', error);
        showCopyMessage('حدث خطأ في نسخ النص', 'danger');
    }
}

// Add event listeners for real-time preview updates
document.addEventListener('DOMContentLoaded', function() {
    try {
        const invoiceMessage = document.getElementById('invoice_message');
        if (invoiceMessage) {
            invoiceMessage.addEventListener('input', updateInvoicePreview);
        }
        
        // Update preview when payment details change
        const totalPrice = document.getElementById('total_price');
        const amountBank = document.getElementById('amount_bank');
        const amountCash = document.getElementById('amount_cash');
        const paymentStatus = document.getElementById('payment_status');
        
        if (totalPrice) totalPrice.addEventListener('input', updateInvoicePreview);
        if (amountBank) amountBank.addEventListener('input', updateInvoicePreview);
        if (amountCash) amountCash.addEventListener('input', updateInvoicePreview);
        if (paymentStatus) paymentStatus.addEventListener('change', updateInvoicePreview);
        
    } catch (error) {
        console.error('Error setting up invoice preview listeners:', error);
    }
});
</script>
@endsection
