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
            'hourly_users' => User::where('user_type', 'hourly')->count(),
            'subscription_users' => User::where('user_type', 'subscription')->count(),
            'filtered_count' => $users->total(),
        ];

        return view('users.index', compact('users', 'stats'));
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
            'email' => 'nullable|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'user_type' => 'required|in:hourly,subscription',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $user = User::create([
            'name' => $request->name,
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
    public function show(User $user)
    {
        $user->load(['wallet', 'sessions.payment', 'sessions.drinks', 'overTimes']);
        $drinkInvoices = \App\Models\DrinkInvoice::where('user_id', $user->id)
            ->with(['items.drink'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('users.show', compact('user', 'drinkInvoices'));
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
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'user_type' => 'required|in:hourly,subscription',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'user_type', 'status'
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
                'balance' => 0
            ]);
        }

        $balanceBefore = $wallet->balance;
        $amount = $request->amount;
        $balanceAfter = $balanceBefore + $amount;

        // تحديث رصيد المحفظة
        $wallet->increment('balance', $amount);

        // حفظ سجل المعاملة
        WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'charge',
            'payment_method' => $request->payment_method,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'notes' => $request->notes,
            'reference' => 'CHARGE-' . time(),
            'admin_name' => 'مدير النظام' // يمكن تحديثه لاحقاً للمدير الحالي
        ]);

        return redirect()->back()
            ->with('success', "تم شحن المحفظة بمبلغ {$amount} بنجاح");
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
