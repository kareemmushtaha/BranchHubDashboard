<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employeeSalaries = EmployeeSalary::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('employee-salaries.index', compact('employeeSalaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee-salaries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'salary_date' => 'nullable|date',
            'cash_amount' => 'required|numeric|min:0',
            'bank_amount' => 'required|numeric|min:0',
            'transfer_type' => 'required|in:partial,full',
            'notes' => 'nullable|string|max:1000',
        ], [
            'employee_name.required' => 'اسم الموظف مطلوب',
            'employee_name.max' => 'اسم الموظف يجب أن يكون أقل من 255 حرف',
            'salary_date.date' => 'تاريخ الراتب يجب أن يكون تاريخاً صحيحاً',
            'cash_amount.required' => 'المبلغ الكاش مطلوب',
            'cash_amount.numeric' => 'المبلغ الكاش يجب أن يكون رقماً',
            'cash_amount.min' => 'المبلغ الكاش يجب أن يكون أكبر من أو يساوي صفر',
            'bank_amount.required' => 'المبلغ البنكي مطلوب',
            'bank_amount.numeric' => 'المبلغ البنكي يجب أن يكون رقماً',
            'bank_amount.min' => 'المبلغ البنكي يجب أن يكون أكبر من أو يساوي صفر',
            'transfer_type.required' => 'نوع الحوالة مطلوب',
            'transfer_type.in' => 'نوع الحوالة يجب أن يكون راتب جزئي أو راتب كامل',
            'notes.max' => 'الملاحظات يجب أن تكون أقل من 1000 حرف',
        ]);

        EmployeeSalary::create([
            'employee_name' => $request->employee_name,
            'salary_date' => $request->salary_date ?? now()->toDateString(),
            'cash_amount' => $request->cash_amount ?? 0,
            'bank_amount' => $request->bank_amount ?? 0,
            'transfer_type' => $request->transfer_type,
            'notes' => $request->notes,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('employee-salaries.index')
            ->with('success', 'تم إضافة راتب الموظف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        $employeeSalary->load('user');
        return view('employee-salaries.show', compact('employeeSalary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSalary $employeeSalary)
    {
        return view('employee-salaries.edit', compact('employeeSalary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'salary_date' => 'nullable|date',
            'cash_amount' => 'required|numeric|min:0',
            'bank_amount' => 'required|numeric|min:0',
            'transfer_type' => 'required|in:partial,full',
            'notes' => 'nullable|string|max:1000',
        ], [
            'employee_name.required' => 'اسم الموظف مطلوب',
            'employee_name.max' => 'اسم الموظف يجب أن يكون أقل من 255 حرف',
            'salary_date.date' => 'تاريخ الراتب يجب أن يكون تاريخاً صحيحاً',
            'cash_amount.required' => 'المبلغ الكاش مطلوب',
            'cash_amount.numeric' => 'المبلغ الكاش يجب أن يكون رقماً',
            'cash_amount.min' => 'المبلغ الكاش يجب أن يكون أكبر من أو يساوي صفر',
            'bank_amount.required' => 'المبلغ البنكي مطلوب',
            'bank_amount.numeric' => 'المبلغ البنكي يجب أن يكون رقماً',
            'bank_amount.min' => 'المبلغ البنكي يجب أن يكون أكبر من أو يساوي صفر',
            'transfer_type.required' => 'نوع الحوالة مطلوب',
            'transfer_type.in' => 'نوع الحوالة يجب أن يكون راتب جزئي أو راتب كامل',
            'notes.max' => 'الملاحظات يجب أن تكون أقل من 1000 حرف',
        ]);

        $employeeSalary->update([
            'employee_name' => $request->employee_name,
            'salary_date' => $request->salary_date ?? now()->toDateString(),
            'cash_amount' => $request->cash_amount ?? 0,
            'bank_amount' => $request->bank_amount ?? 0,
            'transfer_type' => $request->transfer_type,
            'notes' => $request->notes,
        ]);

        return redirect()->route('employee-salaries.index')
            ->with('success', 'تم تحديث راتب الموظف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSalary $employeeSalary)
    {
        $employeeSalary->delete();

        return redirect()->route('employee-salaries.index')
            ->with('success', 'تم حذف راتب الموظف بنجاح');
    }
}
