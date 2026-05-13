<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير المصروفات المالية</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', Tahoma, Arial, sans-serif;
            direction: rtl;
            margin: 20px;
            color: #222;
            background: #fff;
        }
        .header {
            border-bottom: 2px solid #222;
            margin-bottom: 16px;
            padding-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 8px;
        }
        .meta {
            color: #555;
            margin: 3px 0;
        }
        .box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 12px;
        }
        .box h3 {
            margin: 0 0 8px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: right;
            vertical-align: top;
        }
        th {
            background: #f1f1f1;
            font-weight: 700;
        }
        .num {
            direction: ltr;
            unicode-bidi: bidi-override;
            display: inline-block;
        }
        .hint {
            margin-top: 12px;
            color: #777;
            font-size: 12px;
        }
        @media print {
            body { margin: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">تقرير المصروفات المالية</h1>
        <p class="meta">تاريخ التصدير: <span class="num">{{ $generatedAt->format('Y-m-d H:i') }}</span></p>
        <p class="meta">عدد السجلات: <span class="num">{{ $stats->total_count ?? 0 }}</span></p>
    </div>

    <div class="box">
        <h3>الفلاتر المستخدمة</h3>
        <table>
            <tr>
                <td>من تاريخ</td>
                <td><span class="num">{{ $filters['from_date'] ?: 'الكل' }}</span></td>
                <td>إلى تاريخ</td>
                <td><span class="num">{{ $filters['to_date'] ?: 'الكل' }}</span></td>
            </tr>
            <tr>
                <td>نوع المصروف</td>
                <td>{{ $filters['selected_category'] ?: 'الكل' }}</td>
                <td>طريقة الدفع</td>
                <td>
                    @if($filters['payment_type'] === 'bank') بنكي
                    @elseif($filters['payment_type'] === 'cash') كاش
                    @else الكل
                    @endif
                </td>
            </tr>
            <tr>
                <td>من سعر</td>
                <td><span class="num">{{ $filters['from_price'] ?: 'الكل' }}</span></td>
                <td>إلى سعر</td>
                <td><span class="num">{{ $filters['to_price'] ?: 'الكل' }}</span></td>
            </tr>
        </table>
    </div>

    <div class="box">
        <h3>الإحصائيات</h3>
        <table>
            <tr>
                <td>إجمالي المصروفات</td>
                <td><span class="num">{{ number_format((float) ($stats->total_amount ?? 0), 2) }}</span> ₪</td>
                <td>مصروفات بنكية</td>
                <td><span class="num">{{ number_format((float) ($stats->bank_amount ?? 0), 2) }}</span> ₪</td>
                <td>مصروفات نقدية</td>
                <td><span class="num">{{ number_format((float) ($stats->cash_amount ?? 0), 2) }}</span> ₪</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم البند</th>
                <th>نوع المصروف</th>
                <th>المبلغ</th>
                <th>طريقة الدفع</th>
                <th>تاريخ الدفع</th>
                <th>المدخل</th>
                <th>التفاصيل</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td><span class="num">{{ $expense->id }}</span></td>
                    <td>{{ $expense->item_name }}</td>
                    <td>{{ $expense->expenseCategory?->name ?? 'غير محدد' }}</td>
                    <td><span class="num">{{ number_format($expense->amount, 2) }}</span> ₪</td>
                    <td>{{ $expense->payment_type === 'bank' ? 'بنكي' : 'كاش' }}</td>
                    <td><span class="num">{{ optional($expense->payment_date)->format('Y-m-d') }}</span></td>
                    <td>{{ $expense->user->name ?? '-' }}</td>
                    <td>{{ $expense->details }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">لا توجد بيانات مطابقة للفلاتر</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="hint">اختر "طباعة" ثم "Save as PDF" للحصول على ملف PDF بجودة عربية ممتازة.</p>
    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>
