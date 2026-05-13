<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\DrinkInvoiceItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class DrinkInvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('show drink-invoice-items');

        $query = $this->filteredItemsQuery($request)
            ->with(['drink', 'invoice.user']);

        $today = Carbon::today()->format('Y-m-d');
        $dateFrom = $request->filled('date_from') ? $request->date_from : $today;
        $dateTo = $request->filled('date_to') ? $request->date_to : $today;

        $totalPrice = (clone $query)->sum('price');

        $query->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');

        $perPage = $request->get('per_page', 15);
        $items = $query->paginate($perPage)->withQueryString();

        $users = User::where('status', 'active')
            ->where('user_type', 'subscription')
            ->orderBy('name')
            ->get();

        $drinks = Drink::where('status', 'available')
            ->orderBy('name')
            ->get();

        return view('drink-invoice-items.index', compact('items', 'dateFrom', 'dateTo', 'users', 'drinks', 'totalPrice'));
    }

    /**
     * Export filtered drink invoice line items as PDF with summary statistics.
     */
    public function exportPdf(Request $request)
    {
        $this->authorize('show drink-invoice-items');

        $baseQuery = $this->filteredItemsQuery($request);

        $today = Carbon::today()->format('Y-m-d');
        $dateFrom = $request->filled('date_from') ? $request->date_from : $today;
        $dateTo = $request->filled('date_to') ? $request->date_to : $today;

        $stats = (clone $baseQuery)->reorder()->selectRaw(
            'COUNT(*) as line_count,
            COALESCE(SUM(quantity), 0) as total_quantity,
            COALESCE(SUM(price), 0) as total_sales,
            COUNT(DISTINCT drink_invoice_id) as invoice_count'
        )->first();

        $byDrink = (clone $baseQuery)->reorder()
            ->selectRaw('drink_id, SUM(quantity) as qty_sum, SUM(price) as price_sum')
            ->groupBy('drink_id')
            ->orderByDesc('price_sum')
            ->get();

        $drinkIds = $byDrink->pluck('drink_id')->filter()->unique()->values();
        $drinkNames = Drink::whereIn('id', $drinkIds)->pluck('name', 'id');

        $items = (clone $baseQuery)
            ->with(['drink', 'invoice.user'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $selectedUser = null;
        if ($request->filled('user_id')) {
            $selectedUser = User::find($request->integer('user_id'));
        }

        $selectedDrink = null;
        if ($request->filled('drink_id')) {
            $selectedDrink = Drink::find($request->integer('drink_id'));
        }

        $filters = [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'user_name' => $selectedUser?->name,
            'drink_name' => $selectedDrink?->name,
        ];

        $generatedAt = now();

        $viewData = compact(
            'items',
            'stats',
            'byDrink',
            'drinkNames',
            'filters',
            'generatedAt'
        );

        if (class_exists(\Mpdf\Mpdf::class)) {
            try {
                return $this->drinkInvoiceItemsPdfViaMpdf($viewData);
            } catch (Throwable $e) {
                Log::warning('Drink invoice items PDF: mPDF failed, falling back to DomPDF.', [
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return $this->drinkInvoiceItemsPdfViaDompdf($viewData);
    }

    /**
     * @param  array<string, mixed>  $viewData
     */
    private function drinkInvoiceItemsPdfViaMpdf(array $viewData)
    {
        $html = view('drink-invoice-items.export-pdf', $viewData)->render();

        $tempDir = storage_path('app/tmp/mpdf');
        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 12,
            'margin_right' => 12,
            'margin_top' => 12,
            'margin_bottom' => 12,
            'default_font' => 'dejavusans',
            'tempDir' => $tempDir,
        ]);
        $mpdf->SetDirectionality('rtl');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);

        $filename = 'drink_invoice_items_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return response($mpdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    /**
     * @param  array<string, mixed>  $viewData
     */
    private function drinkInvoiceItemsPdfViaDompdf(array $viewData)
    {
        $filename = 'drink_invoice_items_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        $pdf = \PDF::loadView('drink-invoice-items.export-pdf', $viewData)
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }

    /**
     * Base query for drink invoice items with the same filters as the index listing.
     */
    private function filteredItemsQuery(Request $request): Builder
    {
        $query = DrinkInvoiceItem::query();

        $today = Carbon::today()->format('Y-m-d');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        } else {
            $query->whereDate('created_at', '>=', $today);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        } else {
            $query->whereDate('created_at', '<=', $today);
        }

        if ($request->filled('user_id')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        if ($request->filled('drink_id')) {
            $query->where('drink_id', $request->drink_id);
        }

        return $query;
    }
}
