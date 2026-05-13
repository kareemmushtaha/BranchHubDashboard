<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expenseCategories = ExpenseCategory::withCount('expenses')->orderBy('name')->paginate(20);

        return view('expense-categories.index', compact('expenseCategories'));
    }

    public function create()
    {
        return view('expense-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'اسم التصنيف مطلوب',
            'name.unique' => 'اسم التصنيف موجود مسبقاً',
            'status.required' => 'حالة التصنيف مطلوبة',
            'status.in' => 'حالة التصنيف غير صحيحة',
        ]);

        ExpenseCategory::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('expense-categories.index')->with('success', 'تم إضافة تصنيف المصروف بنجاح');
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        return redirect()->route('expense-categories.edit', $expenseCategory);
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('expense-categories.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name,' . $expenseCategory->id,
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'اسم التصنيف مطلوب',
            'name.unique' => 'اسم التصنيف موجود مسبقاً',
            'status.required' => 'حالة التصنيف مطلوبة',
            'status.in' => 'حالة التصنيف غير صحيحة',
        ]);

        $expenseCategory->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('expense-categories.index')->with('success', 'تم تحديث تصنيف المصروف بنجاح');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->expenses()->exists()) {
            return redirect()->route('expense-categories.index')->with('error', 'لا يمكن حذف التصنيف لأنه مستخدم في المصروفات');
        }

        $expenseCategory->delete();

        return redirect()->route('expense-categories.index')->with('success', 'تم حذف تصنيف المصروف بنجاح');
    }
}
