<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير عناصر فواتير المشروبات</title>
    <style>
        @page {
            margin: 18px;
        }
        body {
            font-family: 'DejaVu Sans', dejavusans, sans-serif;
            font-size: 11px;
            color: #222;
            margin: 0;
            direction: rtl;
        }
        .header {
            margin-bottom: 14px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .meta {
            font-size: 10px;
            color: #555;
            margin-bottom: 3px;
        }
        .filters, .stats {
            margin-bottom: 12px;
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: right;
            vertical-align: top;
            direction: rtl;
        }
        th {
            background: #f1f1f1;
        }
        .small {
            font-size: 9px;
            color: #666;
        }
        .num {
            direction: ltr;
            unicode-bidi: isolate;
            display: inline-block;
        }
        .by-drink-table {
            margin-bottom: 12px;
        }
        .by-drink-table th, .by-drink-table td {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">تقرير عناصر فواتير المشروبات (المشتركين شهرياً)</div>
        <div class="meta">تاريخ التصدير: <span class="num">{{ $generatedAt->format('Y-m-d H:i') }}</span></div>
        <div class="meta">عدد السطور في التقرير: <span class="num">{{ $stats->line_count ?? 0 }}</span></div>
    </div>

    <div class="filters">
        <div class="section-title">الفلاتر المستخدمة</div>
        <table>
            <tr>
                <td>من تاريخ</td>
                <td><span class="num">{{ $filters['date_from'] }}</span></td>
                <td>إلى تاريخ</td>
                <td><span class="num">{{ $filters['date_to'] }}</span></td>
            </tr>
            <tr>
                <td>المستخدم</td>
                <td>{{ $filters['user_name'] ?? 'الكل' }}</td>
                <td>نوع المشروب</td>
                <td>{{ $filters['drink_name'] ?? 'الكل' }}</td>
            </tr>
        </table>
    </div>

    <div class="stats">
        <div class="section-title">إحصائيات</div>
        <table>
            <tr>
                <td>عدد بنود الفاتورة</td>
                <td><span class="num">{{ $stats->line_count ?? 0 }}</span></td>
                <td>إجمالي الكمية</td>
                <td><span class="num">{{ number_format((float) ($stats->total_quantity ?? 0), 0) }}</span></td>
                <td>إجمالي المبيعات</td>
                <td><span class="num">{{ number_format((float) ($stats->total_sales ?? 0), 2) }}</span> ₪</td>
                <td>عدد الفواتير</td>
                <td><span class="num">{{ $stats->invoice_count ?? 0 }}</span></td>
            </tr>
        </table>
    </div>

    @if($byDrink->isNotEmpty())
    <div class="by-drink-table">
        <div class="section-title">ملخص حسب المشروب</div>
        <table>
            <thead>
                <tr>
                    <th>المشروب</th>
                    <th>الكمية</th>
                    <th>إجمالي السعر</th>
                </tr>
            </thead>
            <tbody>
                @foreach($byDrink as $row)
                <tr>
                    <td>
                        @if($row->drink_id)
                            {{ $drinkNames[$row->drink_id] ?? 'غير متوفر' }}
                        @else
                            غير محدد
                        @endif
                    </td>
                    <td><span class="num">{{ number_format((float) $row->qty_sum, 0) }}</span></td>
                    <td><span class="num">{{ number_format((float) $row->price_sum, 2) }}</span> ₪</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="section-title" style="margin-bottom: 6px;">تفاصيل البنود</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>المشروب</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>رقم الفاتورة</th>
                <th>المستخدم</th>
                <th>تاريخ الإضافة</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td><span class="num">{{ $item->id }}</span></td>
                <td>{{ $item->drink?->name ?? 'غير متوفر' }}</td>
                <td><span class="num">{{ $item->quantity }}</span></td>
                <td><span class="num">{{ number_format((float) $item->price, 2) }}</span> ₪</td>
                <td><span class="num">{{ $item->invoice?->id ?? '-' }}</span></td>
                <td>{{ $item->invoice?->user?->name ?? '-' }}</td>
                <td><span class="num">{{ $item->created_at->format('Y-m-d H:i') }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">لا توجد بيانات مطابقة للفلاتر</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p class="small" style="margin-top: 8px;">تم إنشاء هذا التقرير تلقائياً من نظام BranchHUB.</p>
</body>
</html>
