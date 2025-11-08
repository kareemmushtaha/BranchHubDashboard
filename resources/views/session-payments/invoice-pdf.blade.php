<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة الجلسة #{{ $sessionPayment->session->id ?? 'N/A' }}</title>
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');
        }
        
        @font-face {
            font-family: 'Arial Unicode MS';
            src: local('Arial Unicode MS');
        }
        
        @font-face {
            font-family: 'Tahoma';
            src: local('Tahoma');
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial Unicode MS', 'Tahoma', 'Cairo', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            direction: rtl;
            unicode-bidi: embed;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #0d6efd;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin-left: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .company-info h1 {
            color: #0d6efd;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .company-info p {
            color: #666;
            font-size: 14px;
            margin: 2px 0;
        }
        
        .invoice-info {
            text-align: left;
        }
        
        .invoice-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .invoice-number {
            font-size: 18px;
            color: #0d6efd;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .invoice-date {
            color: #666;
            font-size: 14px;
        }
        
        .client-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
            border-radius: 10px;
            border: 1px solid #e3f2fd;
        }
        
        .client-info h3 {
            color: #0d6efd;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .client-info p {
            margin: 5px 0;
            color: #555;
        }
        
        .session-info h3 {
            color: #0d6efd;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .session-info p {
            margin: 5px 0;
            color: #555;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .items-table th {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
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
        }
        
        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .items-table tr:hover {
            background: #e3f2fd;
        }
        
        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
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
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-radius: 10px;
            border: 1px solid #ffeaa7;
        }
        
        .payment-info h3 {
            color: #856404;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .payment-info p {
            margin: 5px 0;
            color: #856404;
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
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            border-top: 3px solid #0d6efd;
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
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(13, 110, 253, 0.1);
            font-weight: 700;
            pointer-events: none;
            z-index: -1;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .invoice-container {
                max-width: none;
                margin: 0;
                padding: 20px;
            }
            
            .watermark {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="watermark">BranchHUB</div>
    
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <img src="{{ public_path('images/logo.jpeg') }}" alt="BranchHUB Logo" class="logo">
                <div class="company-info">
                    <h1>BranchHUB</h1>
                    <p>مركز الإنترنت والكافيه</p>
                    <p>📞 {{ config('app.phone', '966501234567') }}</p>
                    <p>📧 {{ config('app.email', 'info@branchhub.com') }}</p>
                </div>
            </div>
            <div class="invoice-info">
                <div class="invoice-title">فاتورة الجلسة</div>
                <div class="invoice-number">#{{ $sessionPayment->session->id ?? 'N/A' }}</div>
                <div class="invoice-date">{{ $sessionPayment->created_at->format('Y-m-d H:i') }}</div>
            </div>
        </div>

        <!-- Client & Session Info -->
        <div class="client-section">
            <div class="client-info">
                <h3>معلومات العميل</h3>
                <p><strong>الاسم:</strong> {{ $sessionPayment->session->user->name ?? 'غير محدد' }}</p>
                <p><strong>رقم الهاتف:</strong> {{ $sessionPayment->session->user->phone ?? 'غير محدد' }}</p>
                <p><strong>البريد الإلكتروني:</strong> {{ $sessionPayment->session->user->email ?? 'غير محدد' }}</p>
            </div>
            <div class="session-info">
                <h3>معلومات الجلسة</h3>
                <p><strong>رقم الجلسة:</strong> #{{ $sessionPayment->session->id ?? 'N/A' }}</p>
                <p><strong>تاريخ الجلسة:</strong> {{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format('Y-m-d H:i') : 'غير محدد' }}</p>
                <p><strong>نوع الجلسة:</strong> 
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
                </p>
                <p><strong>حالة الجلسة:</strong> 
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
                </p>
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
                    <td>🌐 خدمة الإنترنت</td>
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
                            <td>☕ {{ $drink->drink->name ?? 'مشروب' }}</td>
                            <td>{{ $drink->drink->description ?? 'مشروب منعش' }}</td>
                            <td>1</td>
                            <td>${{ number_format($drink->price, 2) }}</td>
                            <td>${{ number_format($drink->price, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>☕ المشروبات</td>
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
                <h3>معلومات الدفع</h3>
                <p><strong>المبلغ المدفوع بنكياً:</strong> ${{ number_format($sessionPayment->amount_bank ?? 0, 2) }}</p>
                <p><strong>المبلغ المدفوع نقداً:</strong> ${{ number_format($sessionPayment->amount_cash ?? 0, 2) }}</p>
                <p><strong>إجمالي المدفوع:</strong> ${{ number_format(($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0), 2) }}</p>
                <p><strong>المبلغ المتبقي:</strong> ${{ number_format($sessionPayment->remaining_amount ?? 0, 2) }}</p>
                <p><strong>المبلغ المرتجع:</strong>
                    @php
                        $totalPaid = ($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0);
                        $refundAmount = $totalPaid - $sessionPayment->total_price;
                    @endphp
                    @if($refundAmount > 0)
                        <span style="color: #28a745; font-weight: bold;">${{ number_format($refundAmount, 2) }} (يجب إرجاعه للزبون)</span>
                    @elseif($refundAmount < 0)
                        <span style="color: #dc3545; font-weight: bold;">${{ number_format(abs($refundAmount), 2) }} (متبقي للدفع)</span>
                    @else
                        <span style="color: #6c757d;">$0.00 (لا يوجد مبلغ مرتجع)</span>
                    @endif
                </p>
            </div>
            <div class="payment-info">
                <h3>حالة الدفع</h3>
                <div class="status-badge 
                    @if($sessionPayment->payment_status == 'paid') status-paid
                    @elseif($sessionPayment->payment_status == 'pending') status-pending
                    @elseif($sessionPayment->payment_status == 'partial') status-partial
                    @else status-pending
                    @endif">
                    @if($sessionPayment->payment_status == 'paid')
                        ✅ مدفوع بالكامل
                    @elseif($sessionPayment->payment_status == 'pending')
                        ⏳ قيد الانتظار
                    @elseif($sessionPayment->payment_status == 'partial')
                        ⚠️ دفع جزئي
                    @elseif($sessionPayment->payment_status == 'cancelled')
                        ❌ ملغي
                    @else
                        ⏳ قيد الانتظار
                    @endif
                </div>
                @if($sessionPayment->note)
                    <p style="margin-top: 10px;"><strong>ملاحظة:</strong> {{ $sessionPayment->note }}</p>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>شكراً لاختياركم BranchHUB</h3>
            <p>📞 للاستفسار: {{ config('app.phone', '966501234567') }}</p>
            <p>📧 البريد الإلكتروني: {{ config('app.email', 'info@branchhub.com') }}</p>
            <p>🌐 الموقع الإلكتروني: {{ config('app.url', 'www.branchhub.com') }}</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                تم إنشاء هذه الفاتورة في {{ $sessionPayment->created_at->format('Y-m-d H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html> 