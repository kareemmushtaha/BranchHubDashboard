<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة الجلسة #{{ $sessionPayment->session->id ?? 'N/A' }}</title>
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
        <div>&#1605;&#1585;&#1603;&#1586; &#1575;&#1604;&#1573;&#1606;&#1578;&#1585;&#1606;&#1578; &#1608;&#1575;&#1604;&#1603;&#1575;&#1601;&#1610;&#1607;</div>
        <div>&#1607;&#1575;&#1578;&#1601;: {{ config('app.phone', '966501234567') }}</div>
    </div>

    <div class="invoice-title">&#1601;&#1575;&#1578;&#1608;&#1585;&#1577; &#1575;&#1604;&#1580;&#1604;&#1587;&#1577;</div>
    <div>&#1585;&#1602;&#1605; &#1575;&#1604;&#1601;&#1575;&#1578;&#1608;&#1585;&#1577;: #{{ $sessionPayment->session->id ?? 'N/A' }}</div>
    <div>&#1578;&#1575;&#1585;&#1610;&#1582; &#1575;&#1604;&#1601;&#1575;&#1578;&#1608;&#1585;&#1577;: {{ $sessionPayment->created_at->format('Y-m-d H:i') }}</div>

    <div class="info-section">
        <div class="section-title">&#1605;&#1593;&#1604;&#1608;&#1605;&#1575;&#1578; &#1575;&#1604;&#1593;&#1605;&#1610;&#1604;</div>
        <div class="info-item">
            <span class="info-label">&#1575;&#1604;&#1575;&#1587;&#1605;:</span> {{ $sessionPayment->session->user->name ?? '&#1594;&#1610;&#1585; &#1605;&#1581;&#1583;&#1583;' }}
        </div>
        <div class="info-item">
            <span class="info-label">&#1585;&#1602;&#1605; &#1575;&#1604;&#1607;&#1575;&#1578;&#1601;:</span> {{ $sessionPayment->session->user->phone ?? '&#1594;&#1610;&#1585; &#1605;&#1581;&#1583;&#1583;' }}
        </div>
    </div>

    <div class="info-section">
        <div class="section-title">&#1605;&#1593;&#1604;&#1608;&#1605;&#1575;&#1578; &#1575;&#1604;&#1580;&#1604;&#1587;&#1577;</div>
        <div class="info-item">
            <span class="info-label">&#1585;&#1602;&#1605; &#1575;&#1604;&#1580;&#1604;&#1587;&#1577;:</span> #{{ $sessionPayment->session->id ?? 'N/A' }}
        </div>
        <div class="info-item">
            <span class="info-label">&#1578;&#1575;&#1585;&#1610;&#1582; &#1575;&#1604;&#1580;&#1604;&#1587;&#1577;:</span> {{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format('Y-m-d H:i') : '&#1594;&#1610;&#1585; &#1605;&#1581;&#1583;&#1583;' }}
        </div>
        <div class="info-item">
            <span class="info-label">&#1606;&#1608;&#1593; &#1575;&#1604;&#1580;&#1604;&#1587;&#1577;:</span> 
            @if($sessionPayment->session)
                @if($sessionPayment->session->session_category == 'hourly')
                    &#1587;&#1575;&#1593;&#1610;

                @elseif($sessionPayment->session->session_category == 'subscription')
                    &#1575;&#1588;&#1578;&#1585;&#1575;&#1603;
                @else
                    &#1573;&#1590;&#1575;&#1601;&#1610;
                @endif
            @else
                &#1594;&#1610;&#1585; &#1605;&#1581;&#1583;&#1583;
            @endif
        </div>
    </div>

    <div class="info-section">
        <div class="section-title">&#1578;&#1601;&#1575;&#1589;&#1610;&#1604; &#1575;&#1604;&#1578;&#1603;&#1604;&#1601;&#1577;</div>
        <div class="info-item">
            <span class="info-label">&#1578;&#1603;&#1604;&#1601;&#1577; &#1575;&#1604;&#1573;&#1606;&#1578;&#1585;&#1606;&#1578;:</span> 
            @if($sessionPayment->session)
                ₪{{ number_format($sessionPayment->session->calculateInternetCost(), 2) }}
            @else
                ₪0.00
            @endif
        </div>
        <div class="info-item">
            <span class="info-label">&#1578;&#1603;&#1604;&#1601;&#1577; &#1575;&#1604;&#1605;&#1588;&#1585;&#1608;&#1576;&#1575;&#1578;:</span> 
            @if($sessionPayment->session)
                ₪{{ number_format($sessionPayment->session->drinks->sum('price'), 2) }}
            @else
                ₪0.00
            @endif
        </div>
        <div class="info-item">
            <span class="info-label">&#1575;&#1604;&#1573;&#1580;&#1605;&#1575;&#1604;&#1610;:</span> ₪{{ number_format($sessionPayment->total_price, 2) }}
        </div>
    </div>

    <div class="info-section">
        <div class="section-title">&#1605;&#1593;&#1604;&#1608;&#1605;&#1575;&#1578; &#1575;&#1604;&#1583;&#1601;&#1593;</div>
        <div class="info-item">
            <span class="info-label">&#1575;&#1604;&#1605;&#1576;&#1604;&#1594; &#1575;&#1604;&#1605;&#1583;&#1601;&#1608;&#1593; &#1576;&#1606;&#1603;&#1610;&#1575;&#1611;:</span> ₪{{ number_format($sessionPayment->amount_bank ?? 0, 2) }}
        </div>
        <div class="info-item">
            <span class="info-label">&#1575;&#1604;&#1605;&#1576;&#1604;&#1594; &#1575;&#1604;&#1605;&#1583;&#1601;&#1608;&#1593; &#1606;&#1602;&#1583;&#1610;&#1575;&#1611;:</span> ₪{{ number_format($sessionPayment->amount_cash ?? 0, 2) }}
        </div>
        <div class="info-item">
            <span class="info-label">&#1573;&#1580;&#1605;&#1575;&#1604;&#1610; &#1575;&#1604;&#1605;&#1583;&#1601;&#1608;&#1593;:</span> ₪{{ number_format(($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0), 2) }}
        </div>
        <div class="info-item">
            <span class="info-label">&#1575;&#1604;&#1605;&#1576;&#1604;&#1594; &#1575;&#1604;&#1605;&#1578;&#1576;&#1602;&#1610;:</span> ₪{{ number_format($sessionPayment->remaining_amount ?? 0, 2) }}
        </div>
        <div class="info-item">
            <span class="info-label">&#1581;&#1575;&#1604;&#1577; &#1575;&#1604;&#1583;&#1601;&#1593;:</span>
            @if($sessionPayment->payment_status == 'paid')
                &#1605;&#1583;&#1601;&#1608;&#1593; &#1576;&#1575;&#1604;&#1603;&#1575;&#1605;&#1604;
            @elseif($sessionPayment->payment_status == 'pending')
                &#1602;&#1610;&#1583; &#1575;&#1604;&#1575;&#1606;&#1578;&#1592;&#1575;&#1585;
            @elseif($sessionPayment->payment_status == 'partial')
                &#1583;&#1601;&#1593; &#1580;&#1586;&#1574;&#1610;
            @elseif($sessionPayment->payment_status == 'cancelled')
                &#1605;&#1604;&#1594;&#1610;
            @else
                &#1602;&#1610;&#1583; &#1575;&#1604;&#1575;&#1606;&#1578;&#1592;&#1575;&#1585;
            @endif
        </div>
    </div>

    <div class="footer">
        <h3>&#1588;&#1603;&#1585;&#1575;&#1611; &#1604;&#1575;&#1582;&#1578;&#1610;&#1575;&#1585;&#1603;&#1605; BranchHUB</h3>
        <p>&#1607;&#1575;&#1578;&#1601;: {{ config('app.phone', '966501234567') }}</p>
        <p>&#1576;&#1585;&#1610;&#1583; &#1573;&#1604;&#1603;&#1578;&#1585;&#1608;&#1606;&#1610;: {{ config('app.email', 'info@branchhub.com') }}</p>
        <p>&#1578;&#1605; &#1573;&#1606;&#1588;&#1575;&#1569; &#1607;&#1584;&#1607; &#1575;&#1604;&#1601;&#1575;&#1578;&#1608;&#1585;&#1577; &#1601;&#1610; {{ $sessionPayment->created_at->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html> 