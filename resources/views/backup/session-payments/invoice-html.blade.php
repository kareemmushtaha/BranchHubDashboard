<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة الجلسة #{{ $sessionPayment->session->id ?? 'N/A' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            direction: rtl;
            font-size: 14px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 20px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
            display: block;
            border-radius: 10px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin: 20px 0 10px;
        }
        
        .invoice-number {
            font-size: 16px;
            color: #0d6efd;
            font-weight: 600;
        }
        
        .invoice-date {
            color: #666;
            font-size: 14px;
        }
        
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e3f2fd;
        }
        
        .client-info, .session-info {
            flex: 1;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        
        .info-item {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .items-table th {
            background: #0d6efd;
            color: #fff;
            padding: 15px;
            text-align: right;
            font-weight: 600;
            font-size: 16px;
        }
        
        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            text-align: right;
            font-size: 14px;
        }
        
        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        
        .total-table {
            width: 400px;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .total-table th {
            background: #28a745;
            color: #fff;
            padding: 12px 15px;
            text-align: right;
            font-weight: 600;
        }
        
        .total-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: right;
        }
        
        .total-table tr:last-child {
            background: #28a745;
            color: #fff;
            font-weight: 700;
            font-size: 18px;
        }
        
        .payment-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 20px;
            background: #fff3cd;
            border-radius: 10px;
            border: 1px solid #ffeaa7;
        }
        
        .payment-info {
            flex: 1;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            min-width: 120px;
        }
        
        .status-paid {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffeaa7;
        }
        
        .status-partial {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-top: 3px solid #0d6efd;
            margin-top: 30px;
        }
        
        .footer h3 {
            color: #0d6efd;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .footer p {
            color: #666;
            margin: 5px 0;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .container {
                max-width: none;
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ public_path('images/logo.jpeg') }}" alt="BranchHUB Logo" class="logo">
            <div class="company-name">BranchHUB</div>
            <div class="company-info">مركز الإنترنت والكافيه</div>
            <div class="company-info">هاتف: {{ config('app.phone', '966501234567') }}</div>
            <div class="company-info">بريد إلكتروني: {{ config('app.email', 'info@branchhub.com') }}</div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-title">فاتورة الجلسة</div>
        <div class="invoice-number">رقم الفاتورة: #{{ $sessionPayment->session->id ?? 'N/A' }}</div>
        <div class="invoice-date">تاريخ الفاتورة: {{ $sessionPayment->created_at->format('Y-m-d H:i') }}</div>

        <!-- Client & Session Info -->
        <div class="info-section">
            <div class="client-info">
                <div class="section-title">معلومات العميل</div>
                <div class="info-item">
                    <span class="info-label">الاسم:</span> {{ $sessionPayment->session->user->name ?? 'غير محدد' }}
                </div>
                <div class="info-item">
                    <span class="info-label">رقم الهاتف:</span> {{ $sessionPayment->session->user->phone ?? 'غير محدد' }}
                </div>
                <div class="info-item">
                    <span class="info-label">البريد الإلكتروني:</span> {{ $sessionPayment->session->user->email ?? 'غير محدد' }}
                </div>
            </div>
            <div class="session-info">
                <div class="section-title">معلومات الجلسة</div>
                <div class="info-item">
                    <span class="info-label">رقم الجلسة:</span> #{{ $sessionPayment->session->id ?? 'N/A' }}
                </div>
                <div class="info-item">
                    <span class="info-label">تاريخ الجلسة:</span> {{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format('Y-m-d H:i') : 'غير محدد' }}
                </div>
                <div class="info-item">
                    <span class="info-label">نوع الجلسة:</span> 
                    @if($sessionPayment->session)
                        @if($sessionPayment->session->session_category == 'hourly')
                            ساعي

                        @elseif($sessionPayment->session->session_category == 'subscription')
                            اشتراك
                        @else
                            إضافي
                        @endif
                    @else
                        غير محدد
                    @endif
                </div>
                <div class="info-item">
                    <span class="info-label">حالة الجلسة:</span> 
                    @if($sessionPayment->session)
                        @if($sessionPayment->session->session_status == 'active')
                            نشط
                        @elseif($sessionPayment->session->session_status == 'completed')
                            مكتمل
                        @else
                            ملغي
                        @endif
                    @else
                        غير محدد
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>الوصف</th>
                    <th>التفاصيل</th>
                    <th>المدة/الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>خدمة الإنترنت</td>
                    <td>
                        @if($sessionPayment->session)
                            @if($sessionPayment->session->hasCustomInternetCost())
                                تكلفة مخصصة
                            @else
                                حساب تلقائي
                            @endif
                        @else
                            خدمة الإنترنت
                        @endif
                    </td>
                    <td>
                        @if($sessionPayment->session)
                            {{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->diffForHumans($sessionPayment->session->end_at ?? now(), true) : 'غير محدد' }}
                        @else
                            غير محدد
                        @endif
                    </td>
                    <td>
                        @if($sessionPayment->session)
                            ${{ number_format($sessionPayment->session->calculateInternetCost(), 2) }}
                        @else
                            $0.00
                        @endif
                    </td>
                    <td>
                        @if($sessionPayment->session)
                            ${{ number_format($sessionPayment->session->calculateInternetCost(), 2) }}
                        @else
                            $0.00
                        @endif
                    </td>
                </tr>
                @if($sessionPayment->session && $sessionPayment->session->drinks->count() > 0)
                    @foreach($sessionPayment->session->drinks as $drink)
                        <tr>
                            <td>{{ $drink->drink->name ?? 'مشروب' }}</td>
                            <td>{{ $drink->drink->description ?? 'مشروب منعش' }}</td>
                            <td>1</td>
                            <td>${{ number_format($drink->price, 2) }}</td>
                            <td>${{ number_format($drink->price, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>المشروبات</td>
                        <td>لا توجد مشروبات</td>
                        <td>0</td>
                        <td>$0.00</td>
                        <td>$0.00</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Totals -->
        <div class="total-section">
            <table class="total-table">
                <thead>
                    <tr>
                        <th colspan="2">ملخص الفاتورة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>تكلفة الإنترنت:</td>
                        <td>
                            @if($sessionPayment->session)
                                ${{ number_format($sessionPayment->session->calculateInternetCost(), 2) }}
                            @else
                                $0.00
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>تكلفة المشروبات:</td>
                        <td>
                            @if($sessionPayment->session)
                                ${{ number_format($sessionPayment->session->drinks->sum('price'), 2) }}
                            @else
                                $0.00
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>الإجمالي:</strong></td>
                        <td><strong>${{ number_format($sessionPayment->total_price, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="payment-section">
            <div class="payment-info">
                <div class="section-title">معلومات الدفع</div>
                <div class="info-item">
                    <span class="info-label">المبلغ المدفوع بنكياً:</span> ${{ number_format($sessionPayment->amount_bank ?? 0, 2) }}
                </div>
                <div class="info-item">
                    <span class="info-label">المبلغ المدفوع نقداً:</span> ${{ number_format($sessionPayment->amount_cash ?? 0, 2) }}
                </div>
                <div class="info-item">
                    <span class="info-label">إجمالي المدفوع:</span> ${{ number_format(($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0), 2) }}
                </div>
                <div class="info-item">
                    <span class="info-label">المبلغ المتبقي:</span> ${{ number_format($sessionPayment->remaining_amount ?? 0, 2) }}
                </div>
            </div>
            <div class="payment-info">
                <div class="section-title">حالة الدفع</div>
                <div class="status-badge 
                    @if($sessionPayment->payment_status == 'paid') status-paid
                    @elseif($sessionPayment->payment_status == 'pending') status-pending
                    @elseif($sessionPayment->payment_status == 'partial') status-partial
                    @else status-pending
                    @endif">
                    @if($sessionPayment->payment_status == 'paid')
                        مدفوع بالكامل
                    @elseif($sessionPayment->payment_status == 'pending')
                        قيد الانتظار
                    @elseif($sessionPayment->payment_status == 'partial')
                        دفع جزئي
                    @elseif($sessionPayment->payment_status == 'cancelled')
                        ملغي
                    @else
                        قيد الانتظار
                    @endif
                </div>
                @if($sessionPayment->note)
                    <div class="info-item" style="margin-top: 10px;">
                        <span class="info-label">ملاحظة:</span> {{ $sessionPayment->note }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>شكراً لاختياركم BranchHUB</h3>
            <p>هاتف: {{ config('app.phone', '966501234567') }}</p>
            <p>بريد إلكتروني: {{ config('app.email', 'info@branchhub.com') }}</p>
            <p>موقع إلكتروني: {{ config('app.url', 'www.branchhub.com') }}</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                تم إنشاء هذه الفاتورة في {{ $sessionPayment->created_at->format('Y-m-d H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html> 