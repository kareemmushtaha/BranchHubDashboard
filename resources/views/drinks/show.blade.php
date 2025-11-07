@extends('layouts.app')

@section('title', 'تفاصيل المشروب')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تفاصيل المشروب: {{ $drink->name }}</h1>
    <div>
        <a href="{{ route('drinks.edit', $drink) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> تعديل
        </a>
        <a href="{{ route('drinks.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <!-- معلومات المشروب -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات المشروب</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6"><strong>اسم المشروب:</strong></div>
                    <div class="col-sm-6">{{ $drink->name }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>السعر:</strong></div>
                    <div class="col-sm-6">₪{{ number_format($drink->price, 2) }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>الحجم:</strong></div>
                    <div class="col-sm-6">
                        @if($drink->size == 'small')
                            <span class="badge bg-secondary">صغير</span>
                        @elseif($drink->size == 'medium')
                            <span class="badge bg-primary">متوسط</span>
                        @else
                            <span class="badge bg-success">كبير</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>الحالة:</strong></div>
                    <div class="col-sm-6">
                        @if($drink->status == 'available')
                            <span class="badge bg-success">متوفر</span>
                        @else
                            <span class="badge bg-danger">غير متوفر</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>تاريخ الإضافة:</strong></div>
                    <div class="col-sm-6">{{ $drink->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>آخر تحديث:</strong></div>
                    <div class="col-sm-6">{{ $drink->updated_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات المبيعات -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">إحصائيات المبيعات</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6"><strong>إجمالي المبيعات:</strong></div>
                    <div class="col-sm-6">{{ $salesStats['total_sold'] }} مرة</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>إجمالي الإيرادات:</strong></div>
                    <div class="col-sm-6">₪{{ number_format($salesStats['total_revenue'], 2) }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>آخر طلب:</strong></div>
                    <div class="col-sm-6">
                        @if($salesStats['last_order'])
                            {{ $salesStats['last_order']->format('Y-m-d H:i') }}
                        @else
                            لم يتم طلبه بعد
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6"><strong>متوسط السعر:</strong></div>
                    <div class="col-sm-6">
                        @if($salesStats['total_sold'] > 0)
                            ₪{{ number_format($salesStats['total_revenue'] / $salesStats['total_sold'], 2) }}
                        @else
                            -
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- الطلبات الأخيرة -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">الطلبات الأخيرة</h5>
            </div>
            <div class="card-body">
                @if($recentOrders && $recentOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>رقم الجلسة</th>
                                <th>المستخدم</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>وقت الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('sessions.show', $order->session) }}" class="text-decoration-none">
                                        #{{ $order->session->id }}
                                    </a>
                                </td>
                                <td>{{ $order->session->user->name ?? 'غير محدد' }}</td>
                                <td>₪{{ number_format($order->price, 2) }}</td>
                                <td>
                                    @if($order->status == 'ordered')
                                        <span class="badge bg-warning">مطلوب</span>
                                    @elseif($order->status == 'served')
                                        <span class="badge bg-success">تم التقديم</span>
                                    @else
                                        <span class="badge bg-danger">ملغي</span>
                                    @endif
                                </td>
                                <td>{{ $order->note ?: '-' }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">لا توجد طلبات لهذا المشروب بعد</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection