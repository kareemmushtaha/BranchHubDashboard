<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Invoice #{{ $sessionPayment->session->id ?? 'N/A' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
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
            border-bottom: 3px solid #dc3545;
            padding-bottom: 20px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
            display: block;
            border-radius: 10px;
            object-fit: contain;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: #dc3545;
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
            color: #dc3545;
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
            color: #dc3545;
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
            background: #dc3545;
            color: #fff;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 16px;
        }
        
        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
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
            background: #dc3545;
            color: #fff;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .total-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        
        .total-table tr:last-child {
            background: #dc3545;
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
            border-top: 3px solid #dc3545;
            margin-top: 30px;
        }
        
        .footer h3 {
            color: #dc3545;
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
            <img src="{{ asset('images/logo.jpeg') }}" alt="BranchHUB Logo" class="logo">
            <div class="company-name">BranchHUB</div>
            <div class="company-info">Internet & Cafe Center</div>
            <div class="company-info">Phone: +972592782897</div>
            <div class="company-info">Email: {{ config('app.email', 'info@branchhub.com') }}</div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-title">Session Invoice</div>
        <div class="invoice-number">Invoice #: {{ $sessionPayment->session->id ?? 'N/A' }}</div>
        <div class="invoice-date">Invoice Date: {{ $sessionPayment->created_at->format('Y-m-d H:i') }}</div>

        <!-- Client & Session Info -->
        <div class="info-section">
            <div class="client-info">
                <div class="section-title">Customer Information</div>
                <div class="info-item">
                    <span class="info-label">Name:</span> {{ $sessionPayment->session->user->name ?? 'Not Specified' }}
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span> {{ $sessionPayment->session->user->phone ?? 'Not Specified' }}
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span> {{ $sessionPayment->session->user->email ?? 'Not Specified' }}
                </div>
            </div>
            <div class="session-info">
                <div class="section-title">Session Information</div>
                <div class="info-item">
                    <span class="info-label">Session ID:</span> #{{ $sessionPayment->session->id ?? 'N/A' }}
                </div>
                <div class="info-item">
                    <span class="info-label">Session Date:</span> {{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->format('Y-m-d H:i') : 'Not Specified' }}
                </div>
                <div class="info-item">
                    <span class="info-label">Session Type:</span> 
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
                    <span class="info-label">Session Status:</span> 
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
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Details</th>
                    <th>Duration/Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Internet Service</td>
                    <td>
                        @if($sessionPayment->session)
                            @if($sessionPayment->session->hasCustomInternetCost())
                                Custom Cost
                            @else
                                Automatic Calculation
                            @endif
                        @else
                            Internet Service
                        @endif
                    </td>
                    <td>
                        @if($sessionPayment->session)
                            {{ $sessionPayment->session->start_at ? $sessionPayment->session->start_at->diffForHumans($sessionPayment->session->end_at ?? now(), true) : 'Not Specified' }}
                        @else
                            Not Specified
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
                            <td>{{ $drink->drink->name ?? 'Drink' }}</td>
                            <td>{{ $drink->drink->description ?? 'Refreshing drink' }}</td>
                            <td>1</td>
                            <td>${{ number_format($drink->price, 2) }}</td>
                            <td>${{ number_format($drink->price, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Drinks</td>
                        <td>No drinks</td>
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
                        <th colspan="2">Invoice Summary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Internet Cost:</td>
                        <td>
                            @if($sessionPayment->session)
                                ${{ number_format($sessionPayment->session->calculateInternetCost(), 2) }}
                            @else
                                $0.00
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Drinks Cost:</td>
                        <td>
                            @if($sessionPayment->session)
                                ${{ number_format($sessionPayment->session->drinks->sum('price'), 2) }}
                            @else
                                $0.00
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td><strong>${{ number_format($sessionPayment->total_price, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="payment-section">
            <div class="payment-info">
                <div class="section-title">Payment Information</div>
                <div class="info-item">
                    <span class="info-label">Amount Paid (Bank):</span> ${{ number_format($sessionPayment->amount_bank ?? 0, 2) }}
                </div>
                <div class="info-item">
                    <span class="info-label">Amount Paid (Cash):</span> ${{ number_format($sessionPayment->amount_cash ?? 0, 2) }}
                </div>
                <div class="info-item">
                    <span class="info-label">Total Paid:</span> ${{ number_format(($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0), 2) }}
                </div>
                <div class="info-item">
                    <span class="info-label">Remaining Amount:</span> ${{ number_format($sessionPayment->remaining_amount ?? 0, 2) }}
                </div>
            </div>
            <div class="payment-info">
                <div class="section-title">Payment Status</div>
                <div class="status-badge 
                    @if($sessionPayment->payment_status == 'paid') status-paid
                    @elseif($sessionPayment->payment_status == 'pending') status-pending
                    @elseif($sessionPayment->payment_status == 'partial') status-partial
                    @else status-pending
                    @endif">
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
                @if($sessionPayment->note)
                    <div class="info-item" style="margin-top: 10px;">
                        <span class="info-label">Note:</span> {{ $sessionPayment->note }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>Thank you for choosing BranchHUB</h3>
            <p>Phone: +972592782897</p>
            <p>Email: {{ config('app.email', 'info@branchhub.com') }}</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                This invoice was generated on {{ $sessionPayment->created_at->format('Y-m-d H:i:s') }}
            </p>
        </div>
    </div>
</body>
</html> 