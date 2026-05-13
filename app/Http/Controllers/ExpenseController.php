<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->applyFilters($request);

        $expenses = $query->clone()
            ->orderBy('payment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $stats = $query->clone()->selectRaw(
            'COUNT(*) as total_count,
             COALESCE(SUM(amount), 0) as total_amount,
             COALESCE(SUM(CASE WHEN payment_type = "bank" THEN amount ELSE 0 END), 0) as bank_amount,
             COALESCE(SUM(CASE WHEN payment_type = "cash" THEN amount ELSE 0 END), 0) as cash_amount'
        )->first();

        $expenseCategories = ExpenseCategory::where('status', 'active')->orderBy('name')->get();

        return view('expenses.index', compact('expenses', 'stats', 'expenseCategories'));
    }

    /**
     * Export filtered expenses report as PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = $this->applyFilters($request);

        $expenses = $query->clone()
            ->orderBy('payment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = $query->clone()->selectRaw(
            'COUNT(*) as total_count,
             COALESCE(SUM(amount), 0) as total_amount,
             COALESCE(SUM(CASE WHEN payment_type = "bank" THEN amount ELSE 0 END), 0) as bank_amount,
             COALESCE(SUM(CASE WHEN payment_type = "cash" THEN amount ELSE 0 END), 0) as cash_amount'
        )->first();

        $selectedCategory = null;
        if ($request->filled('expense_category_id')) {
            $selectedCategory = ExpenseCategory::find($request->integer('expense_category_id'));
        }

        $filters = [
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'from_price' => $request->input('from_price'),
            'to_price' => $request->input('to_price'),
            'payment_type' => $request->input('payment_type'),
            'selected_category' => $selectedCategory?->name,
        ];

        $generatedAt = now();

        $pdf = \PDF::loadView('expenses.export-pdf', compact('expenses', 'stats', 'filters', 'generatedAt'))
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('expenses_report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Export filtered expenses as print-ready Arabic page (browser PDF).
     */
    public function exportPrint(Request $request)
    {
        $query = $this->applyFilters($request);

        $expenses = $query->clone()
            ->orderBy('payment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = $query->clone()->selectRaw(
            'COUNT(*) as total_count,
             COALESCE(SUM(amount), 0) as total_amount,
             COALESCE(SUM(CASE WHEN payment_type = "bank" THEN amount ELSE 0 END), 0) as bank_amount,
             COALESCE(SUM(CASE WHEN payment_type = "cash" THEN amount ELSE 0 END), 0) as cash_amount'
        )->first();

        $selectedCategory = null;
        if ($request->filled('expense_category_id')) {
            $selectedCategory = ExpenseCategory::find($request->integer('expense_category_id'));
        }

        $filters = [
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'from_price' => $request->input('from_price'),
            'to_price' => $request->input('to_price'),
            'payment_type' => $request->input('payment_type'),
            'selected_category' => $selectedCategory?->name,
        ];

        $generatedAt = now();

        return view('expenses.export-print', compact('expenses', 'stats', 'filters', 'generatedAt'));
    }

    /**
     * Apply index filters to expenses query.
     */
    private function applyFilters(Request $request)
    {
        $query = Expense::with(['user', 'expenseCategory']);

        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->input('to_date'));
        }

        if ($request->filled('expense_category_id')) {
            $query->where('expense_category_id', $request->integer('expense_category_id'));
        }

        if ($request->filled('from_price')) {
            $query->where('amount', '>=', $request->input('from_price'));
        }

        if ($request->filled('to_price')) {
            $query->where('amount', '<=', $request->input('to_price'));
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->input('payment_type'));
        }

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenseCategories = ExpenseCategory::where('status', 'active')->orderBy('name')->get();

        return view('expenses.create', compact('expenseCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:bank,cash',
            'payment_date' => 'nullable|date',
            'details' => 'required|string|max:1000',
        ], [
            'item_name.required' => 'اسم البند مطلوب',
            'item_name.max' => 'اسم البند يجب أن يكون أقل من 255 حرف',
            'expense_category_id.required' => 'تصنيف المصروف مطلوب',
            'expense_category_id.exists' => 'تصنيف المصروف غير موجود',
            'amount.required' => 'قيمة المبلغ مطلوبة',
            'amount.numeric' => 'قيمة المبلغ يجب أن تكون رقماً',
            'amount.min' => 'قيمة المبلغ يجب أن تكون أكبر من صفر',
            'payment_type.required' => 'نوع الدفع مطلوب',
            'payment_type.in' => 'نوع الدفع يجب أن يكون بنكي أو نقدي',
            'payment_date.date' => 'تاريخ الدفع يجب أن يكون تاريخاً صحيحاً',
            'details.required' => 'التفاصيل مطلوبة',
            'details.max' => 'التفاصيل يجب أن تكون أقل من 1000 حرف',
        ]);

        Expense::create([
            'item_name' => $request->item_name,
            'expense_category_id' => $request->expense_category_id,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'payment_date' => $request->payment_date ?? now()->toDateString(),
            'details' => $request->details,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'تم إضافة المصروف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $expense->load(['user', 'expenseCategory']);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $expense->load('user');
        $expenseCategories = ExpenseCategory::where('status', 'active')
            ->orWhere('id', $expense->expense_category_id)
            ->orderBy('name')
            ->get();

        return view('expenses.edit', compact('expense', 'expenseCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:bank,cash',
            'payment_date' => 'nullable|date',
            'details' => 'required|string|max:1000',
        ], [
            'item_name.required' => 'اسم البند مطلوب',
            'item_name.max' => 'اسم البند يجب أن يكون أقل من 255 حرف',
            'expense_category_id.required' => 'تصنيف المصروف مطلوب',
            'expense_category_id.exists' => 'تصنيف المصروف غير موجود',
            'amount.required' => 'قيمة المبلغ مطلوبة',
            'amount.numeric' => 'قيمة المبلغ يجب أن تكون رقماً',
            'amount.min' => 'قيمة المبلغ يجب أن تكون أكبر من صفر',
            'payment_type.required' => 'نوع الدفع مطلوب',
            'payment_type.in' => 'نوع الدفع يجب أن يكون بنكي أو نقدي',
            'payment_date.date' => 'تاريخ الدفع يجب أن يكون تاريخاً صحيحاً',
            'details.required' => 'التفاصيل مطلوبة',
            'details.max' => 'التفاصيل يجب أن تكون أقل من 1000 حرف',
        ]);

        $expense->update([
            'item_name' => $request->item_name,
            'expense_category_id' => $request->expense_category_id,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'payment_date' => $request->payment_date ?? now()->toDateString(),
            'details' => $request->details,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'تم تحديث المصروف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'تم حذف المصروف بنجاح');
    }
}
