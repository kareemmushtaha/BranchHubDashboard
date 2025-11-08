@extends('layouts.app')

@section('title', 'تفاصيل مدفوعة الجلسة')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تفاصيل مدفوعة الجلسة #{{ $sessionPayment->id }}</h1>
    <div>
        @if($sessionPayment->session && $sessionPayment->session->session_status == 'completed')
            <a href="{{ route('session-payments.edit', $sessionPayment) }}" class="btn btn-warning me-2">
                <i class="bi bi-pencil"></i> تعديل
            </a>
        @else
            <button class="btn btn-warning me-2" disabled title="لا يمكن تعديل المدفوعة إلا بعد اكتمال الجلسة">
                <i class="bi bi-pencil"></i> تعديل
            </button>
        @endif
        <a href="{{ route('session-payments.invoice', $sessionPayment) }}" class="btn btn-danger me-2">
            <i class="bi bi-file-pdf"></i> تصدير PDF
        </a>
        <a href="{{ route('session-payments.invoice.show', $sessionPayment) }}" target="_blank" class="btn btn-info me-2">
            <i class="bi bi-printer"></i> عرض للطباعة
        </a>
        <a href="{{ route('session-payments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> العودة للقائمة
        </a>
    </div>
</div>

@if($sessionPayment->session && $sessionPayment->session->session_status !== 'completed')
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        <strong>تحذير:</strong> لا يمكن تعديل المدفوعة إلا بعد اكتمال الجلسة. 
        حالة الجلسة الحالية: 
        @if($sessionPayment->session->session_status == 'active')
            <span class="badge bg-success">نشط</span>
        @elseif($sessionPayment->session->session_status == 'cancelled')
            <span class="badge bg-danger">ملغي</span>
        @else
            <span class="badge bg-secondary">{{ $sessionPayment->session->session_status }}</span>
        @endif
    </div>
@endif

