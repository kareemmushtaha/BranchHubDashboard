<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير المصروفات</title>
    <style>
        @page {
            margin: 18px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            direction: rtl;
            unicode-bidi: embed;
        }
        .header {
            margin-bottom: 16px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .meta {
            font-size: 11px;
            color: #555;
            margin-bottom: 4px;
        }
        .filters, .stats {
            margin-bottom: 16px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: right;
            vertical-align: top;
            direction: rtl;
            unicode-bidi: embed;
        }
        th {
            background: #f1f1f1;
        }
        .small {
            font-size: 10px;
            color: #666;
        }
        .num {
            direction: ltr;
            unicode-bidi: bidi-override;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">تقرير المصروفات المالية</div>
        <div class="meta">تاريخ التصدير: <span class="num">{{ $generatedAt->format('Y-m-d H:i') }}</span></div>
        <div class="meta">عدد السجلات: <span class="num">{{ $stats->total_count ?? 0 }}</span></div>
    </div>

    <div class="filters">
        <div class="section-title">الفلاتر المستخدمة</div>
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
                    @if($filters['payment_type'] === 'bank')
                        بنكي
                    @elseif($filters['payment_type'] === 'cash')
                        كاش
                    @else
                        الكل
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

    <div class="stats">
        <div class="section-title">إحصائيات</div>
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

    <p class="small" style="margin-top: 10px;">تم إنشاء هذا التقرير تلقائياً من نظام BranchHUB.</p>
</body>
</html>
