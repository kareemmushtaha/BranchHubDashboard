@extends('layouts.app')

@section('title', 'تفاصيل الجلسة')

@section('styles')
<style>
.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.alert-sm .bi {
    font-size: 0.875rem;
}

.badge.bg-info {
    background-color: #17a2b8 !important;
}

.text-info {
    color: #17a2b8 !important;
}

.fw-bold {
    font-weight: 600 !important;
}
</style>
@endsection

@section('content')
@if($session->session_status == 'completed')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
        <div>
            <strong>تنبيه!</strong> هذه الجلسة منتهية ومكتملة. لا يمكن تعديل بعض البيانات إلا بعد التأكد من حالة الدفع.
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($session->session_status == 'active' && $session->start_at->isFuture())
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="bi bi-clock-history me-2 fs-4"></i>
        <div>
            <strong>معلومات!</strong> هذه الجلسة نشطة ولكن لم تبدأ بعد. تاريخ ووقت بدايتها هو: <strong>{{ $session->start_at->format('Y-m-d H:i:s') }}</strong>
            <br>
            <small class="text-muted">
                الوقت المتبقي حتى البداية: <span class="fw-bold">{{ $session->start_at->diffForHumans() }}</span>
            </small>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تفاصيل الجلسة #{{ $session->id }}</h1>
    <div>
                        @if($session->session_status == 'active')
                            @if($session->start_at->isFuture())
                                <div class="alert alert-info alert-sm mb-2">
                                    <i class="bi bi-info-circle"></i>
                                    <small>هذه الجلسة نشطة ولكن لم تبدأ بعد. يمكن تعديلها أو إلغاؤها قبل بدايتها.</small>
                                </div>
                            @endif

                            @if($session->isSubscription())
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateExpectedEndDateModal">
                                    <i class="bi bi-calendar-plus"></i> تحديث تاريخ الانتهاء
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#endSubscriptionModal">
                                    <i class="bi bi-stop-circle"></i> إنهاء الجلسة
                                </button>
                            @else
                                <form action="{{ route('sessions.end', $session) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" onclick="return confirm('هل تريد إنهاء هذه الجلسة؟')">
                                        <i class="bi bi-stop-circle"></i> إنهاء الجلسة
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('sessions.edit', $session) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                        @endif
        <!-- زر تصدير PDF - متاح لجميع الجلسات التي لديها مدفوعة -->
        @if($session->payment)
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#invoiceDateModal">
                <i class="bi bi-file-pdf"></i> تصدير PDF
            </button>
            <a href="{{ route('session-payments.invoice.show', $session->payment->id) }}" target="_blank" class="btn btn-info">
                <i class="bi bi-printer"></i> عرض للطباعة
            </a>
        @endif

        <a href="{{ route('sessions.audit', $session) }}" class="btn btn-info">
            <i class="bi bi-clock-history"></i> سجلات التدقيق
        </a>
        <a href="{{ route('sessions.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <!-- معلومات الجلسة -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات الجلسة</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6"><strong>رقم الجلسة:</strong></div>
                    <div class="col-sm-6">#{{ $session->id }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>المستخدم:</strong></div>
                    <div class="col-sm-6">
                        @if($session->user)
                            <a href="{{ route('users.show', $session->user) }}" class="text-decoration-none">
                                <span class="text-primary fw-bold">{{ $session->user->name }}</span>
                                <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                            </a>
                        @else
                            <span class="text-muted">غير محدد</span>
                        @endif
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-6"><strong>فئة الجلسة:</strong></div>
                    <div class="col-sm-6">
                        @if($session->session_category == 'hourly')
                            <span class="badge bg-info">ساعي</span>

                        @elseif($session->session_category == 'subscription')
                            <span class="badge bg-success">اشتراك</span>
                        @else
                            <span class="badge bg-secondary">إضافي</span>
                        @endif
                    </div>
                </div>
                <hr>
                @if($session->session_owner)
                <div class="row">
                    <div class="col-sm-6"><strong>صاحب الجلسة:</strong></div>
                    <div class="col-sm-6">
                        <span class="text-primary fw-bold">{{ $session->session_owner }}</span>
                    </div>
                </div>
                <hr>
                @endif
                <div class="row">
                    <div class="col-sm-6"><strong>أنشأها:</strong></div>
                    <div class="col-sm-6">
                        @if($session->creator)
                            <span class="text-info fw-bold">
                                <i class="bi bi-person-plus"></i>
                                {{ $session->creator->name }}
                            </span>
                            @if($session->created_at)
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i>
                                    {{ $session->created_at->format('Y-m-d H:i:s') }}
                                </small>
                            @endif
                        @else
                            <span class="text-muted">
                                <i class="bi bi-question-circle"></i>
                                غير محدد (جلسة قديمة)
                            </span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>الحالة:</strong></div>
                    <div class="col-sm-6">
                        @if($session->session_status == 'active')
                            @if($session->start_at->isFuture())
                                <span class="badge bg-info">نشط - لم يبدأ بعد</span>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i>
                                    يبدأ {{ $session->start_at->diffForHumans() }}
                                </small>
                            @else
                                <span class="badge bg-success">نشط</span>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-play-circle"></i>
                                    بدأت {{ $session->start_at->diffForHumans() }}
                                </small>
                            @endif
                        @elseif($session->session_status == 'completed')
                            <span class="badge bg-primary">مكتمل</span>
                        @else
                            <span class="badge bg-danger">ملغي</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>بداية الجلسة:</strong></div>
                    <div class="col-sm-6">
                        {{ $session->start_at->format('Y-m-d H:i:s') }}
                        @if($session->start_at->isFuture())
                            <br>
                            <span class="badge bg-info">
                                <i class="bi bi-clock"></i>
                                لم تبدأ بعد
                            </span>
                            <br>
                            <small class="text-muted">
                                الوقت المتبقي: <span class="fw-bold">{{ $session->start_at->diffForHumans() }}</span>
                            </small>
                        @elseif($session->session_status == 'active')
                            <br>
                            <span class="badge bg-success">
                                <i class="bi bi-play-circle"></i>
                                بدأت {{ $session->start_at->diffForHumans() }}
                            </span>
                        @endif
                        @if($session->session_status == 'active')
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#editStartTimeModal">
                                <i class="bi bi-pencil"></i> تعديل
                            </button>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>نهاية الجلسة:</strong></div>
                    <div class="col-sm-6">
                        @if($session->end_at)
                            {{ $session->end_at->format('Y-m-d H:i:s') }}
                        @else
                            <span class="text-success">لا تزال نشطة</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong> المنقضيةالمدة:</strong></div>
                    <div class="col-sm-6">
                        @if($session->start_at->isFuture())
                            <span class="text-info">
                                <i class="bi bi-clock"></i>
                                لم تبدأ بعد
                            </span>
                            <br>
                            <small class="text-muted">
                                ستبدأ {{ $session->start_at->diffForHumans() }}
                            </small>
                        @elseif($session->end_at)
                            {{ $session->formatDuration($session->end_at) }}
                        @else
                            {{ $session->formatDuration() }} (مستمرة)
                        @endif
                    </div>
                </div>

                <!-- المدة المتبقية -->
                @php
                    $expectedEndDate = $session->getExpectedEndDate();
                @endphp
                @if($expectedEndDate && !$session->end_at && $expectedEndDate->isFuture())
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>المدة المتبقية:</strong></div>
                    <div class="col-sm-6">
                        @php
                            $now = now();
                            $remainingDuration = $now->diff($expectedEndDate);
                            $remainingParts = [];
                            
                            if ($remainingDuration->days > 0) {
                                $remainingParts[] = $remainingDuration->days . ' يوم';
                            }
                            if ($remainingDuration->h > 0) {
                                $remainingParts[] = $remainingDuration->h . ' ساعة';
                            }
                            if ($remainingDuration->i > 0) {
                                $remainingParts[] = $remainingDuration->i . ' دقيقة';
                            }
                            if (empty($remainingParts)) {
                                $remainingParts[] = 'أقل من دقيقة';
                            }
                        @endphp
                        <span class="text-warning">
                            <i class="bi bi-hourglass-split"></i>
                            {{ implode(' و ', $remainingParts) }}
                        </span>
                        <br>
                        <small class="text-muted">
                            حتى {{ $expectedEndDate->format('Y-m-d H:i') }}
                        </small>
                    </div>
                </div>
                @endif

                <!-- التاريخ المتوقع للانتهاء -->
                @php
                    $expectedEndDate = $session->getExpectedEndDate();
                    $daysUntilEnd = $session->getDaysUntilExpectedEnd();
                    $isOverdue = $session->isOverdue();
                    $remainingDays = $session->getRemainingDays();
                @endphp

                @if($expectedEndDate)
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>التاريخ المتوقع للانتهاء:</strong></div>
                    <div class="col-sm-6">
                        <span class="text-primary">{{ $expectedEndDate->format('Y-m-d') }}</span>
                        <br>
                        <small class="text-muted">{{ $expectedEndDate->format('H:i') }}</small>

                        @if($session->isSubscription() && $session->expected_end_date)
                            <br><span class="badge bg-secondary mt-1">
                                <i class="bi bi-calendar-check"></i>
                                محدد يدوياً
                            </span>
                        @endif

                        @if(!$session->end_at)
                            @if($isOverdue)
                                @php
                                    $overdueDays = max(1, abs(ceil($daysUntilEnd)));
                                    $overdueText = $overdueDays == 1 ? 'يوم واحد' : ($overdueDays . ' أيام');
                                @endphp
                                <br><span class="badge bg-danger mt-1">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    متأخرة {{ $overdueText }}
                                </span>
                            @elseif($daysUntilEnd !== null)
                                @php
                                    $remainingDays = ceil($daysUntilEnd);
                                @endphp
                                @if($remainingDays <= 0)
                                    <br><span class="badge bg-warning mt-1">
                                        <i class="bi bi-clock"></i>
                                        تنتهي اليوم
                                    </span>
                                @elseif($remainingDays == 1)
                                    <br><span class="badge bg-warning mt-1">
                                        <i class="bi bi-calendar-event"></i>
                                        تنتهي غداً
                                    </span>
                                @elseif($remainingDays > 0)
                                    <br><span class="badge bg-info mt-1">
                                        <i class="bi bi-calendar"></i>
                                        باقي {{ $remainingDays }} {{ $remainingDays == 1 ? 'يوم' : 'أيام' }}
                                    </span>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
                @endif

                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>ملاحظات:</strong></div>
                    <div class="col-sm-6">
                        @if($session->note)
                            <div class="mb-2">
                                {{ $session->note }}
                            </div>
                            @if($session->noteUpdater)
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-person-pencil"></i>
                                    كتبها: <span class="text-info fw-bold">{{ $session->noteUpdater->name }}</span>
                                    @if($session->updated_at)
                                        - {{ $session->updated_at->format('Y-m-d H:i:s') }}
                                    @endif
                                </small>
                            @endif
                        @else
                            <span class="text-muted">لا توجد ملاحظات</span>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" data-bs-toggle="modal" data-bs-target="#editNoteModal">
                            <i class="bi bi-pencil"></i> تعديل
                        </button>
                    </div>
                </div>

                <!-- معلومات إضافية للجلسات الاشتراكية -->
                @if($session->isSubscription())
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>نوع الجلسة:</strong></div>
                    <div class="col-sm-6">
                        <span class="badge bg-success">اشتراك</span>
                        <br>
                        <small class="text-muted">جلسة اشتراكية طويلة المدى</small>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>الأيام المتبقية:</strong></div>
                    <div class="col-sm-6">
                        @if($session->end_at)
                            <span class="text-muted">الجلسة منتهية</span>
                        @else
                            @php
                                $remainingDays = $session->getRemainingDays();
                            @endphp
                            @if($remainingDays !== null)
                                @if($remainingDays == 0)
                                    <span class="badge bg-warning subscription-info">تنتهي اليوم</span>
                                @elseif($remainingDays == 1)
                                    <span class="badge bg-warning subscription-info">تنتهي غداً</span>
                                @else
                                    <span class="badge bg-info subscription-info">{{ $remainingDays }} {{ $remainingDays == 1 ? 'يوم' : 'أيام' }}</span>
                                @endif
                            @else
                                <span class="text-muted subscription-info">غير محدد</span>
                            @endif
                        @endif
                    </div>
                </div>
                @endif

                <!-- تفاصيل تكلفة الإنترنت -->
                @php
                    $publicPrices = \App\Models\PublicPrice::first();
                    $sessionCost = $session->calculateInternetCost();
                    $hourlyRate = 0;
                    $duration = 0;

                    // حساب المدة والسعر بالساعة للعرض
                    $startTime = $session->start_at;
                    $endTime = $session->end_at ?? now();
                    $durationInMinutes = $startTime->diffInMinutes($endTime);
                    $duration = $durationInMinutes / 60;

                    switch ($session->session_category) {
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

                @if($session->session_category == 'hourly' || $session->session_category == 'overtime')
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>تكلفة الإنترنت:</strong></div>
                    <div class="col-sm-6">
                        @if($session->end_at)
                            <div class="text-primary fw-bold internet-cost-display">₪{{ number_format($sessionCost, 2) }}</div>
                            @if($session->hasCustomInternetCost())
                                <span class="badge bg-warning">مخصصة</span>
                            @endif
                            <small class="text-muted">
                                <span class="session-duration-display">{{ number_format($duration, 1) }} ساعة</span> × ₪{{ number_format($hourlyRate, 2) }}/ساعة
                                @if($session->session_category == 'overtime')
                                    <br>
                                    @if($session->start_at->hour >= 18 || $session->start_at->hour <= 6)
                                        <span class="badge bg-dark">سعر ليلي</span>
                                    @else
                                        <span class="badge bg-light text-dark">سعر صباحي</span>
                                    @endif
                                @endif
                            </small>
                        @else
                            <div class="text-muted internet-cost-display">سيتم حساب التكلفة عند انتهاء الجلسة</div>
                            <small class="text-muted">
                                السعر الحالي: ₪{{ number_format($hourlyRate, 2) }}/ساعة
                                @if($session->session_category == 'overtime')
                                    @if($session->start_at->hour >= 18 || $session->start_at->hour <= 6)
                                        <span class="badge bg-dark">سعر ليلي</span>
                                    @else
                                        <span class="badge bg-light text-dark">سعر صباحي</span>
                                    @endif
                                @endif
                            </small>
                        @endif

                        @if($session->session_status == 'active' || $session->session_status == 'completed')
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#editInternetCostModal">
                                <i class="bi bi-pencil"></i> تعديل التكلفة
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- تكلفة الإنترنت للجلسات الاشتراكية -->
                @if($session->isSubscription())
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>تكلفة الإنترنت:</strong></div>
                    <div class="col-sm-6">
                        @if($session->end_at)
                            <div class="text-primary fw-bold internet-cost-display">₪{{ number_format($session->calculateInternetCost(), 2) }}</div>
                            @if($session->hasCustomInternetCost())
                                <span class="badge bg-warning">مخصصة</span>
                            @else
                                <span class="badge bg-success">مجانية</span>
                            @endif
                        @else
                            <div class="text-muted internet-cost-display">
                                @if($session->hasCustomInternetCost())
                                    ₪{{ number_format($session->calculateInternetCost(), 2) }}
                                    <span class="badge bg-warning">مخصصة</span>
                                @else
                                    مجانية (اشتراك)
                                @endif
                            </div>
                        @endif

                        @if($session->session_status == 'active' || $session->session_status == 'completed')
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editInternetCostModal">
                                <i class="bi bi-pencil"></i> تعديل التكلفة
                            </button>
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle"></i>
                                يمكنك تحديد تكلفة ثابتة للإنترنت طوال فترة الاشتراك
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- معلومات الدفع -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات الدفع</h5>
            </div>
            <div class="card-body">
                @if($session->payment)
                <!-- تفصيل التكلفة -->
                @php
                    $drinksCost = $session->drinks->sum('price');
                    $internetCost = $session->calculateInternetCost();
                    $overtimeCost = $session->calculateOvertimeCost();
                @endphp

                <div class="row">
                    <div class="col-sm-6"><strong>تكلفة الإنترنت:</strong></div>
                    <div class="col-sm-6 internet-cost-display">₪{{ number_format($internetCost, 2) }}</div>
                </div>
                @if(!$session->user || $session->user->user_type != 'subscription')
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>تكلفة المشروبات:</strong></div>
                    <div class="col-sm-6">
                        <span class="text-primary fw-bold drinks-cost-display">₪{{ number_format($drinksCost, 2) }}</span>
                    </div>
                </div>
                @endif
                @if($overtimeCost > 0)
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>قيمة  (الساعات الإضافية):</strong></div>
                    <div class="col-sm-6">
                        <span class="text-primary fw-bold overtime-cost-display">₪{{ number_format($overtimeCost, 2) }}</span>
                    </div>
                </div>
                @endif
                <hr>
                <div class="row bg-light p-3 rounded border">
                    <div class="col-sm-6"><strong> اجمالي المبلغ المستحق:</strong></div>
                    <div class="col-sm-6">
                        <span class="fw-bold text-primary total-cost-display">₪{{ number_format($session->payment->total_price, 2) }}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>مدفوع بنك:</strong></div>
                    <div class="col-sm-6">₪{{ number_format($session->payment->amount_bank, 2) }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>مدفوع نقد:</strong></div>
                    <div class="col-sm-6">₪{{ number_format($session->payment->amount_cash, 2) }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>المتبقي:</strong></div>
                    <div class="col-sm-6 remaining-amount-display {{ max(0, $session->payment->remaining_amount) > 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                        ₪{{ number_format(max(0, $session->payment->remaining_amount), 2) }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>المبلغ المرتجع:</strong></div>
                    <div class="col-sm-6">
                        @php
                            $totalPaid = $session->payment->amount_bank + $session->payment->amount_cash;
                            // المبلغ المرتجع هو فقط المبلغ الزائد عن الفاتورة (يجب أن يكون موجباً)
                            $refundAmount = max(0, $totalPaid - $session->payment->total_price);
                        @endphp
                        @if($refundAmount > 0)
                            <span class="text-success fw-bold">
                                <i class="bi bi-arrow-down-circle"></i>
                                ₪{{ number_format($refundAmount, 2) }}
                                <small class="d-block text-muted">يجب إرجاعه للزبون</small>
                            </span>
                        @else
                            <span class="text-muted">
                                <i class="bi bi-check-circle"></i>
                                <small>لا يوجد مبلغ مرتجع</small>
                            </span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>حالة الدفع:</strong></div>
                    <div class="col-sm-6">
                        @if($session->payment->payment_status == 'pending')
                            <span class="badge bg-warning">معلق</span>
                        @elseif($session->payment->payment_status == 'paid')
                            <span class="badge bg-success">مدفوع</span>
                        @elseif($session->payment->payment_status == 'partial')
                            <span class="badge bg-info">مدفوع جزئياً</span>
                        @else
                            <span class="badge bg-danger">ملغي</span>
                        @endif
                    </div>
                </div>
                @if($session->session_status == 'active')
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>آخر تحديث:</strong></div>
                    <div class="col-sm-6">
                        <small class="text-muted" id="last-update-time">{{ now()->format('H:i:s') }}</small>
                    </div>
                </div>
                @endif
                @else
                <p class="text-muted">لم يتم إنشاء سجل دفع بعد</p>
                @endif

                <!-- أزرار إدارة المدفوعة -->
                <div class="mt-3">
                    @if($session->payment)
                             <a href="{{ route('session-payments.edit', $session->payment->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> تعديل المدفوعة
                            </a>

                        <a href="{{ route('session-payments.show', $session->payment->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye"></i> عرض تفاصيل المدفوعة
                        </a>

                        <!-- أزرار PDF والطباعة - متاحة لجميع الجلسات التي لديها مدفوعة -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#invoiceDateModal">
                            <i class="bi bi-file-pdf"></i> تصدير PDF
                        </button>
                        <a href="{{ route('session-payments.invoice.show', $session->payment->id) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="bi bi-printer"></i> عرض للطباعة
                        </a>


                    @else
                        <a href="{{ route('session-payments.create', ['session_id' => $session->id]) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> إنشاء مدفوعة
                        </a>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>



<!-- المشروبات -->
@if(!$session->user || $session->user->user_type != 'subscription')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">المشروبات المطلوبة</h5>
                @if($session->session_status == 'active' || $session->session_status == 'completed')
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDrinkModal">
                    <i class="bi bi-plus-circle"></i> إضافة مشروب
                </button>
                @endif
            </div>
            <div class="card-body">
                @if($session->drinks && $session->drinks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>المشروب</th>
                                <th>الكمية</th>
                                <th>سعر الواحد</th>
                                <th>السعر الإجمالي</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>الإجراءات</th>
                                <th>وقت الطلب</th>
                                @if($session->session_status == 'active' || $session->session_status == 'completed')
                                 @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($session->drinks as $sessionDrink)
                            <tr>
                                <td>{{ $sessionDrink->drink->name ?? 'غير محدد' }}</td>
                                <td>{{ $sessionDrink->quantity ?? 1 }}</td>
                                <td>
                                    ₪{{ number_format(($sessionDrink->price / ($sessionDrink->quantity ?? 1)), 2) }}
                                    @if($session->session_status == 'active' || $session->session_status == 'completed')
                                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#editDrinkPriceModal{{ $sessionDrink->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>₪{{ number_format($sessionDrink->price, 2) }}</td>
                                <td>
                                    @if($sessionDrink->status == 'ordered')
                                        <span class="badge bg-warning">مطلوب</span>
                                    @elseif($sessionDrink->status == 'served')
                                        <span class="badge bg-success">تم التقديم</span>
                                    @else
                                        <span class="badge bg-danger">ملغي</span>
                                    @endif
                                </td>

                                <td>{{ $sessionDrink->note ?: '-' }}</td>
                                <td>
                                    {{ $sessionDrink->created_at->format('Y-m-d H:i') }}
                                    @if($session->session_status == 'active' || $session->session_status == 'completed')
                                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#editDrinkDateModal{{ $sessionDrink->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    @endif
                                </td>
                                @if($session->session_status == 'active' || $session->session_status == 'completed')
                                <td>
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('sessions.remove-drink', ['session' => $session, 'sessionDrink' => $sessionDrink]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل تريد حذف هذا المشروب من الجلسة؟')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            <tr class="table-info">
                                <td><strong>إجمالي المشروبات:</strong></td>
                                <td><strong>{{ $session->drinks->sum('quantity') }}</strong></td>
                                <td></td>
                                <td><strong>₪{{ number_format($session->drinks->sum('price'), 2) }}</strong></td>
                                <td colspan="{{ $session->session_status == 'active' ? '5' : '4' }}"></td>
                            </tr>
                        </tbody>
                    </table>


                </div>
                @else
                <p class="text-muted text-center">لم يتم طلب أي مشروبات بعد</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@if( $session->user->user_type == 'subscription')
<!-- ساعات العمل الإضافية -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">ساعات العمل الإضافية</h5>
                @if($session->session_status == 'active' || $session->session_status == 'completed')
                <div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addOvertimeModal">
                        <i class="bi bi-plus-circle"></i> إضافة ساعات إضافية
                    </button>
                    <!-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editOvertimeRateModal">
                        <i class="bi bi-pencil"></i> ضبط السعر
                    </button> -->
                </div>
                @endif
            </div>
            <div class="card-body">
                @if($session->overtimes && $session->overtimes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>من</th>
                                <th>إلى</th>
                                <th>عدد الساعات</th>
                                <th>سعر الساعة</th>
                                <th>التكلفة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($session->overtimes as $overtime)
                            @php
                                $defaultRate = $overtime->getDefaultHourlyRate();
                                $displayRate = $overtime->hourly_rate ?? $defaultRate;
                                $displayCost = $overtime->cost > 0 ? $overtime->cost : ($overtime->total_hour * $displayRate);
                            @endphp
                            <tr>
                                <td>{{ $overtime->start_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $overtime->end_at->format('Y-m-d H:i') }}</td>
                                <td>{{ number_format($overtime->total_hour, 2) }} ساعة</td>
                                <td>
                                    @if($overtime->hourly_rate)
                                        ₪{{ number_format($overtime->hourly_rate, 2) }}
                                    @else
                                        <span class="text-muted">₪{{ number_format($defaultRate, 2) }} <small>(افتراضي)</small></span>
                                    @endif
                                </td>
                                <td><strong>₪{{ number_format($displayCost, 2) }}</strong></td>
                                <td>
                                    @if($session->session_status == 'active' || $session->session_status == 'completed')
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editOvertimeModal{{ $overtime->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('sessions.remove-overtime', ['session' => $session, 'overtime' => $overtime]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل تريد حذف هذه الساعات الإضافية؟')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <tr class="table-info">
                                <td colspan="3"><strong>إجمالي الساعات:</strong></td>
                                <td colspan="3"><strong>{{ number_format($session->overtimes->sum('total_hour'), 2) }} ساعة</strong></td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="3"><strong>إجمالي قيمة الساعات الإضافية:</strong></td>
                                <td colspan="3"><strong class="overtime-cost-display">₪{{ number_format($session->calculateOvertimeCost(), 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">لم يتم إضافة أي ساعات إضافية بعد</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
<!-- Modal إضافة مشروب -->
@if(($session->session_status == 'active' || $session->session_status == 'completed') && (!$session->user || $session->user->user_type != 'subscription'))
<div class="modal fade" id="addDrinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مشروب للجلسة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sessions.add-drink', $session) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="drink_id" class="form-label">المشروب</label>
                        <select class="form-select" id="drink_id" name="drink_id" required>
                            <option value="">اختر المشروب</option>
                            @foreach($drinks as $drink)
                            <option value="{{ $drink->id }}" data-price="{{ $drink->price }}">
                                {{ $drink->name }} - ₪{{ number_format($drink->price, 2) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">عدد المشروبات</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر الإجمالي</label>
                        <div class="form-control-plaintext" id="total_price_display">₪0.00</div>
                    </div>
                    <div class="mb-3">
                        <label for="drink_note" class="form-label">ملاحظات</label>
                        <input type="text" class="form-control" id="drink_note" name="note"
                               placeholder="ملاحظات إضافية (اختياري)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إضافة المشروب</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal تعديل تاريخ ووقت المشروب -->
@if(($session->session_status == 'active' || $session->session_status == 'completed') && (!$session->user || $session->user->user_type != 'subscription'))
@foreach($session->drinks as $sessionDrink)
<div class="modal fade" id="editDrinkDateModal{{ $sessionDrink->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل تاريخ ووقت المشروب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sessions.update-drink-date', ['session' => $session, 'sessionDrink' => $sessionDrink]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">المشروب:</label>
                        <div class="form-control-plaintext">{{ $sessionDrink->drink->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="drink_date_{{ $sessionDrink->id }}" class="form-label">تاريخ ووقت الطلب</label>
                        <input type="datetime-local" class="form-control" id="drink_date_{{ $sessionDrink->id }}"
                               name="created_at"
                               value="{{ $sessionDrink->created_at->format('Y-m-d\TH:i') }}" required>
                        <div class="form-text">اختر التاريخ والوقت الجديد لطلب المشروب</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">التاريخ والوقت الحالي:</label>
                        <div class="form-control-plaintext">{{ $sessionDrink->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

<!-- Modal تعديل سعر الواحدة والكمية -->
@if(($session->session_status == 'active' || $session->session_status == 'completed') && (!$session->user || $session->user->user_type != 'subscription'))
@foreach($session->drinks as $sessionDrink)
<div class="modal fade" id="editDrinkPriceModal{{ $sessionDrink->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل السعر والكمية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sessions.update-drink-price', ['session' => $session, 'sessionDrink' => $sessionDrink]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">المشروب:</label>
                        <div class="form-control-plaintext">{{ $sessionDrink->drink->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity_{{ $sessionDrink->id }}" class="form-label">الكمية</label>
                        <input type="number" step="1" min="1" class="form-control" id="quantity_{{ $sessionDrink->id }}" 
                               name="quantity" 
                               value="{{ $sessionDrink->quantity ?? 1 }}" required>
                        <div class="form-text">الكمية الحالية: {{ $sessionDrink->quantity ?? 1 }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="unit_price_{{ $sessionDrink->id }}" class="form-label">سعر الواحدة (₪)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="unit_price_{{ $sessionDrink->id }}" 
                               name="unit_price" 
                               value="{{ number_format(($sessionDrink->price / ($sessionDrink->quantity ?? 1)), 2, '.', '') }}" required>
                        <div class="form-text">السعر الحالي: ₪{{ number_format(($sessionDrink->price / ($sessionDrink->quantity ?? 1)), 2) }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر الإجمالي الحالي:</label>
                        <div class="form-control-plaintext">₪{{ number_format($sessionDrink->price, 2) }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر الإجمالي الجديد:</label>
                        <div class="form-control-plaintext fw-bold text-primary" id="new_total_price_{{ $sessionDrink->id }}">₪{{ number_format($sessionDrink->price, 2) }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

<!-- Modal تعديل تكلفة الإنترنت -->
<div class="modal fade" id="editInternetCostModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    @if($session->isSubscription())
                        تعديل تكلفة الإنترنت - جلسة اشتراكية
                    @else
                        تعديل تكلفة الإنترنت
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sessions.update-internet-cost-form', $session) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="bi bi-exclamation-triangle"></i> أخطاء:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="custom_internet_cost" class="form-label">تكلفة الإنترنت المخصصة</label>
                        <div class="input-group">
                            <span class="input-group-text">₪</span>
                            <input type="number" step="0.01" min="0"
                                   class="form-control @error('custom_internet_cost') is-invalid @enderror"
                                   id="custom_internet_cost"
                                   name="custom_internet_cost"
                                   value="{{ old('custom_internet_cost', $session->custom_internet_cost ?? ($session->isSubscription() ? '' : $sessionCost)) }}"
                                   placeholder="0.00">
                        </div>
                        @error('custom_internet_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            @if($session->isSubscription())
                                اترك الحقل فارغاً لجعل الإنترنت مجانياً، أو أدخل مبلغاً ثابتاً للإنترنت طوال فترة الاشتراك
                            @else
                                اترك الحقل فارغاً لاستخدام الحساب التلقائي
                            @endif
                        </small>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> معلومات:</h6>
                        <ul class="mb-0 small">
                            @if($session->isSubscription())
                                <li>نوع الجلسة: <span class="badge bg-success">اشتراك</span></li>
                                <li>التكلفة الافتراضية: مجانية (30 يوم)</li>
                                <li>المدة الحالية: {{ $session->formatDuration($session->end_at ?? now()) }}</li>
                                @if($session->expected_end_date)
                                    <li>التاريخ المتوقع للإنتهاء: {{ $session->expected_end_date->format('Y-m-d H:i') }}</li>
                                @endif
                                @if($session->hasCustomInternetCost())
                                    <li class="text-warning">هناك تكلفة مخصصة حالياً: ₪{{ number_format($session->custom_internet_cost, 2) }}</li>
                                @endif
                                <li class="text-primary"><strong>ملاحظة:</strong> التكلفة المخصصة ستكون ثابتة طوال فترة الاشتراك</li>
                            @else
                                <li>التكلفة التلقائية المحسوبة: ₪{{ number_format($sessionCost, 2) }}</li>
                                <li>المدة: {{ $session->formatDuration($session->end_at ?? now()) }}</li>
                                <li>السعر بالساعة: ₪{{ number_format($hourlyRate, 2) }}</li>
                                @if($session->hasCustomInternetCost())
                                    <li class="text-warning">هناك تكلفة مخصصة حالياً</li>
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const drinkSelect = document.getElementById('drink_id');
    const quantityInput = document.getElementById('quantity');
    const sessionId = {{ $session->id }};
    let updateInterval;

    // تحديث أسعار المشروبات
    function updateTotalPrice() {
        const selectedOption = drinkSelect.options[drinkSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value) || 1;
        const totalPrice = price * quantity;

        const totalPriceDisplay = document.getElementById('total_price_display');
        if (totalPriceDisplay) {
            totalPriceDisplay.textContent = '₪' + totalPrice.toFixed(2);
        }
    }

    // تحديث أسعار الجلسة بشكل ديناميكي
    function updateSessionPricing() {
        fetch(`/sessions/${sessionId}/pricing`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    updatePricingDisplay(data);
                } else {
                    console.error('خطأ في تحديث الأسعار:', data.message);
                }
            })
            .catch(error => {
                console.error('خطأ في تحديث الأسعار:', error);
            });
    }

    // تحديث عرض الأسعار
    function updatePricingDisplay(data) {
        // تحديث تكلفة الإنترنت
        const internetCostElements = document.querySelectorAll('.internet-cost-display');
        internetCostElements.forEach(element => {
            element.textContent = '₪' + data.pricing.internet_cost;
        });

        // تحديث تكلفة المشروبات
        const drinksCostElements = document.querySelectorAll('.drinks-cost-display');
        drinksCostElements.forEach(element => {
            element.textContent = '₪' + data.pricing.drinks_cost;
        });

        // تحديث تكلفة الساعات الإضافية
        const overtimeCostElements = document.querySelectorAll('.overtime-cost-display');
        overtimeCostElements.forEach(element => {
            element.textContent = '₪' + (data.pricing.overtime_cost || '0.00');
        });

        // تحديث التكلفة الإجمالية
        const totalCostElements = document.querySelectorAll('.total-cost-display');
        totalCostElements.forEach(element => {
            element.textContent = '₪' + data.pricing.total_cost;
        });

        // تحديث المدة
        const durationElements = document.querySelectorAll('.session-duration-display');
        durationElements.forEach(element => {
            element.textContent = data.duration;
        });

        // تحديث المبلغ المتبقي
        const remainingElements = document.querySelectorAll('.remaining-amount-display');
        const remainingAmount = Math.max(0, parseFloat(data.pricing.remaining_amount) || 0);
        
        remainingElements.forEach(element => {
            element.textContent = '₪' + remainingAmount.toFixed(2);
            if (remainingAmount > 0) {
                element.className = 'remaining-amount-display text-danger fw-bold';
            } else {
                element.className = 'remaining-amount-display text-success fw-bold';
            }
        });

        // تحديث وقت آخر تحديث
        const lastUpdateElement = document.getElementById('last-update-time');
        if (lastUpdateElement) {
            lastUpdateElement.textContent = new Date().toLocaleTimeString('ar-SA');
        }

        // تحديث معلومات الجلسات الاشتراكية
        if (data.session_info && data.session_info.is_subscription) {
            // تحديث شارات الجلسات الاشتراكية
            const subscriptionBadges = document.querySelectorAll('.subscription-info');
            subscriptionBadges.forEach(badge => {
                if (data.session_info.remaining_days !== null) {
                    if (data.session_info.remaining_days <= 0) {
                        badge.innerHTML = '<span class="badge bg-warning">تنتهي اليوم</span>';
                    } else if (data.session_info.remaining_days == 1) {
                        badge.innerHTML = '<span class="badge bg-warning">تنتهي غداً</span>';
                    } else {
                        badge.innerHTML = `<span class="badge bg-info">${data.session_info.remaining_days} يوم</span>`;
                    }
                }
            });
        }
    }

    // تحديث تكلفة الإنترنت يدوياً
    function updateInternetCost() {
        // إظهار رسالة تحميل
        showNotification('جاري تحديث تكلفة الإنترنت...', 'info');

        fetch(`/sessions/${sessionId}/update-internet-cost`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);

            if (data.success) {
                // تحديث العرض
                updateSessionPricing();

                // إظهار رسالة نجاح مع التفاصيل
                const message = `تم تحديث تكلفة الإنترنت بنجاح - التكلفة: ₪${data.internet_cost}`;
                showNotification(message, 'success');
            } else {
                showNotification(data.message || 'حدث خطأ أثناء تحديث التكلفة', 'error');
            }
        })
        .catch(error => {
            console.error('خطأ في تحديث تكلفة الإنترنت:', error);
            showNotification('حدث خطأ في الاتصال: ' + error.message, 'error');
        });
    }

    // إظهار إشعار
    function showNotification(message, type) {
        // تحديد لون الإشعار
        let alertClass, iconClass;
        switch (type) {
            case 'success':
                alertClass = 'alert-success';
                iconClass = 'check-circle';
                break;
            case 'error':
                alertClass = 'alert-danger';
                iconClass = 'exclamation-triangle';
                break;
            case 'info':
                alertClass = 'alert-info';
                iconClass = 'info-circle';
                break;
            case 'warning':
                alertClass = 'alert-warning';
                iconClass = 'exclamation-triangle';
                break;
            default:
                alertClass = 'alert-info';
                iconClass = 'info-circle';
        }

        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 500px;';
        notification.innerHTML = `
            <i class="bi bi-${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // إزالة الإشعار بعد 4 ثوان
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 4000);
    }

    // إضافة أزرار التحديث
    function addUpdateButtons() {
        const pricingSection = document.querySelector('.card-body');
        if (pricingSection && {{ $session->session_status === 'active' ? 'true' : 'false' }}) {
            // إنشاء حاوية للأزرار
            const buttonContainer = document.createElement('div');
            buttonContainer.className = 'mt-3 p-2 bg-light rounded';
            buttonContainer.innerHTML = '<small class="text-muted mb-2 d-block">تحديث الأسعار:</small>';

            const updateButton = document.createElement('button');
            updateButton.className = 'btn btn-sm btn-outline-primary me-2';
            updateButton.innerHTML = '<i class="bi bi-arrow-clockwise"></i> تحديث الآن';
            updateButton.onclick = updateInternetCost;

            const autoUpdateToggle = document.createElement('button');
            autoUpdateToggle.className = 'btn btn-sm btn-outline-success';
            autoUpdateToggle.innerHTML = '<i class="bi bi-play-circle"></i> التحديث التلقائي';
            autoUpdateToggle.onclick = toggleAutoUpdate;

            buttonContainer.appendChild(updateButton);
            buttonContainer.appendChild(autoUpdateToggle);
            pricingSection.appendChild(buttonContainer);
        }
    }

    // تبديل التحديث التلقائي
    function toggleAutoUpdate() {
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
            showNotification('تم إيقاف التحديث التلقائي', 'info');

            // تحديث نص الزر
            const button = event.target;
            button.innerHTML = '<i class="bi bi-play-circle"></i> التحديث التلقائي';
            button.className = 'btn btn-sm btn-outline-success mt-2 ms-2';
        } else {
            updateInterval = setInterval(updateSessionPricing, 30000); // تحديث كل 30 ثانية
            showNotification('تم تفعيل التحديث التلقائي', 'success');

            // تحديث نص الزر
            const button = event.target;
            button.innerHTML = '<i class="bi bi-pause-circle"></i> إيقاف التحديث';
            button.className = 'btn btn-sm btn-outline-warning mt-2 ms-2';
        }
    }

    // تهيئة النظام
    if (drinkSelect) {
        drinkSelect.addEventListener('change', updateTotalPrice);
    }

    if (quantityInput) {
        quantityInput.addEventListener('input', updateTotalPrice);
    }

    // إضافة أزرار التحديث
    addUpdateButtons();

    // تحديث أولي للأسعار
    updateSessionPricing();

    // تحديث تلقائي كل دقيقة للجلسات النشطة
    if ({{ $session->session_status === 'active' ? 'true' : 'false' }}) {
        updateInterval = setInterval(updateSessionPricing, 60000);
    }

    // تحسينات للجلسات الاشتراكية
    @if($session->isSubscription())
    // تحديث التاريخ المتوقع للانتهاء
    const expectedEndDateInput = document.getElementById('expected_end_date');
    if (expectedEndDateInput) {
        expectedEndDateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const startDate = new Date('{{ $session->start_at->format("Y-m-d\TH:i") }}');

            if (selectedDate <= startDate) {
                alert('تاريخ انتهاء الجلسة يجب أن يكون بعد تاريخ البداية');
                this.value = '{{ $session->getExpectedEndDate()->format("Y-m-d\TH:i") }}';
            }
        });
    }

    // تحسين نافذة إنهاء الجلسة الاشتراكية
    const endTimeInput = document.getElementById('end_time');
    if (endTimeInput) {
        endTimeInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const startDate = new Date('{{ $session->start_at->format("Y-m-d\TH:i") }}');

            if (selectedDate <= startDate) {
                alert('وقت انتهاء الجلسة يجب أن يكون بعد وقت البداية');
                this.value = new Date().toISOString().slice(0, 16);
            }
        });
    }
    @endif
});
</script>

<!-- Modal تعديل تاريخ بداية الجلسة -->
<div class="modal fade" id="editStartTimeModal" tabindex="-1" aria-labelledby="editStartTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStartTimeModalLabel">تعديل تاريخ بداية الجلسة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sessions.update-start-time', $session) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>تنبيه:</strong> عند تغيير تاريخ بداية الجلسة، سيتم إعادة حساب تكلفة الإنترنت تلقائياً إذا لم تكن هناك تكلفة مخصصة.
                    </div>

                    <div class="mb-3">
                        <label for="start_time" class="form-label">تاريخ ووقت بداية الجلسة</label>
                        <input type="datetime-local" class="form-control" id="start_time" name="start_time"
                               value="{{ $session->start_at->format('Y-m-d\TH:i') }}" required>
                        <div class="form-text">اختر التاريخ والوقت الجديد لبداية الجلسة</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">التاريخ الحالي</label>
                        <div class="form-control-plaintext">{{ $session->start_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal تحديث التاريخ المتوقع لانتهاء الجلسة الاشتراكية -->
@if($session->isSubscription())
<div class="modal fade" id="updateExpectedEndDateModal" tabindex="-1" aria-labelledby="updateExpectedEndDateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateExpectedEndDateModalLabel">تحديث التاريخ المتوقع لانتهاء الجلسة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sessions.update-expected-end-date', $session) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>تنبيه:</strong> يمكنك تحديد تاريخ انتهاء مخصص للجلسة الاشتراكية. إذا لم تحدد تاريخاً، سيتم استخدام التاريخ الافتراضي (30 يوم من تاريخ البداية).
                    </div>

                    <div class="mb-3">
                        <label for="expected_end_date" class="form-label">التاريخ المتوقع للانتهاء</label>
                        <input type="datetime-local" class="form-control" id="expected_end_date" name="expected_end_date"
                               value="{{ $session->expected_end_date ? $session->expected_end_date->format('Y-m-d\TH:i') : $session->getExpectedEndDate()->format('Y-m-d\TH:i') }}" required>
                        <div class="form-text">اختر التاريخ والوقت المتوقع لانتهاء الجلسة</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">التاريخ الحالي المتوقع</label>
                        <div class="form-control-plaintext">
                            {{ $session->getExpectedEndDate()->format('Y-m-d H:i:s') }}
                            @if($session->expected_end_date)
                                <br><small class="text-muted">(محدد يدوياً)</small>
                            @else
                                <br><small class="text-muted">(تلقائي - 30 يوم)</small>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">تاريخ بداية الجلسة</label>
                        <div class="form-control-plaintext">{{ $session->start_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal إنهاء الجلسة الاشتراكية -->
<div class="modal fade" id="endSubscriptionModal" tabindex="-1" aria-labelledby="endSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="endSubscriptionModalLabel">إنهاء الجلسة الاشتراكية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sessions.end-subscription', $session) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>تنبيه:</strong> سيتم إنهاء الجلسة الاشتراكية نهائياً. لا يمكن التراجع عن هذا الإجراء.
                    </div>

                    <div class="mb-3">
                        <label for="end_time" class="form-label">وقت انتهاء الجلسة (اختياري)</label>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time"
                               value="{{ now()->format('Y-m-d\TH:i') }}">
                        <div class="form-text">اترك الحقل فارغاً لإنهاء الجلسة في الوقت الحالي</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">معلومات الجلسة</label>
                        <div class="form-control-plaintext">
                            <strong>المستخدم:</strong>
                            @if($session->user)
                                <a href="{{ route('users.show', $session->user) }}" class="text-decoration-none">
                                    <span class="text-primary fw-bold">{{ $session->user->name }}</span>
                                    <i class="bi bi-arrow-up-right text-muted ms-1"></i>
                                </a>
                            @else
                                <span class="text-muted">غير محدد</span>
                            @endif
                            <br>
                            <strong>تاريخ البداية:</strong> {{ $session->start_at->format('Y-m-d H:i:s') }}<br>
                            <strong>المدة الحالية:</strong> {{ $session->formatDuration() }}<br>
                          <strong>التاريخ المتوقع للانتهاء:</strong> {{ $session->getExpectedEndDate()->format('Y-m-d H:i:s') }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-stop-circle"></i> إنهاء الجلسة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // حساب السعر الإجمالي الجديد عند تعديل سعر الواحدة أو الكمية
    @if(($session->session_status == 'active' || $session->session_status == 'completed') && (!$session->user || $session->user->user_type != 'subscription'))
    @foreach($session->drinks as $sessionDrink)
    (function() {
        const unitPriceInput{{ $sessionDrink->id }} = document.getElementById('unit_price_{{ $sessionDrink->id }}');
        const quantityInput{{ $sessionDrink->id }} = document.getElementById('quantity_{{ $sessionDrink->id }}');
        const newTotalPriceDisplay{{ $sessionDrink->id }} = document.getElementById('new_total_price_{{ $sessionDrink->id }}');
        
        if (unitPriceInput{{ $sessionDrink->id }} && quantityInput{{ $sessionDrink->id }} && newTotalPriceDisplay{{ $sessionDrink->id }}) {
            function updateNewTotalPrice{{ $sessionDrink->id }}() {
                const unitPrice = parseFloat(unitPriceInput{{ $sessionDrink->id }}.value) || 0;
                const quantity = parseInt(quantityInput{{ $sessionDrink->id }}.value) || 1;
                const newTotalPrice = unitPrice * quantity;
                newTotalPriceDisplay{{ $sessionDrink->id }}.textContent = '₪' + newTotalPrice.toFixed(2);
            }
            
            unitPriceInput{{ $sessionDrink->id }}.addEventListener('input', updateNewTotalPrice{{ $sessionDrink->id }});
            unitPriceInput{{ $sessionDrink->id }}.addEventListener('change', updateNewTotalPrice{{ $sessionDrink->id }});
            quantityInput{{ $sessionDrink->id }}.addEventListener('input', updateNewTotalPrice{{ $sessionDrink->id }});
            quantityInput{{ $sessionDrink->id }}.addEventListener('change', updateNewTotalPrice{{ $sessionDrink->id }});
        }
    })();
    @endforeach
    @endif
});
</script>

<!-- Modal إضافة ساعات إضافية -->
@if($session->session_status == 'active' || $session->session_status == 'completed')
<div class="modal fade" id="addOvertimeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة ساعات عمل إضافية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sessions.add-overtime', $session) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="overtime_start_at" class="form-label">من (تاريخ ووقت)</label>
                        <input type="datetime-local" class="form-control" id="overtime_start_at" name="start_at" required>
                    </div>
                    <div class="mb-3">
                        <label for="overtime_end_at" class="form-label">إلى (تاريخ ووقت)</label>
                        <input type="datetime-local" class="form-control" id="overtime_end_at" name="end_at" required>
                    </div>
                    @php
                        $publicPrices = \App\Models\PublicPrice::first();
                        $defaultOvertimeRate = $session->custom_overtime_rate ?? ($publicPrices->overtime_rate ?? 5.00);
                    @endphp
                    <div class="mb-3">
                        <label for="overtime_hourly_rate" class="form-label">سعر الساعة (₪) <small class="text-muted">(اختياري)</small></label>
                        <div class="input-group">
                            <span class="input-group-text">₪</span>
                            <input type="number" step="0.01" min="0" class="form-control" 
                                   id="overtime_hourly_rate" name="hourly_rate" 
                                   placeholder="{{ number_format($defaultOvertimeRate, 2) }}">
                        </div>
                        <small class="form-text text-muted">
                            اترك الحقل فارغاً لاستخدام السعر التلقائي: ₪{{ number_format($defaultOvertimeRate, 2) }}/ساعة
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="overtime_notes" class="form-label">ملاحظات <small class="text-muted">(اختياري)</small></label>
                        <textarea class="form-control" id="overtime_notes" name="notes" rows="3" placeholder="أدخل أي ملاحظات إضافية..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        سيتم حساب عدد الساعات والتكلفة تلقائياً بناءً على التاريخ والوقت المحددين.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal تعديل سعر الـ overtime -->
<div class="modal fade" id="editOvertimeRateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ضبط سعر الساعات الإضافية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sessions.update-overtime-rate', $session) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @php
                        $publicPrices = \App\Models\PublicPrice::first();
                        $defaultRate = $publicPrices->overtime_rate ?? 5.00;
                    @endphp
                    <div class="mb-3">
                        <label for="custom_overtime_rate" class="form-label">السعر لكل ساعة (₪)</label>
                        <div class="input-group">
                            <span class="input-group-text">₪</span>
                            <input type="number" step="0.01" min="0" class="form-control" 
                                   id="custom_overtime_rate" name="custom_overtime_rate" 
                                   value="{{ old('custom_overtime_rate', $session->custom_overtime_rate ?? '') }}"
                                   placeholder="{{ number_format($defaultRate, 2) }}">
                        </div>
                        <small class="form-text text-muted">
                            اترك الحقل فارغاً لاستخدام السعر الافتراضي: ₪{{ number_format($defaultRate, 2) }}/ساعة
                        </small>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>ملاحظة:</strong> السعر المخصص سيتم تطبيقه على جميع الساعات الإضافية لهذه الجلسة.
                    </div>
                    @if($session->overtimes->count() > 0)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>تنبيه:</strong> إجمالي الساعات الحالية: {{ number_format($session->overtimes->sum('total_hour'), 2) }} ساعة
                        <br>
                        القيمة الحالية: ₪{{ number_format($session->calculateOvertimeCost(), 2) }}
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal تعديل الملاحظة -->
<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNoteModalLabel">تعديل ملاحظة الجلسة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sessions.update-note', $session) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>ملاحظة:</strong> يمكنك تعديل ملاحظة الجلسة حتى لو كانت الجلسة منتهية.
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">ملاحظة الجلسة</label>
                        <textarea class="form-control @error('note') is-invalid @enderror" 
                                  id="note" 
                                  name="note" 
                                  rows="4" 
                                  placeholder="أدخل ملاحظة الجلسة (اختياري)">{{ old('note', $session->note) }}</textarea>
                        <small class="form-text text-muted">يمكنك ترك الحقل فارغاً لإزالة الملاحظة</small>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">معلومات الجلسة</label>
                        <div class="form-control-plaintext small">
                            <strong>رقم الجلسة:</strong> #{{ $session->id }}<br>
                            <strong>الحالة:</strong> 
                            @if($session->session_status == 'active')
                                <span class="badge bg-success">نشطة</span>
                            @elseif($session->session_status == 'completed')
                                <span class="badge bg-primary">مكتملة</span>
                            @else
                                <span class="badge bg-danger">ملغاة</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal تعديل ساعات العمل الإضافية -->
@if($session->session_status == 'active' || $session->session_status == 'completed')
@foreach($session->overtimes as $overtime)
<div class="modal fade" id="editOvertimeModal{{ $overtime->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل ساعات العمل الإضافية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sessions.update-overtime', ['session' => $session, 'overtime' => $overtime]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الساعات الحالية:</label>
                        <div class="form-control-plaintext">
                            من: {{ $overtime->start_at->format('Y-m-d H:i') }}<br>
                            إلى: {{ $overtime->end_at->format('Y-m-d H:i') }}<br>
                            المدة: {{ number_format($overtime->total_hour, 2) }} ساعة
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="overtime_start_at_{{ $overtime->id }}" class="form-label">من (تاريخ ووقت)</label>
                        <input type="datetime-local" class="form-control" 
                               id="overtime_start_at_{{ $overtime->id }}" 
                               name="start_at" 
                               value="{{ $overtime->start_at->format('Y-m-d\TH:i') }}" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="overtime_end_at_{{ $overtime->id }}" class="form-label">إلى (تاريخ ووقت)</label>
                        <input type="datetime-local" class="form-control" 
                               id="overtime_end_at_{{ $overtime->id }}"
                               name="end_at" 
                               value="{{ $overtime->end_at->format('Y-m-d\TH:i') }}" 
                               required>
                    </div>
                    @php
                        $defaultOvertimeRate = $overtime->getDefaultHourlyRate();
                    @endphp
                    <div class="mb-3">
                        <label for="overtime_hourly_rate_{{ $overtime->id }}" class="form-label">سعر الساعة (₪) <small class="text-muted">(اختياري)</small></label>
                        <div class="input-group">
                            <span class="input-group-text">₪</span>
                            <input type="number" step="0.01" min="0" class="form-control" 
                                   id="overtime_hourly_rate_{{ $overtime->id }}" 
                                   name="hourly_rate" 
                                   value="{{ old('hourly_rate', $overtime->hourly_rate ?? '') }}"
                                   placeholder="{{ number_format($defaultOvertimeRate, 2) }}">
                        </div>
                        <small class="form-text text-muted">
                            اترك الحقل فارغاً لاستخدام السعر التلقائي: ₪{{ number_format($defaultOvertimeRate, 2) }}/ساعة
                        </small>
                        @if($overtime->hourly_rate)
                        <div class="mt-2">
                            <small class="text-info">
                                <i class="bi bi-info-circle"></i> السعر الحالي: ₪{{ number_format($overtime->hourly_rate, 2) }}/ساعة
                            </small>
                        </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="overtime_notes_{{ $overtime->id }}" class="form-label">ملاحظات <small class="text-muted">(اختياري)</small></label>
                        <textarea class="form-control" id="overtime_notes_{{ $overtime->id }}" name="notes" rows="3" placeholder="أدخل أي ملاحظات إضافية...">{{ old('notes', $overtime->notes) }}</textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        سيتم إعادة حساب عدد الساعات والتكلفة تلقائياً بناءً على التاريخ والوقت المحددين.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

<!-- Modal لاختيار تاريخ إصدار الفاتورة -->
@if($session->payment)
<div class="modal fade" id="invoiceDateModal" tabindex="-1" aria-labelledby="invoiceDateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceDateModalLabel">
                    <i class="bi bi-calendar-event"></i> اختيار تاريخ إصدار الفاتورة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('session-payments.invoice', $session->payment->id) }}" method="GET" id="invoiceDateForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="invoice_date" class="form-label">
                            <strong>تاريخ إصدار الفاتورة:</strong>
                        </label>
                        <input type="date" 
                               class="form-control" 
                               id="invoice_date" 
                               name="invoice_date" 
                               value="{{ date('Y-m-d') }}" 
                               required>
                        <small class="form-text text-muted">
                            سيظهر هذا التاريخ في الفاتورة كتاريخ الإصدار
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> تصدير PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection