<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // تحديد عدد العناصر في الصفحة (افتراضي 15)
        $perPage = $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        // بناء query المستخدمين
        $query = User::with('wallet');

        // البحث
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // فلترة حسب نوع المستخدم
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->get('user_type'));
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // ترتيب النتائج
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        if (in_array($sortBy, ['name', 'email', 'created_at', 'user_type', 'status', 'id'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('id', 'asc');
        }

        $users = $query->paginate($perPage)->appends($request->query());

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'hourly_users' => User::whereIn('user_type', ['hourly', 'prepaid'])->count(),
            'subscription_users' => User::where('user_type', 'subscription')->count(),
            'admin_users' => User::where('user_type', 'admin')->count(),
            'manager_users' => User::where('user_type', 'manager')->count(),
            'filtered_count' => $users->total(),
        ];

        $pageTitle = 'إدارة المستخدمين';
        $userTypeFilter = null;

        return view('users.index', compact('users', 'stats', 'pageTitle', 'userTypeFilter'));
    }

    /**
     * Display monthly (subscription) users.
     */
    public function monthly(Request $request)
    {
        // تحديد عدد العناصر في الصفحة (افتراضي 15)
        $perPage = $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        // بناء query المستخدمين الشهري فقط
        $query = User::with('wallet')->where('user_type', 'subscription');

        // البحث
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // ترتيب النتائج
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        if (in_array($sortBy, ['name', 'email', 'created_at', 'user_type', 'status', 'id'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('id', 'asc');
        }

        $users = $query->paginate($perPage)->appends($request->query());

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'hourly_users' => User::whereIn('user_type', ['hourly', 'prepaid'])->count(),
            'subscription_users' => User::where('user_type', 'subscription')->count(),
            'admin_users' => User::where('user_type', 'admin')->count(),
            'manager_users' => User::where('user_type', 'manager')->count(),
            'filtered_count' => $users->total(),
        ];

        $pageTitle = 'المستخدمين الشهري';
        $userTypeFilter = 'subscription';

        return view('users.index', compact('users', 'stats', 'pageTitle', 'userTypeFilter'));
    }

    /**
     * Display hourly users.
     */
    public function hourly(Request $request)
    {
        // تحديد عدد العناصر في الصفحة (افتراضي 15)
        $perPage = $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        // بناء query المستخدمين الساعات ومسبق الدفع فقط
        $query = User::with('wallet')->where('user_type', 'hourly');

        // البحث
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // ترتيب النتائج
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        if (in_array($sortBy, ['name', 'email', 'created_at', 'user_type', 'status', 'id'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('id', 'asc');
        }

        $users = $query->paginate($perPage)->appends($request->query());

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'hourly_users' => User::whereIn('user_type', ['hourly', 'prepaid'])->count(),
            'subscription_users' => User::where('user_type', 'subscription')->count(),
            'admin_users' => User::where('user_type', 'admin')->count(),
            'manager_users' => User::where('user_type', 'manager')->count(),
            'filtered_count' => $users->total(),
        ];

        $pageTitle = 'المستخدمين الساعات';
        $userTypeFilter = 'hourly';

        return view('users.index', compact('users', 'stats', 'pageTitle', 'userTypeFilter'));
    }

    /**
     * Display prepaid users.
     */
    public function prepaid(Request $request)
    {
        // تحديد عدد العناصر في الصفحة (افتراضي 15)
        $perPage = $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        // بناء query المستخدمين مسبقين الدفع فقط
        $query = User::with('wallet')->where('user_type', 'prepaid');

        // البحث
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // ترتيب النتائج
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        if (in_array($sortBy, ['name', 'email', 'created_at', 'user_type', 'status', 'id'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('id', 'asc');
        }

        $users = $query->paginate($perPage)->appends($request->query());

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'hourly_users' => User::whereIn('user_type', ['hourly', 'prepaid'])->count(),
            'subscription_users' => User::where('user_type', 'subscription')->count(),
            'admin_users' => User::where('user_type', 'admin')->count(),
            'manager_users' => User::where('user_type', 'manager')->count(),
            'filtered_count' => $users->total(),
        ];

        $pageTitle = 'المستخدمين مسبقين الدفع';
        $userTypeFilter = 'prepaid';

        return view('users.index', compact('users', 'stats', 'pageTitle', 'userTypeFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'user_type' => 'required|in:hourly,prepaid,subscription,admin,manager',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $user = User::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'email' => $request->email,
            'password' => Hash::make('password'), // كلمة مرور افتراضية
            'phone' => $request->phone,
            'user_type' => $request->user_type,
            'status' => $request->status
        ]);

        // إنشاء محفظة للمستخدم
        UserWallet::create([
            'user_id' => $user->id,
            'balance' => 0
        ]);

        return redirect()->route('users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        $user->load(['wallet', 'overTimes']);
        
        // Paginate sessions ordered by latest first
        $perPage = $request->get('per_page', 10);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 10;
        }
        
        $sessions = $user->sessions()
            ->with(['payment', 'drinks'])
            ->orderBy('start_at', 'desc')
            ->paginate($perPage);
        
        $drinkInvoices = \App\Models\DrinkInvoice::where('user_id', $user->id)
            ->with(['items.drink'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('users.show', compact('user', 'drinkInvoices', 'sessions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'user_type' => 'required|in:hourly,prepaid,subscription,admin,manager',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $user->update($request->only([
            'name', 'name_ar', 'email', 'phone', 'user_type', 'status'
        ]));

        return redirect()->route('users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(User $user)
    {
        $user->delete(); // Soft delete because of SoftDeletes trait
        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستخدم بنجاح (يمكن استرجاعه لاحقاً)');
    }

    /**
     * Display deleted users.
     */
    public function trashed(Request $request)
    {
        // تحديد عدد العناصر في الصفحة (افتراضي 15)
        $perPage = $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        // بناء query المستخدمين المحذوفين
        $query = User::onlyTrashed()->with('wallet');

        // البحث في المستخدمين المحذوفين
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // فلترة حسب نوع المستخدم
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->get('user_type'));
        }

        // ترتيب النتائج
        $sortBy = $request->get('sort_by', 'deleted_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['name', 'email', 'deleted_at', 'created_at', 'user_type'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('deleted_at', 'desc');
        }

        $trashedUsers = $query->paginate($perPage)->appends($request->query());

        $stats = [
            'total_deleted' => User::onlyTrashed()->count(),
            'active_users' => User::count(),
            'total_users' => User::withTrashed()->count(),
            'filtered_count' => $trashedUsers->total(),
        ];

        return view('users.trashed', compact('trashedUsers', 'stats'));
    }

    /**
     * Restore deleted user.
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trashed')
            ->with('success', 'تم استرجاع المستخدم بنجاح');
    }

    /**
     * Force delete user permanently.
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        // حذف المحفظة أولاً
        if ($user->wallet) {
            $user->wallet->delete();
        }

        // حذف المستخدم نهائياً
        $user->forceDelete();

        return redirect()->route('users.trashed')
            ->with('success', 'تم حذف المستخدم نهائياً');
    }

    /**
     * Bulk delete users (Soft Delete).
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $userIds = $request->user_ids;
        $users = User::whereIn('id', $userIds)->get();

        // تحقق من وجود المستخدمين
        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'لم يتم العثور على مستخدمين للحذف');
        }

        // حذف المستخدمين (Soft Delete)
        User::whereIn('id', $userIds)->delete();

        $count = count($userIds);
        return redirect()->route('users.index')
            ->with('success', "تم حذف {$count} مستخدم بنجاح (يمكن استرجاعهم لاحقاً)");
    }

    /**
     * Bulk restore deleted users.
     */
    public function bulkRestore(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'integer'
        ]);

        $userIds = $request->user_ids;
        $users = User::onlyTrashed()->whereIn('id', $userIds)->get();

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'لم يتم العثور على مستخدمين محذوفين للاسترجاع');
        }

        // استرجاع المستخدمين
        User::onlyTrashed()->whereIn('id', $userIds)->restore();

        $count = count($userIds);
        return redirect()->route('users.trashed')
            ->with('success', "تم استرجاع {$count} مستخدم بنجاح");
    }

    /**
     * Bulk force delete users permanently.
     */
    public function bulkForceDelete(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'integer'
        ]);

        $userIds = $request->user_ids;
        $users = User::onlyTrashed()->whereIn('id', $userIds)->get();

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'لم يتم العثور على مستخدمين محذوفين');
        }

        // حذف المحافظ المرتبطة أولاً
        foreach ($users as $user) {
            if ($user->wallet) {
                $user->wallet->delete();
            }
        }

        // حذف المستخدمين نهائياً
        User::onlyTrashed()->whereIn('id', $userIds)->forceDelete();

        $count = count($userIds);
        return redirect()->route('users.trashed')
            ->with('success', "تم حذف {$count} مستخدم نهائياً");
    }

    /**
     * Charge user wallet
     */
    public function chargeWallet(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer',
            'notes' => 'nullable|string|max:500'
        ]);

        $wallet = $user->wallet;
        if (!$wallet) {
            $wallet = UserWallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'debt' => 0
            ]);
        }

        $balanceBefore = $wallet->balance;
        $amount = $request->amount;
        $debtBefore = $wallet->debt ?? 0;

        // خصم الدين من المبلغ المشحون
        $remainingDebt = max(0, $debtBefore - $amount);
        $amountAfterDebt = max(0, $amount - $debtBefore);

        // تحديث رصيد المحفظة (بعد خصم الدين)
        $balanceAfter = $balanceBefore + $amountAfterDebt;
        $wallet->update([
            'balance' => $balanceAfter,
            'debt' => $remainingDebt
        ]);

        // حفظ سجل المعاملة
        $notes = $request->notes;
        if ($debtBefore > 0) {
            $debtPaid = min($debtBefore, $amount);
            $notes = ($notes ? $notes . ' | ' : '') . "تم خصم {$debtPaid} من الدين. الدين المتبقي: {$remainingDebt}";
        }

        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'charge',
            'payment_method' => $request->payment_method,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'notes' => $notes,
            'reference' => 'CHARGE-' . time(),
            'admin_name' => 'مدير النظام' // يمكن تحديثه لاحقاً للمدير الحالي
        ]);

        $message = "تم شحن المحفظة بمبلغ {$amount} بنجاح";
        if ($debtBefore > 0 && $debtPaid > 0) {
            $message .= ". تم خصم {$debtPaid} من الدين";
            if ($remainingDebt > 0) {
                $message .= ". الدين المتبقي: {$remainingDebt}";
            } else {
                $message .= ". تم سداد الدين بالكامل";
            }
        }

        return redirect()->back()
            ->with('success', $message);
    }

    /**
     * Deduct from user wallet
     */
    public function deductWallet(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:500'
        ]);

        $wallet = $user->wallet;
        if (!$wallet) {
            return redirect()->back()
                ->with('error', 'المستخدم لا يملك محفظة');
        }

        $balanceBefore = $wallet->balance;
        $amount = $request->amount;

        // التحقق من أن الرصيد كافي
        if ($balanceBefore < $amount) {
            return redirect()->back()
                ->with('error', 'الرصيد غير كافي. الرصيد الحالي: ₪' . number_format($balanceBefore, 2));
        }

        $balanceAfter = $balanceBefore - $amount;

        // تحديث رصيد المحفظة
        $wallet->decrement('balance', $amount);

        // حفظ سجل المعاملة
        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'deduct',
            'payment_method' => 'cash', // استخدام cash كقيمة افتراضية للعمليات اليدوية
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'notes' => $request->notes,
            'reference' => 'DEDUCT-' . time(),
            'admin_name' => 'مدير النظام' // يمكن تحديثه لاحقاً للمدير الحالي
        ]);

        return redirect()->back()
            ->with('success', "تم خصم مبلغ {$amount} من المحفظة بنجاح");
    }

    /**
     * Update wallet transaction
     */
    public function updateTransaction(Request $request, User $user, WalletTransaction $transaction)
    {
        // التحقق من أن المعاملة تخص المستخدم
        if ($transaction->user_id !== $user->id) {
            return redirect()->back()
                ->with('error', 'المعاملة غير موجودة');
        }

        $request->validate([
            'transaction_date' => 'required|date',
            'transaction_time' => 'required|date_format:H:i',
            'payment_method' => 'required|in:cash,bank_transfer',
            'amount' => 'nullable|numeric|min:0.01', // مطلوب لحركات الدين والخصم
            'notes' => 'nullable|string|max:500',
        ]);

        // دمج التاريخ والوقت
        $transactionDateTime = $request->transaction_date . ' ' . $request->transaction_time;

        $updateData = [
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'created_at' => $transactionDateTime,
            'updated_at' => now(),
        ];

        $wallet = $user->wallet;
        if (!$wallet) {
            return redirect()->back()
                ->with('error', 'المستخدم لا يملك محفظة');
        }

        $amountDifference = null;

        // إذا كانت المعاملة من نوع دين وتم تعديل المبلغ
        if ($transaction->type == 'debt' && $request->has('amount') && $request->amount != $transaction->amount) {
            $oldAmount = $transaction->amount;
            $newAmount = $request->amount;
            $amountDifference = $newAmount - $oldAmount;

            // تحديث مبلغ المعاملة
            $updateData['amount'] = $newAmount;

            // تحديث الدين في المحفظة
            $currentDebt = $wallet->debt ?? 0;
            $newDebt = $currentDebt + $amountDifference;

            // التأكد من أن الدين لا يكون سالب
            if ($newDebt < 0) {
                return redirect()->back()
                    ->with('error', 'لا يمكن تعديل المبلغ لأن الدين سيصبح سالباً');
            }

            $wallet->update([
                'debt' => $newDebt
            ]);
        }

        // إذا كانت المعاملة من نوع خصم وتم تعديل المبلغ
        if ($transaction->type == 'deduct' && $request->has('amount') && $request->amount != $transaction->amount) {
            $oldAmount = $transaction->amount;
            $newAmount = $request->amount;
            $amountDifference = $newAmount - $oldAmount;

            // تحديث مبلغ المعاملة
            $updateData['amount'] = $newAmount;

            // الحالة الأولى: زيادة المبلغ (الخصم الإضافي)
            if ($amountDifference > 0) {
                // التحقق من أن الرصيد كافي للخصم الإضافي
                $currentBalance = $wallet->balance;
                if ($currentBalance < $amountDifference) {
                    return redirect()->back()
                        ->with('error', 'الرصيد غير كافي. الرصيد الحالي: ₪' . number_format($currentBalance, 2) . ' والمطلوب: ₪' . number_format($amountDifference, 2));
                }

                // خصم الفرق من الرصيد
                $wallet->decrement('balance', $amountDifference);

                // تحديث balance_before و balance_after في المعاملة
                $updateData['balance_before'] = $transaction->balance_before;
                $updateData['balance_after'] = $transaction->balance_after - $amountDifference;
            }
            // الحالة الثانية: تقليل المبلغ (استرداد)
            else {
                $refundAmount = abs($amountDifference);

                // إضافة الفرق للرصيد
                $wallet->increment('balance', $refundAmount);

                // تحديث balance_before و balance_after في المعاملة
                $updateData['balance_before'] = $transaction->balance_before;
                $updateData['balance_after'] = $transaction->balance_after + $refundAmount;
            }
        }

        // تحديث المعاملة
        $transaction->update($updateData);

        $message = 'تم تحديث المعاملة بنجاح';
        if ($transaction->type == 'debt' && isset($amountDifference)) {
            $message .= '. تم تحديث الدين في المحفظة';
        } elseif ($transaction->type == 'deduct' && isset($amountDifference)) {
            if ($amountDifference > 0) {
                $message .= '. تم خصم ₪' . number_format($amountDifference, 2) . ' من الرصيد';
            } else {
                $message .= '. تم إضافة ₪' . number_format(abs($amountDifference), 2) . ' للرصيد';
            }
        }

        return redirect()->back()
            ->with('success', $message);
    }

    /**
     * Add debt to user wallet
     */
    public function addDebt(Request $request, User $user)
    {
        $request->validate([
            'debt_amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:500'
        ]);

        $wallet = $user->wallet;
        if (!$wallet) {
            $wallet = UserWallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'debt' => 0
            ]);
        }

        $debtBefore = $wallet->debt ?? 0;
        $debtAmount = $request->debt_amount;
        $debtAfter = $debtBefore + $debtAmount;

        // تحديث الدين
        $wallet->update([
            'debt' => $debtAfter
        ]);

        // حفظ سجل المعاملة للدين
        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'debt',
            'payment_method' => 'cash',
            'amount' => $debtAmount,
            'balance_before' => $wallet->balance,
            'balance_after' => $wallet->balance,
            'notes' => ($request->notes ? $request->notes . ' | ' : '') . "تسجيل دين. إجمالي الدين: {$debtAfter}",
            'reference' => 'DEBT-' . time(),
            'admin_name' => 'مدير النظام'
        ]);

        return redirect()->back()
            ->with('success', "تم تسجيل دين بمبلغ {$debtAmount}. إجمالي الدين: {$debtAfter}");
    }

    /**
     * Delete all wallet transactions
     */
    public function deleteAllTransactions(User $user)
    {
        $transactionsCount = $user->walletTransactions()->count();

        if ($transactionsCount == 0) {
            return redirect()->back()
                ->with('error', 'لا توجد حركات مالية للحذف');
        }

        // حذف جميع الحركات المالية
        $user->walletTransactions()->delete();

        return redirect()->back()
            ->with('success', "تم حذف {$transactionsCount} حركة مالية بنجاح");
    }

    /**
     * Show wallet transaction history
     */
    public function walletHistory(User $user)
    {
        $transactions = $user->walletTransactions()->paginate(20);
        $wallet = $user->wallet;

        return view('users.wallet-history', compact('user', 'transactions', 'wallet'));
    }
}
