<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Set title using session ID -->
    <title>Invoice #{{ $sessionPayment->session->id ?? 'N/A' }}</title>
    <style>
        /* Reset and basic body styling */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        /* Main container for the invoice */
        .invoice-container {
            width: 800px;
            margin: 40px auto;
            padding: 40px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        /* Header section with logo and invoice title */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .company-info {
            flex: 1;
        }

        .company-logo {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }

        .invoice-title {
            flex: 1;
            text-align: right;
        }

        .invoice-title h1 {
            font-size: 28px;
            margin: 0;
            color: #000;
        }

        /* Company details section */
        .company-details {
            margin-bottom: 30px;
        }

        .company-details p {
            margin: 4px 0;
            font-size: 13px;
            color: #555;
        }

        /* Table styling for customer info and items */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.customer-table th,
        table.customer-table td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
        }

        table.customer-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            width: 150px; /* Fixed width for labels */
        }

        /* Service details section */
        .service-details {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #fdfdfd;
            border: 1px solid #eee;
            border-radius: 5px;
        }

        .service-details p {
            margin: 5px 0;
        }

        .service-details span {
            font-weight: bold;
            color: #000;
        }

        /* Items table (Sub Total, VAT, etc.) */
        table.items-table {
            border: 1px solid #ddd;
        }

        table.items-table th,
        table.items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        table.items-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }

        table.items-table .total-row td {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #000;
        }

        /* Styling for the total value box, matching the image */
        .total-value {
            border: 1px solid #ccc;
            padding: 8px 12px;
            display: inline-block;
            min-width: 120px;
            text-align: right;
        }

        /* QR Code section */
        .qrcode-section {
            text-align: center;
            margin-top: 40px;
        }

        .qrcode-section img {
            width: 120px;
            height: 120px;
        }

        .qrcode-section p {
            font-size: 13px;
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header: Logo and Invoice Number -->
        <div class="header">
            <div class="company-info">
                <!-- Using your existing logo path -->
                <img src="{{ public_path('images/logo.jpeg') }}" alt="Company Logo" class="company-logo">
                {{-- Replace with your company name from the image --}}
                <h2 class="company-name">Al-Mutamayiz Medical Care</h2>
            </div>
            <div class="invoice-title">
                <!-- Using your session ID for the invoice number -->
                <h1>Invoice #{{ $sessionPayment->session->id ?? 'N/A' }}</h1>
            </div>
        </div>

        <!-- Company Details: Tax, CR, Address -->
        <div class="company-details">
            {{-- Static text from the image. Replace with your actual details. --}}
            <p style="font-weight: bold; font-size: 16px;">Simplified Tax Invoice</p>
            <p>Tax No: 310388104700003</p>
            <p>CR: 2050126726</p>
            <p>King Saud St, Dammam 32248</p>
        </div>

        <!-- Customer Information Table -->
        <table class="customer-table">
            <tbody>
                <tr>
                    <th>Invoice For</th>
                    <td>{{ $sessionPayment->session->user->name ?? 'Not Specified' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $sessionPayment->session->user->phone ?? 'Not Specified' }}</td>
                </tr>
                <tr>
                    {{-- The image had "Identity", which isn't in your old code. Added as a placeholder. --}}
                    <th>Identity</th>
                    <td>{{ $sessionPayment->session->user->email ?? 'Not Specified' }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    {{-- Using the payment creation date. Adjust if needed. --}}
                    <td>{{ $sessionPayment->created_at->format('Y-m-d') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Service Details -->
        <div class="service-details">
            <p>
                <span>Main Service:</span> 
                {{-- Mapping your session type to "Main Service" --}}
                @if($sessionPayment->session)
                    @if($sessionPayment->session->session_category == 'hourly')
                        Hourly Workspace
                    @elseif($sessionPayment->session->session_category == 'subscription')
                        Subscription
                    @else
                        Additional Services
                    @endif
                @else
                    Not Specified
                @endif
            </p>
            <p>
                <span>Sub Service:</span>
                {{-- Using Subscription ID as "Sub Service" --}}
                Subscription ID #{{ $sessionPayment->session->id ?? 'N/A' }}
            </p>
            <p>
                <span>Details:</span>
                {{-- Placeholder for details. You can add more info here. --}}
                Payment for workspace subscription and services.
                Status:
                @if($sessionPayment->payment_status == 'paid')
                    Fully Paid
                @elseif($sessionPayment->payment_status == 'pending')
                    Pending
                @elseif($sessionPayment->payment_status == 'partial')
                    Partial Payment
                @else
                    {{ ucfirst($sessionPayment->payment_status) }}
                @endif
            </p>
        </div>

        <!--
            Calculating totals based on the image structure (Sub Total, VAT, Total).
            We assume your 'total_price' INCLUDES 15% VAT, so we back-calculate.
            If 'total_price' is pre-tax, you should adjust this logic.
        -->
        @php
            // Assume total_price includes 15% VAT
            $totalPrice = $sessionPayment->total_price ?? 0;
            $subTotal = $totalPrice / 1.15;
            $vat = $totalPrice - $subTotal;

            // Calculate refund (if any)
            $totalPaid = ($sessionPayment->amount_bank ?? 0) + ($sessionPayment->amount_cash ?? 0);
            $refundAmount = $totalPaid - $totalPrice;
            $refundDisplay = $refundAmount > 0 ? $refundAmount : 0.00;
        @endphp

        <!-- Items Table: Sub Total, VAT, Refunded, Total -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th style="text-align: right;">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sub Total</td>
                    <td style="text-align: right;">{{ number_format($subTotal, 2) }} SAR</td>
                </tr>
                <tr>
                    <td>Vat (15%)</td>
                    <td style="text-align: right;">{{ number_format($vat, 2) }} SAR</td>
                </tr>
                <tr>
                    <td>Refunded</td>
                    <td style="text-align: right;">{{ number_format($refundDisplay, 2) }} SAR</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td style="text-align: right;">
                        <!-- Styled box for the final total -->
                        <span class="total-value">{{ number_format($totalPrice, 2) }} SAR</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- QR Code Section -->
        <div class="qrcode-section">
            <!-- Using the same QR generator but pointing to your site -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=https://branchub.net/" alt="QR Code">
            <p>Scan to verify</p>
        </div>
    </div>
</body>
</html>