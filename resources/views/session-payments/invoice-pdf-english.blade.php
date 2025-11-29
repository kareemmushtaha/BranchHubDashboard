<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session Invoice #{{ $sessionPayment->session->id ?? 'N/A' }}</title>
    <style>
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #2c3e50;
            background: #ffffff;
            margin: 0;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 12px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
        }

        .company-name {
            font-size: 22px;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .company-info {
            font-size: 10px;
            color: #4a5568;
            margin-bottom: 2px;
            letter-spacing: 0.3px;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: 700;
            color: #000000;
            margin: 12px 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .invoice-number {
            font-size: 11px;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .invoice-date {
            color: #718096;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .info-section {
            margin-bottom: 10px;
            padding: 10px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #dc3545;
            border-radius: 3px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            width: 100%;
            box-sizing: border-box;
        }

        .sections-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            border-spacing: 15px 0;
            table-layout: fixed;
        }

        .sections-row .info-section {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            margin-bottom: 0;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #000000;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-item {
            margin: 4px 0;
            font-size: 10px;
            padding: 3px 0;
            border-bottom: 1px dotted #e2e8f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #000000;
            display: inline-block;
            min-width: 140px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }

        .items-table th {
            background: #dc3545;
            color: #ffffff;
            padding: 6px 8px;
            text-align: left;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid #000000;
        }

        .items-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            font-size: 10px;
            color: #000000;
        }

        .items-table tr:nth-child(even) {
            background: #f7fafc;
        }

        .items-table tr:hover {
            background: #edf2f7;
        }

        .total-section {
            text-align: right;
            margin-bottom: 10px;
        }

        .total-table {
            width: 300px;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-left: auto;
        }

        .total-table th {
            background: #dc3545;
            color: #ffffff;
            padding: 6px 10px;
            text-align: left;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .total-table td {
            padding: 5px 10px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            font-size: 10px;
            color: #000000;
        }

        .total-table tr:last-child {
            background: #dc3545;
            color: #ffffff;
            font-weight: 700;
            font-size: 11px;
        }

        .payment-section {
            margin-bottom: 10px;
            padding: 10px;
            background: #fffbf0;
            border: 1px solid #f6e05e;
            border-left: 3px solid #d69e2e;
            border-radius: 3px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
            text-align: center;
            min-width: 100px;
            letter-spacing: 0.3px;
        }

        .status-paid {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .status-pending {
            background: #feebc8;
            color: #7c2d12;
            border: 1px solid #fbd38d;
        }

        .status-partial {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #fc8181;
        }

        .footer {
            text-align: center;
            padding: 12px;
            background: #f7fafc;
            border-top: 2px solid #dc3545;
            margin-top: 15px;
        }

        .footer h3 {
            color: #dc3545;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer p {
            color: #4a5568;
            margin: 3px 0;
            font-size: 9px;
            letter-spacing: 0.2px;
        }

        .qrcode-section {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            background: #ffffff;
            border-top: 2px solid #dc3545;
            border: 1px solid #e2e8f0;
        }

        .qrcode-title {
            font-size: 11px;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .qrcode-image {
            width: 80px;
            height: 80px;
            margin: 6px auto;
            border: 2px solid #dc3545;
            padding: 4px;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .qrcode-text {
            font-size: 8px;
            color: #4a5568;
            margin-top: 5px;
            letter-spacing: 0.2px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.jpeg') }}" alt="BranchHUB Logo" style="width: 60px; height: 60px; margin: 0 auto 6px; display: block; border-radius: 6px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);">
        <div class="company-name">BranchHUB</div>
        <div class="company-info">Professional Workspace</div>
        <div class="company-info">Phone: +972592782897</div>
    </div>

    <div class="invoice-title">Subscription Invoice</div>
    <div style="color: #718096; font-size: 9px; margin: 3px 0 8px 0; font-style: italic; letter-spacing: 0.2px;">
        This invoice contains subscription details including internet usage, and payment information
    </div>
    <div class="invoice-number">Invoice #: {{ $sessionPayment->session->id ?? 'N/A' }}</div>
    <div class="invoice-date">Issue Date: {{ isset($invoiceDate) ? $invoiceDate->format('Y-m-d') : now()->format('Y-m-d') }}</div>

    <div style="margin-bottom: 10px;">
        <div class="section-title">Customer Information</div>
        <div style="font-size: 10px; color: #000000; margin: 3px 0;">
            <span style="font-weight: 600; color: #000000; display: inline-block; min-width: 80px;">Name:</span> {{ $sessionPayment->session->user->name ?? 'Not Specified' }}
        </div>
        <div style="font-size: 10px; color: #000000; margin: 3px 0;">
            <span style="font-weight: 600; color: #000000; display: inline-block; min-width: 80px;">Phone:</span> {{ $sessionPayment->session->user->phone ?? 'Not Specified' }}
        </div>
        <div style="font-size: 10px; color: #000000; margin: 3px 0;">
            <span style="font-weight: 600; color: #000000; display: inline-block; min-width: 80px;">Email:</span> {{ $sessionPayment->session->user->email ?? 'Not Specified' }}
        </div>
    </div>

    <div class="sections-row">
        <div class="info-section">
            <div class="section-title">Subscription Information</div>
            <div class="info-item">
                <span class="info-label">Subscription ID:</span> #{{ $sessionPayment->session->id ?? 'N/A' }}
            </div>
            <div class="info-item">
                <span class="info-label">Subscription Date:</span> {{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format('Y-m-d H:i') : 'Not Specified' }}
            </div>
            <div class="info-item">
                <span class="info-label">Subscription End At:</span>
                @if($sessionPayment->session)
                    @if($sessionPayment->session->expected_end_date)
                        {{ $sessionPayment->session->expected_end_date->format('Y-m-d') }}
                    @elseif($sessionPayment->session->end_at)
                        {{ $sessionPayment->session->end_at->format('Y-m-d') }}
                    @else
                       {{  $sessionPayment->session->getExpectedEndDate()}}
                    @endif
                @else
                    Not Specified
                @endif
            </div>
            <div class="info-item">
                <span class="info-label">Subscription Type:</span>
                @if($sessionPayment->session)
                    @if($sessionPayment->session->session_category == 'hourly')
                        Hourly

                    @elseif($sessionPayment->session->session_category == 'subscription')
                        Subscription
                    @else
                        Additional
                    @endif
                @else
                    Not Specified
                @endif
            </div>
            <div class="info-item">
                <span class="info-label">Subscription Status:</span>
                @if($sessionPayment->session)
                    @if($sessionPayment->session->session_status == 'active')
                        Active
                    @elseif($sessionPayment->session->session_status == 'completed')
                        Completed
                    @else
                        Cancelled
                    @endif
                @else
                    Not Specified
                @endif
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Cost Details</div>
            <div class="info-item">
                <span class="info-label">Internet Cost:</span>
                @if($sessionPayment->session)
                    {{ number_format($sessionPayment->session->calculateInternetCost(), 2) }} Shekels
                @else
                    0.00 Shekels
                @endif
            </div>
            <div class="info-item">
                <span class="info-label">Drinks Cost:</span>
                @if($sessionPayment->session)
                    {{ number_format($sessionPayment->session->drinks->sum('price'), 2) }} Shekels
                @else
                    0.00 Shekels
                @endif
            </div>
            <div class="info-item">
                <span class="info-label">Overtime Hours Cost:</span>
                @if($sessionPayment->session)
                    @php
                        $sessionPayment->session->load('overtimes');
                        $overtimeCost = $sessionPayment->session->calculateOvertimeCost();
                    @endphp
                    {{ number_format($overtimeCost, 2) }} Shekels
                    @if($sessionPayment->session->overtimes->count() > 0)
                        <span style="font-size: 9px; color: #718096; margin-left: 5px;">
                            ({{ number_format($sessionPayment->session->overtimes->sum('total_hour'), 2) }} hours)
                        </span>
                    @endif
                @else
                    0.00 Shekels
                @endif
            </div>
            <div class="info-item">
                <span class="info-label">Total:</span> {{ number_format($sessionPayment->total_price, 2) }} Shekels
            </div>
        </div>
    </div>
    <div class="sections-row">
    <div class="info-section">
        <div class="section-title">Payment Information</div>
        <div class="info-item">
            <span class="info-label">Amount Paid (Bank):</span>{{ number_format($sessionPayment->amount_bank ?? 0, 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Amount Paid (Cash):</span> {{ number_format($sessionPayment->amount_cash ?? 0, 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Total Paid:</span> {{ number_format(($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0), 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Remaining Amount: {{ number_format($sessionPayment->remaining_amount ?? 0, 2) }} Shekels </span>
        </div>
        <div class="info-item">
            <span class="info-label">Refund Amount:</span>
            @php
                $totalPaid = ($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0);
                $refundAmount = $totalPaid - $sessionPayment->total_price;
            @endphp
            @if($refundAmount > 0)
                <span style="color: #28a745; font-weight: bold;">{{ number_format($refundAmount, 2) }} Shekels (Should be refunded) </span>
{{--            @elseif($refundAmount < 0)--}}
{{--                <span style="color: #dc3545; font-weight: bold;">{{ number_format(abs($refundAmount), 2) }} Shekels (Remaining to pay)</span>--}}
            @else
                <span style="color: #6c757d;">0.00 Shekels (No refund needed)</span>
            @endif
        </div>
        <div class="info-item">
            <span class="info-label">Payment Status:</span>
            @if($sessionPayment->payment_status == 'paid')
                Fully Paid
            @elseif($sessionPayment->payment_status == 'pending')
                Pending
            @elseif($sessionPayment->payment_status == 'partial')
                Partial Payment
            @elseif($sessionPayment->payment_status == 'cancelled')
                Cancelled
            @else
                Pending
            @endif
        </div>
    </div>
    </div>
    <div class="footer">
        <h3>Thank you for choosing BranchHUB</h3>
        <p>Phone: +972592782897</p>
        <p>Email: {{ config('app.email', 'info@branchhub.com') }}</p>
    </div>

    <!-- QR Code Section -->
    <div class="qrcode-section">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=https://branchub.net/" alt="QR Code" class="qrcode-image">
        <div class="qrcode-text">Scan this QR code to visit our website</div>
    </div>
</body>
</html>
