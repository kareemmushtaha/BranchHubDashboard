<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:bank,cash',
            'details' => 'required|string|max:1000',
        ], [
            'amount.required' => 'قيمة المبلغ مطلوبة',
            'amount.numeric' => 'قيمة المبلغ يجب أن تكون رقماً',
            'amount.min' => 'قيمة المبلغ يجب أن تكون أكبر من صفر',
            'payment_type.required' => 'نوع الدفع مطلوب',
            'payment_type.in' => 'نوع الدفع يجب أن يكون بنكي أو نقدي',
            'details.required' => 'التفاصيل مطلوبة',
            'details.max' => 'التفاصيل يجب أن تكون أقل من 1000 حرف',
        ]);

        Expense::create([
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
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
        $expense->load('user');
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:bank,cash',
            'details' => 'required|string|max:1000',
        ], [
            'amount.required' => 'قيمة المبلغ مطلوبة',
            'amount.numeric' => 'قيمة المبلغ يجب أن تكون رقماً',
            'amount.min' => 'قيمة المبلغ يجب أن تكون أكبر من صفر',
            'payment_type.required' => 'نوع الدفع مطلوب',
            'payment_type.in' => 'نوع الدفع يجب أن يكون بنكي أو نقدي',
            'details.required' => 'التفاصيل مطلوبة',
            'details.max' => 'التفاصيل يجب أن تكون أقل من 1000 حرف',
        ]);

        $expense->update([
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
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