<div class="row">
    <!-- معلومات المدفوعة -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-credit-card"></i>
                    معلومات المدفوعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>رقم المدفوعة:</strong><br>
                        <span class="h5 text-primary">#{{ $sessionPayment->id }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>حالة الدفع:</strong><br>
                        @if($sessionPayment->payment_status == 'pending')
                            <span class="badge bg-warning fs-6">قيد الانتظار</span>
                        @elseif($sessionPayment->payment_status == 'paid')
                            <span class="badge bg-success fs-6">مدفوعة بالكامل</span>
                        @elseif($sessionPayment->payment_status == 'partial')
                            <span class="badge bg-info fs-6">مدفوعة جزئياً</span>
                        @else
                            <span class="badge bg-danger fs-6">ملغية</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>السعر الإجمالي:</strong><br>
                        <span class="h4 text-primary">${{ number_format($sessionPayment->total_price, 2) }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>المبلغ المتبقي:</strong><br>
                        @if($sessionPayment->remaining_amount > 0)
                            <span class="h4 text-danger">${{ number_format($sessionPayment->remaining_amount, 2) }}</span>
                        @else
                            <span class="h4 text-success">مدفوعة بالكامل</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>المدفوع بنكياً:</strong><br>
                        @if($sessionPayment->amount_bank > 0)
                            <span class="h5 text-info">${{ number_format($sessionPayment->amount_bank, 2) }}</span>
                        @else
                            <span class="text-muted">لا يوجد</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>المدفوع كاش:</strong><br>
                        @if($sessionPayment->amount_cash > 0)
                            <span class="h5 text-success">${{ number_format($sessionPayment->amount_cash, 2) }}</span>
                        @else
                            <span class="text-muted">لا يوجد</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>إجمالي المدفوع:</strong><br>
                        <span class="h5 text-dark">${{ number_format($sessionPayment->amount_bank + $sessionPayment->amount_cash, 2) }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>نسبة المدفوع:</strong><br>
                        @php
                            $percentage = $sessionPayment->total_price > 0 ? 
                                (($sessionPayment->amount_bank + $sessionPayment->amount_cash) / $sessionPayment->total_price) * 100 : 0;
                        @endphp
                        <span class="h5 text-info">{{ number_format($percentage, 1) }}%</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>المبلغ المرتجع:</strong><br>
                        @php
                            $totalPaid = $sessionPayment->amount_bank + $sessionPayment->amount_cash;
                            $refundAmount = $totalPaid - $sessionPayment->total_price;
                        @endphp
                        @if($refundAmount > 0)
                            <span class="h5 text-success">
                                <i class="bi bi-arrow-down-circle"></i>
                                ${{ number_format($refundAmount, 2) }}
                                <small class="d-block text-muted">يجب إرجاعه للزبون</small>
                            </span>
                        @elseif($refundAmount < 0)
                            <span class="h5 text-danger">
                                <i class="bi bi-arrow-up-circle"></i>
                                ${{ number_format(abs($refundAmount), 2) }}
                                <small class="d-block text-muted">متبقي للدفع</small>
                            </span>
                        @else
                            <span class="h5 text-muted">
                                <i class="bi bi-check-circle"></i>
                                <small>لا يوجد مبلغ مرتجع</small>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>حالة المبلغ المرتجع:</strong><br>
                        @if($refundAmount > 0)
                            <span class="badge bg-success fs-6">
                                <i class="bi bi-cash-coin"></i>
                                مستحق للزبون
                            </span>
                        @elseif($refundAmount < 0)
                            <span class="badge bg-danger fs-6">
                                <i class="bi bi-exclamation-triangle"></i>
                                متبقي للدفع
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                <i class="bi bi-check-circle"></i>
                                مكتمل الدفع
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- معلومات الجلسة -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock"></i>
                    معلومات الجلسة المرتبطة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>رقم الجلسة:</strong><br>
                        @if($sessionPayment->session && !$sessionPayment->session->trashed())
                            <a href="{{ route('sessions.show', $sessionPayment->session->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> عرض الجلسة #{{ $sessionPayment->session->id }}
                            </a>
                        @elseif($sessionPayment->session && $sessionPayment->session->trashed())
                            <span class="text-muted">
                                #{{ $sessionPayment->session->id }}
                                <small class="badge bg-secondary">جلسة محذوفة</small>
                            </span>
                        @else
                            <span class="text-muted">جلسة غير موجودة</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>المستخدم:</strong><br>
                        <span class="h6">{{ $sessionPayment->session->user->name ?? 'غير محدد' }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>نوع الجلسة:</strong><br>

                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>فئة الجلسة:</strong><br>
                        @if($sessionPayment->session->session_category == 'hourly')
                            <span class="badge bg-info">ساعي</span>

                        @elseif($sessionPayment->session->session_category == 'subscription')
                            <span class="badge bg-primary">اشتراك</span>
                        @else
                            <span class="badge bg-secondary">عادي</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>بداية الجلسة:</strong><br>
                        {{ $sessionPayment->session && $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format('Y-m-d H:i') : 'غير محدد' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>نهاية الجلسة:</strong><br>
                        @if($sessionPayment->session && $sessionPayment->session->end_at)
                            {{ $sessionPayment->session->end_at->format('Y-m-d H:i') }}
                        @elseif($sessionPayment->session)
                            <span class="text-warning">لم تنته بعد</span>
                        @else
                            <span class="text-muted">غير محدد</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>مدة الجلسة:</strong><br>
                        @if($sessionPayment->session && $sessionPayment->session->start_at)
                            @php
                                $startTime = $sessionPayment->session->start_at;
                                $endTime = $sessionPayment->session->end_at ?? now();
                                $durationInMinutes = $startTime->diffInMinutes($endTime);
                                $hours = intval($durationInMinutes / 60);
                                $minutes = $durationInMinutes % 60;
                            @endphp
                            <span class="h6 text-primary">
                                {{ $hours }} ساعة و {{ $minutes }} دقيقة
                            </span>
                            <small class="text-muted d-block">({{ $durationInMinutes }} دقيقة إجمالي)</small>
                        @else
                            <span class="text-muted">غير محدد</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>تكلفة الإنترنت:</strong><br>
                        @if($sessionPayment->session)
                            @php
                                $internetCost = $sessionPayment->session->calculateInternetCost();
                            @endphp
                            <span class="h6 text-success">${{ number_format($internetCost, 2) }}</span>
                            @if($sessionPayment->session->hasCustomInternetCost())
                                <small class="text-muted d-block">(تكلفة مخصصة)</small>
                            @endif
                        @else
                            <span class="text-muted">غير محدد</span>
                        @endif
                    </div>
                </div>

                @if($sessionPayment->session && $sessionPayment->session->note)
                <div class="row">
                    <div class="col-12 mb-3">
                        <strong>ملاحظات الجلسة:</strong><br>
                        <div class="bg-light p-2 rounded">
                            {{ $sessionPayment->session->note }}
                        </div>
                    </div>
                </div>
                @endif

                @if($sessionPayment->note)
                <div class="row">
                    <div class="col-12 mb-3">
                        <strong>ملاحظة الدفع:</strong><br>
                        <div class="bg-light p-3 rounded border">
                            {{ $sessionPayment->note }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- المشروبات المرتبطة -->
        @if($sessionPayment->session->drinks->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-cup"></i>
                    المشروبات المطلوبة ({{ $sessionPayment->session->drinks->count() }})
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>المشروب</th>
                                <th>السعر</th>
                                <th>الحالة</th>

                                <th>الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessionPayment->session->drinks as $drink)
                            <tr>
                                <td>{{ $drink->drink->name ?? 'غير محدد' }}</td>
                                <td>${{ number_format($drink->price, 2) }}</td>
                                <td>
                                    @if($drink->status == 'ordered')
                                        <span class="badge bg-warning">مطلوب</span>
                                    @elseif($drink->status == 'served')
                                        <span class="badge bg-success">مُقدم</span>
                                    @else
                                        <span class="badge bg-danger">ملغي</span>
                                    @endif
                                </td>

                                <td>{{ $drink->note ?? '-' }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-info">
                                <td><strong>إجمالي المشروبات:</strong></td>
                                <td><strong>${{ number_format($sessionPayment->session->drinks->sum('price'), 2) }}</strong></td>
                                <td colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- الإحصائيات والإجراءات -->
    <div class="col-md-4">
        <!-- إحصائيات سريعة -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">الإحصائيات</h6>
            </div>
            <div class="card-body">
                <!-- Progress bar -->
                @php
                    $progressPercentage = $sessionPayment->total_price > 0 ? 
                        (($sessionPayment->amount_bank + $sessionPayment->amount_cash) / $sessionPayment->total_price) * 100 : 0;
                @endphp
                <div class="mb-3">
                    <small class="text-muted">نسبة الدفع</small>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar 
                            @if($progressPercentage >= 100) bg-success 
                            @elseif($progressPercentage >= 50) bg-info 
                            @else bg-warning @endif" 
                            style="width: {{ min(100, $progressPercentage) }}%"></div>
                    </div>
                    <small>{{ number_format($progressPercentage, 1) }}%</small>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <small>الإجمالي:</small>
                    <strong>${{ number_format($sessionPayment->total_price, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small>المدفوع:</small>
                    <span class="text-success">${{ number_format($sessionPayment->amount_bank + $sessionPayment->amount_cash, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <small>المتبقي:</small>
                    <span class="text-danger">${{ number_format($sessionPayment->remaining_amount, 2) }}</span>
                </div>
                
                @if($sessionPayment->session->drinks->count() > 0)
                <hr>
                <small class="text-muted">إحصائيات المشروبات:</small>
                @php
                    $totalDrinksCost = $sessionPayment->session->drinks->sum('price');
                @endphp
                
                <div class="d-flex justify-content-between">
                    <small>إجمالي المشروبات:</small>
                    <span class="text-primary">${{ number_format($totalDrinksCost, 2) }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- الإجراءات -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">الإجراءات</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('session-payments.edit', $sessionPayment) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> تعديل المدفوعة
                    </a>
                    <a href="{{ route('sessions.show', $sessionPayment->session) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> عرض الجلسة
                    </a>
                    <form action="{{ route('session-payments.destroy', $sessionPayment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100" 
                                onclick="return confirm('هل تريد حذف هذه المدفوعة؟')">
                            <i class="bi bi-trash"></i> حذف المدفوعة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- التواريخ -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">التواريخ</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">تاريخ الإنشاء:</small><br>
                <strong>{{ $sessionPayment->created_at->format('Y-m-d H:i:s') }}</strong>
                <hr>
                <small class="text-muted">آخر تحديث:</small><br>
                <strong>{{ $sessionPayment->updated_at->format('Y-m-d H:i:s') }}</strong>
            </div>
        </div>
    </div>
</div>

@endsection