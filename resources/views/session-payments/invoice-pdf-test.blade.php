<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة تجريبية</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: #fff;
            direction: rtl;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 20px 0 10px;
        }
        
        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        
        .info-item {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 2px solid #0d6efd;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">BranchHUB</div>
        <div>مركز الإنترنت والكافيه</div>
        <div>هاتف: {{ config('app.phone', '966501234567') }}</div>
    </div>

    <div class="invoice-title">فاتورة الجلسة</div>
    <div>رقم الفاتورة: #{{ $sessionPayment->session->id ?? 'N/A' }}</div>
    <div>تاريخ الفاتورة: {{ $sessionPayment->created_at->format('Y-m-d H:i') }}</div>

    <div class="info-section">
        <div class="section-title">معلومات العميل</div>
        <div class="info-item">
            <span class="info-label">الاسم:</span> {{ $sessionPayment->session->user->name ?? 'غير محدد' }}
        </div>
        <div class="info-item">
            <span class="info-label">رقم الهاتف:</span> {{ $sessionPayment->session->user->phone ?? 'غير محدد' }}
        </div>
    </div>

    <div class="info-section">
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
    </div>

    <div class="info-section">
        <div class="section-title">تفاصيل التكلفة</div>
        <div class="info-item">
            <span class="info-label">تكلفة الإنترنت:</span> 
            @if($sessionPayment->session)
                ${{ number_format($sessionPayment->session->calculateInternetCost(), 2) }}
            @else
                $0.00
            @endif
        </div>
        <div class="info-item">
            <span class="info-label">تكلفة المشروبات:</span> 
            @if($sessionPayment->session)
                ${{ number_format($sessionPayment->session->drinks->sum('price'), 2) }}
            @else
                $0.00
            @endif
        </div>
        <div class="info-item">
            <span class="info-label">الإجمالي:</span> ${{ number_format($sessionPayment->total_price, 2) }}
        </div>
    </div>

    <div class="info-section">
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
        <div class="info-item">
            <span class="info-label">حالة الدفع:</span>
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
    </div>

    <div class="footer">
        <h3>شكراً لاختياركم BranchHUB</h3>
        <p>هاتف: {{ config('app.phone', '966501234567') }}</p>
        <p>بريد إلكتروني: {{ config('app.email', 'info@branchhub.com') }}</p>
        <p>تم إنشاء هذه الفاتورة في {{ $sessionPayment->created_at->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html> 