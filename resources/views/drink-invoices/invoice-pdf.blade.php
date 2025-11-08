<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drink Invoice #{{ $drinkInvoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 10px;
        }
        
        .company-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 20px 0 10px;
        }
        
        .invoice-number {
            font-size: 16px;
            color: #dc3545;
            font-weight: bold;
        }
        
        .invoice-date {
            color: #666;
            font-size: 14px;
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
            color: #dc3545;
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
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        
        .items-table th {
            background: #dc3545;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }
        
        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .total-section {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .total-table {
            width: 300px;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-left: auto;
        }
        
        .total-table th {
            background: #dc3545;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        
        .total-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }
        
        .total-table tr:last-child {
            background: #dc3545;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
        }
        
        .payment-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 2px solid #dc3545;
            margin-top: 30px;
        }
        
        .footer h3 {
            color: #dc3545;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .footer p {
            color: #666;
            margin: 5px 0;
            font-size: 12px;
        }
        
        .qrcode-section {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-top: 2px solid #dc3545;
        }
        
        .qrcode-title {
            font-size: 14px;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 10px;
        }
        
        .qrcode-image {
            width: 100px;
            height: 100px;
            margin: 10px auto;
            border: 2px solid #dc3545;
            padding: 5px;
            background: #fff;
        }
        
        .qrcode-text {
            font-size: 11px;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.jpeg') }}" alt="BranchHUB Logo" style="width: 80px; height: 80px; margin: 0 auto 10px; display: block; border-radius: 10px;">
        <div class="company-name">BranchHUB</div>
        <div class="company-info">Internet & Cafe Center</div>
        <div class="company-info">Phone: +972592782897</div>
    </div>

    <div class="invoice-title">Drink Invoice</div>
    <div class="invoice-number">Invoice #: {{ $drinkInvoice->id }}</div>
    <div class="invoice-date">Invoice Date: {{ $drinkInvoice->created_at->format('Y-m-d H:i') }}</div>

    <div class="info-section">
        <div class="section-title">Customer Information</div>
        <div class="info-item">
            <span class="info-label">Name:</span> {{ $drinkInvoice->user->name ?? 'Not Specified' }}
        </div>
        <div class="info-item">
            <span class="info-label">Phone:</span> {{ $drinkInvoice->user->phone ?? 'Not Specified' }}
        </div>
        <div class="info-item">
            <span class="info-label">Email:</span> {{ $drinkInvoice->user->email ?? 'Not Specified' }}
        </div>
    </div>

    <!-- Drinks Items Table -->
    @if($drinkInvoice->items && $drinkInvoice->items->count() > 0)
    <div class="info-section">
        <div class="section-title">Drinks Details</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Drink Name</th>
                    <th>Quantity</th>
                    <th>Unit Price (Shekels)</th>
                    <th>Total Price (Shekels)</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drinkInvoice->items as $item)
                <tr>
                    <td>{{ $item->drink->name ?? 'Not Specified' }}</td>
                    <td>{{ $item->quantity ?? 1 }}</td>
                    <td>{{ number_format($item->unit_price ?? $item->drink->price ?? 0, 2) }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>
                        @if($item->status == 'ordered')
                            Ordered
                        @elseif($item->status == 'served')
                            Served
                        @else
                            Cancelled
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
                <tr style="background: #e9ecef; font-weight: bold;">
                    <td colspan="2"><strong>Total:</strong></td>
                    <td></td>
                    <td><strong>{{ number_format($drinkInvoice->items->sum('price'), 2) }} Shekels</strong></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <div class="info-section">
        <div class="section-title">Payment Information</div>
        <div class="info-item">
            <span class="info-label">Total Amount:</span> {{ number_format($drinkInvoice->total_price, 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Amount Paid (Bank):</span> {{ number_format($drinkInvoice->amount_bank ?? 0, 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Amount Paid (Cash):</span> {{ number_format($drinkInvoice->amount_cash ?? 0, 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Total Paid:</span> {{ number_format(($drinkInvoice->amount_bank ?? 0) + ($drinkInvoice->amount_cash ?? 0), 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Remaining Amount:</span> {{ number_format($drinkInvoice->remaining_amount ?? 0, 2) }} Shekels
        </div>
        <div class="info-item">
            <span class="info-label">Payment Status:</span>
            @if($drinkInvoice->payment_status == 'paid')
                Fully Paid
            @elseif($drinkInvoice->payment_status == 'pending')
                Pending
            @elseif($drinkInvoice->payment_status == 'partial')
                Partial Payment
            @elseif($drinkInvoice->payment_status == 'cancelled')
                Cancelled
            @else
                Pending
            @endif
        </div>
        @if($drinkInvoice->note)
            <div class="info-item">
                <span class="info-label">Note:</span> {{ $drinkInvoice->note }}
            </div>
        @endif
    </div>

    <div class="footer">
        <h3>Thank you for choosing BranchHUB</h3>
        <p>Phone: +972592782897</p>
        <p>Email: {{ config('app.email', 'info@branchhub.com') }}</p>
        <p style="margin-top: 15px; font-size: 12px; color: #999;">
            This invoice was generated on {{ $drinkInvoice->created_at->format('Y-m-d H:i:s') }}
        </p>
    </div>

    <!-- QR Code Section -->
    <div class="qrcode-section">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://branchub.net/" alt="QR Code" class="qrcode-image">
        <div class="qrcode-text">Scan this QR code to visit our website</div>
        <div class="qrcode-text" style="font-size: 10px; color: #999; margin-top: 5px;">https://branchub.net/</div>
    </div>
</body>
</html>

