<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use App\Models\SessionPayment;
use App\Models\SessionDrink;
use App\Models\Drink;
use App\Models\PublicPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Session::with(['user', 'payment']);

        // Filter by session category
        if ($request->filled('session_category')) {
            $query->where('session_category', $request->session_category);
        }

        // Filter by session status
        if ($request->filled('session_status')) {
            $query->where('session_status', $request->session_status);
        }

        // Search by user name or session owner name
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                // Search in user name, email, phone
                $q->whereHas('user', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('email', 'like', '%' . $searchTerm . '%')
                              ->orWhere('phone', 'like', '%' . $searchTerm . '%');
                })
                // Search in session owner name
                ->orWhere('session_owner', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            if ($request->payment_status === 'no_payment') {
                $query->whereDoesntHave('payment');
            } else {
                $query->whereHas('payment', function ($q) use ($request) {
                    $q->where('payment_status', $request->payment_status);
                });
            }
        }

        // Filter by refund status
        if ($request->filled('refund_status')) {
            if ($request->refund_status === 'needs_refund') {
                // الجلسات التي تحتاج إرجاع (المبلغ المدفوع أكبر من التكلفة)
                $query->whereHas('payment', function ($q) {
                    $q->whereRaw('(amount_bank + amount_cash) > total_price');
                });
            } elseif ($request->refund_status === 'has_remaining') {
                // الجلسات التي لها مبلغ متبقي للدفع (المبلغ المدفوع أقل من التكلفة)
                $query->whereHas('payment', function ($q) {
                    $q->whereRaw('(amount_bank + amount_cash) < total_price');
                });
            } elseif ($request->refund_status === 'fully_paid') {
                // الجلسات المدفوعة بالكامل (المبلغ المدفوع يساوي التكلفة)
                $query->whereHas('payment', function ($q) {
                    $q->whereRaw('(amount_bank + amount_cash) = total_price');
                });
            }
        }

        // Filter by session start date
        if ($request->filled('start_date_from')) {
            $query->whereDate('start_at', '>=', $request->start_date_from);
        }

        if ($request->filled('start_date_to')) {
            $query->whereDate('start_at', '<=', $request->start_date_to);
        }

        $sessions = $query->orderBy('id', 'desc')->paginate(20);

        // Keep filter parameters in pagination links
        $sessions->appends($request->query());

        // Calculate stats (apply same filters to stats)
        $statsQuery = Session::query();
        
        // Apply same filters to stats
        if ($request->filled('session_category')) {
            $statsQuery->where('session_category', $request->session_category);
        }

        if ($request->filled('session_status')) {
            $statsQuery->where('session_status', $request->session_status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $statsQuery->where(function ($q) use ($searchTerm) {
                // Search in user name, email, phone
                $q->whereHas('user', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('email', 'like', '%' . $searchTerm . '%')
                              ->orWhere('phone', 'like', '%' . $searchTerm . '%');
                })
                // Search in session owner name
                ->orWhere('session_owner', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('payment_status')) {
            if ($request->payment_status === 'no_payment') {
                $statsQuery->whereDoesntHave('payment');
            } else {
                $statsQuery->whereHas('payment', function ($q) use ($request) {
                    $q->where('payment_status', $request->payment_status);
                });
            }
        }

        // Apply refund status filter to stats query
        if ($request->filled('refund_status')) {
            if ($request->refund_status === 'needs_refund') {
                // الجلسات التي تحتاج إرجاع (المبلغ المدفوع أكبر من التكلفة)
                $statsQuery->whereHas('payment', function ($q) {
                    $q->whereRaw('(amount_bank + amount_cash) > total_price');
                });
            } elseif ($request->refund_status === 'has_remaining') {
                // الجلسات التي لها مبلغ متبقي للدفع (المبلغ المدفوع أقل من التكلفة)
                $statsQuery->whereHas('payment', function ($q) {
                    $q->whereRaw('(amount_bank + amount_cash) < total_price');
                });
            } elseif ($request->refund_status === 'fully_paid') {
                // الجلسات المدفوعة بالكامل (المبلغ المدفوع يساوي التكلفة)
                $statsQuery->whereHas('payment', function ($q) {
                    $q->whereRaw('(amount_bank + amount_cash) = total_price');
                });
            }
        }

        if ($request->filled('start_date_from')) {
            $statsQuery->whereDate('start_at', '>=', $request->start_date_from);
        }

        if ($request->filled('start_date_to')) {
            $statsQuery->whereDate('start_at', '<=', $request->start_date_to);
        }

        $stats = [
            'total_sessions' => $statsQuery->count(),
            'active_sessions' => (clone $statsQuery)->where('session_status', 'active')->count(),
            'completed_sessions' => (clone $statsQuery)->where('session_status', 'completed')->count(),
            'cancelled_sessions' => (clone $statsQuery)->where('session_status', 'cancelled')->count(),
            'subscription_sessions' => (clone $statsQuery)->where('session_category', 'subscription')->count(),
            'active_subscription_sessions' => (clone $statsQuery)->where('session_category', 'subscription')->where('session_status', 'active')->count(),
            'overdue_subscription_sessions' => (clone $statsQuery)->where('session_category', 'subscription')->where('session_status', 'active')->get()->filter(function($session) {
                return $session->isOverdue();
            })->count(),
        ];

        // Add refund-related statistics
        $refundStats = [
            'sessions_needing_refund' => Session::whereHas('payment', function ($q) {
                $q->whereRaw('(amount_bank + amount_cash) > total_price');
            })->count(),
            'sessions_with_remaining' => Session::whereHas('payment', function ($q) {
                $q->whereRaw('(amount_bank + amount_cash) < total_price');
            })->count(),
            'fully_paid_sessions' => Session::whereHas('payment', function ($q) {
                $q->whereRaw('(amount_bank + amount_cash) = total_price');
            })->count(),
        ];

        $stats = array_merge($stats, $refundStats);

        // Available categories for filter dropdown
        $categories = [
            'hourly' => 'ساعي',
            'subscription' => 'شهري (اشتراك)',
            'overtime' => 'إضافي'
        ];

        return view('sessions.index', compact('sessions', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // جلب جميع المستخدمين المؤهلين لبدء جلسة جديدة
        // يجب أن لا يكون لديهم جلسة نشطة حالياً
        $users = User::where('status', 'active')
            ->whereIn('user_type', ['hourly', 'subscription'])
            ->whereDoesntHave('sessions', function($query) {
                $query->where('session_status', 'active');
            })
            ->orderBy('id', 'asc')
            ->get();
        
        return view('sessions.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_category' => 'required|in:hourly,subscription,overtime',
            'note' => 'nullable|string',
            'session_owner' => 'nullable|string|max:255'
        ]);

        $session = Session::create([
            'start_at' => Carbon::now(),
            'user_id' => $request->user_id,
            'session_category' => $request->session_category,
            'session_status' => 'active',
            'note' => $request->note,
            'session_owner' => $request->session_owner
        ]);

        // إنشاء سجل دفع فارغ
        SessionPayment::create([
            'session_id' => $session->id,
            'total_price' => 0,
            'payment_status' => 'pending'
        ]);

        return redirect()->route('sessions.create')
            ->with('success', 'تم بدء الجلسة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        $session->load(['user', 'payment', 'drinks.drink']);
        $drinks = Drink::where('status', 'available')->get();
        
        return view('sessions.show', compact('session', 'drinks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $session)
    {
        $users = User::where('status', 'active')
            ->orderBy('id', 'asc')
            ->get();
        
        return view('sessions.edit', compact('session', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_category' => 'required|in:hourly,subscription,overtime',
            'note' => 'nullable|string',
            'session_owner' => 'nullable|string|max:255',
            'custom_internet_cost' => 'nullable|numeric|min:0'
        ]);

        // حفظ القيمة القديمة للتكلفة المخصصة
        $oldCustomCost = $session->custom_internet_cost;

        $session->update([
            'user_id' => $request->user_id,
            'session_category' => $request->session_category,
            'note' => $request->note,
            'session_owner' => $request->session_owner,
            'custom_internet_cost' => $request->custom_internet_cost
        ]);

        // إعادة تحميل الجلسة
        $session->refresh();

        // إذا تم تغيير التكلفة المخصصة، تحديث المدفوعة
        if ($oldCustomCost != $request->custom_internet_cost) {
            \Log::info('Custom internet cost changed in session update', [
                'session_id' => $session->id,
                'old_cost' => $oldCustomCost,
                'new_cost' => $request->custom_internet_cost
            ]);
            
            $this->updateSessionTotal($session);
        }

        return redirect()->route('sessions.show', $session)
            ->with('success', 'تم تحديث الجلسة بنجاح');
    }

    /**
     * Cancel session (mark as cancelled)
     */
    public function cancel(Session $session)
    {
        $session->update(['session_status' => 'cancelled']);
        
        return redirect()->route('sessions.index')
            ->with('success', 'تم إلغاء الجلسة بنجاح');
    }

    /**
     * End session and calculate payment
     */
    public function endSession(Request $request, Session $session)
    {
        if ($session->session_status !== 'active') {
            return redirect()->back()->with('error', 'الجلسة غير نشطة');
        }

        $session->update([
            'end_at' => Carbon::now(),
            'session_status' => 'completed'
        ]);

        // حساب التكلفة
        $this->calculateSessionCost($session);

        return redirect()->route('sessions.show', $session)
            ->with('success', 'تم إنهاء الجلسة وحساب التكلفة');
    }

    /**
     * Add drink to session
     */
    public function addDrink(Request $request, Session $session)
    {
        // التحقق من أن الجلسة نشطة أو مكتملة
        if ($session->session_status !== 'active' && $session->session_status !== 'completed') {
            return redirect()->back()->with('error', 'لا يمكن إضافة مشروبات للجلسات الملغية');
        }

        $request->validate([
            'drink_id' => 'required|exists:drinks,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $drink = Drink::findOrFail($request->drink_id);
        $quantity = $request->quantity ?? 1;
        $totalPrice = $drink->price * $quantity;

        $sessionDrink = SessionDrink::create([
            'session_id' => $session->id,
            'drink_id' => $request->drink_id,
            'price' => $totalPrice,
            'quantity' => $quantity,
            'status' => 'ordered',
            'note' => $request->note
        ]);

        // تسجيل audit log
        $sessionDrink->logCustomAudit(
            'add_drink',
            "تم إضافة مشروب {$drink->name} (الكمية: {$quantity}, السعر: \${$totalPrice})"
        );

        // حفظ حالة الدفع قبل التحديث
        $oldPaymentStatus = $session->payment ? $session->payment->payment_status : null;
        
        // تحديث إجمالي المبلغ
        $this->updateSessionTotal($session);
        
        // التحقق من تغيير حالة الدفع
        $session->refresh();
        $newPaymentStatus = $session->payment ? $session->payment->payment_status : null;
        
        $message = 'تم إضافة المشروب بنجاح';
        if ($oldPaymentStatus && $newPaymentStatus && $oldPaymentStatus !== $newPaymentStatus) {
            $statusText = '';
            switch ($newPaymentStatus) {
                case 'paid':
                    $statusText = 'مدفوع بالكامل';
                    break;
                case 'partial':
                    $statusText = 'مدفوع جزئياً';
                    break;
                case 'pending':
                    $statusText = 'قيد الانتظار';
                    break;
            }
            $message .= ' - تم تحديث حالة الدفع إلى: ' . $statusText;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove drink from session
     */
    public function removeDrink(Session $session, SessionDrink $sessionDrink)
    {
        // التحقق من أن الجلسة نشطة أو مكتملة
        if ($session->session_status !== 'active' && $session->session_status !== 'completed') {
            return redirect()->back()->with('error', 'لا يمكن حذف المشروبات من الجلسات الملغية');
        }

        // التحقق من أن المشروب ينتمي للجلسة
        if ($sessionDrink->session_id !== $session->id) {
            return redirect()->back()->with('error', 'المشروب لا ينتمي لهذه الجلسة');
        }

        // حفظ حالة الدفع قبل التحديث
        $oldPaymentStatus = $session->payment ? $session->payment->payment_status : null;
        
        // تسجيل audit log قبل الحذف
        $drinkName = $sessionDrink->drink->name ?? 'غير محدد';
        $sessionDrink->logCustomAudit(
            'remove_drink',
            "تم حذف مشروب {$drinkName} (الكمية: {$sessionDrink->quantity}, السعر: \${$sessionDrink->price})"
        );

        // حذف المشروب
        $sessionDrink->delete();

        // تحديث إجمالي المبلغ
        $this->updateSessionTotal($session);
        
        // التحقق من تغيير حالة الدفع
        $session->refresh();
        $newPaymentStatus = $session->payment ? $session->payment->payment_status : null;
        
        $message = 'تم حذف المشروب بنجاح';
        if ($oldPaymentStatus && $newPaymentStatus && $oldPaymentStatus !== $newPaymentStatus) {
            $statusText = '';
            switch ($newPaymentStatus) {
                case 'paid':
                    $statusText = 'مدفوع بالكامل';
                    break;
                case 'partial':
                    $statusText = 'مدفوع جزئياً';
                    break;
                case 'pending':
                    $statusText = 'قيد الانتظار';
                    break;
            }
            $message .= ' - تم تحديث حالة الدفع إلى: ' . $statusText;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update drink date and time
     */
    public function updateDrinkDate(Request $request, Session $session, SessionDrink $sessionDrink)
    {
        // التحقق من أن الجلسة نشطة أو مكتملة
        if ($session->session_status !== 'active' && $session->session_status !== 'completed') {
            return redirect()->back()->with('error', 'لا يمكن تعديل تاريخ المشروبات في الجلسات الملغية');
        }

        // التحقق من أن المشروب ينتمي للجلسة
        if ($sessionDrink->session_id !== $session->id) {
            return redirect()->back()->with('error', 'المشروب لا ينتمي لهذه الجلسة');
        }

        $request->validate([
            'created_at' => 'required|date'
        ]);

        $oldDate = $sessionDrink->created_at->format('Y-m-d H:i:s');
        $newDate = Carbon::parse($request->created_at);

        // تحديث التاريخ والوقت مباشرة في قاعدة البيانات
        // لأن Laravel لا يسمح بتحديث created_at عبر update()
        DB::table('session_drinks')
            ->where('id', $sessionDrink->id)
            ->update([
                'created_at' => $newDate,
                'updated_at' => now()
            ]);
        
        // إعادة تحميل النموذج للحصول على القيم المحدثة
        $sessionDrink->refresh();

        // تسجيل audit log
        $drinkName = $sessionDrink->drink->name ?? 'غير محدد';
        $sessionDrink->logCustomAudit(
            'update_drink_date',
            "تم تحديث تاريخ ووقت مشروب {$drinkName} من {$oldDate} إلى {$newDate->format('Y-m-d H:i:s')}"
        );

        return redirect()->back()->with('success', 'تم تحديث تاريخ ووقت المشروب بنجاح');
    }

    /**
     * Calculate session cost based on time and category
     */
    private function calculateSessionCost(Session $session)
    {
        // حساب التكلفة بناءً على الوقت الفعلي
        $sessionCost = $this->calculateInternetCostByTime($session);

        // تحديث المبلغ الإجمالي مع المشروبات
        $this->updateSessionTotal($session, $sessionCost);
    }

    /**
     * Update session total cost
     */
    private function updateSessionTotal(Session $session, $sessionCost = null)
    {
        // التأكد من وجود مدفوعة للجلسة
        $payment = $session->ensurePaymentExists();
        
        $drinksCost = $session->drinks()->sum('price');
        
        if ($sessionCost === null) {
            // حساب التكلفة تلقائياً بناءً على الوقت الفعلي (مع مراعاة التكلفة المخصصة)
            $sessionCost = $this->calculateInternetCostByTime($session);
        }
        
        $totalCost = $sessionCost + $drinksCost;
        $totalPaid = $payment->amount_bank + $payment->amount_cash;
        $remainingAmount = $totalCost - $totalPaid;
        
        // تحديث حالة الدفع بناءً على المبالغ المدفوعة
        $paymentStatus = 'pending';
        if ($totalPaid >= $totalCost) {
            $paymentStatus = 'paid';
            $remainingAmount = 0;
        } elseif ($totalPaid > 0) {
            $paymentStatus = 'partial';
        }
        
        $payment->update([
            'total_price' => $totalCost,
            'payment_status' => $paymentStatus,
            'remaining_amount' => $remainingAmount
        ]);
        
        // تسجيل معلومات التحديث للتشخيص
        \Log::info('Updated session payment', [
            'session_id' => $session->id,
            'payment_id' => $payment->id,
            'session_cost' => $sessionCost,
            'drinks_cost' => $drinksCost,
            'total_cost' => $totalCost,
            'total_paid' => $totalPaid,
            'remaining_amount' => $remainingAmount,
            'payment_status' => $paymentStatus,
            'custom_internet_cost' => $session->custom_internet_cost
        ]);
        
        // إعادة تحميل الجلسة والعلاقات للتأكد من التحديث
        $session->refresh();
        $session->load('payment');
    }

    /**
     * Remove the specified session from storage (Soft Delete).
     */
    public function destroy(Session $session)
    {
        // التحقق من أن الجلسة ليست نشطة
        if ($session->session_status === 'active') {
            return redirect()->back()->with('error', "لا يمكن حذف الجلسة النشطة رقم #{$session->id}. يجب إنهاؤها أولاً قبل الحذف.");
        }
        
        $session->delete(); // Soft delete because of SoftDeletes trait
        return redirect()->route('sessions.index')
            ->with('success', 'تم حذف الجلسة بنجاح (يمكن استرجاعها لاحقاً)');
    }

    /**
     * Display deleted sessions.
     */
    public function trashed()
    {
        $trashedSessions = Session::onlyTrashed()
            ->with(['user', 'payment'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);
        
        $stats = [
            'total_deleted' => Session::onlyTrashed()->count(),
            'active_sessions' => Session::count(),
            'total_sessions' => Session::withTrashed()->count(),
        ];

        return view('sessions.trashed', compact('trashedSessions', 'stats'));
    }

    /**
     * Restore deleted session.
     */
    public function restore($id)
    {
        $session = Session::onlyTrashed()->findOrFail($id);
        $session->restore();
        
        return redirect()->route('sessions.trashed')
            ->with('success', 'تم استرجاع الجلسة بنجاح');
    }

    /**
     * Force delete session permanently.
     */
    public function forceDelete($id)
    {
        $session = Session::onlyTrashed()->findOrFail($id);
        
        // حذف المدفوعات والمشروبات المرتبطة
        if ($session->payment) {
            $session->payment->delete();
        }
        $session->drinks()->delete();
        
        // حذف الجلسة نهائياً
        $session->forceDelete();
        
        return redirect()->route('sessions.trashed')
            ->with('success', 'تم حذف الجلسة نهائياً');
    }

    /**
     * Bulk delete sessions (Soft Delete).
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'session_ids' => 'required|array|min:1',
            'session_ids.*' => 'exists:user_sessions,id'
        ]);

        $sessionIds = $request->session_ids;
        $sessions = Session::whereIn('id', $sessionIds)->get();
        
        if ($sessions->isEmpty()) {
            return redirect()->back()->with('error', 'لم يتم العثور على جلسات للحذف');
        }

        // التحقق من أن جميع الجلسات مكتملة أو ملغاة
        $activeSessions = $sessions->where('session_status', 'active');
        
        if ($activeSessions->count() > 0) {
            $activeSessionIds = $activeSessions->pluck('id')->toArray();
            $activeSessionIdsStr = implode(', ', $activeSessionIds);
            
            return redirect()->back()->with('error', "لا يمكن حذف الجلسات النشطة. يجب إنهاء الجلسات التالية أولاً: {$activeSessionIdsStr}");
        }

        Session::whereIn('id', $sessionIds)->delete();
        
        $count = count($sessionIds);
        
        // Return to the same page with filters if return_to is provided
        $returnUrl = $request->input('return_to', route('sessions.index'));
        
        return redirect($returnUrl)
            ->with('success', "تم حذف {$count} جلسة بنجاح (يمكن استرجاعها لاحقاً)");
    }

    /**
     * Bulk restore deleted sessions.
     */
    public function bulkRestore(Request $request)
    {
        $request->validate([
            'session_ids' => 'required|array|min:1',
            'session_ids.*' => 'integer'
        ]);

        $sessionIds = $request->session_ids;
        $sessions = Session::onlyTrashed()->whereIn('id', $sessionIds)->get();
        
        if ($sessions->isEmpty()) {
            return redirect()->back()->with('error', 'لم يتم العثور على جلسات محذوفة للاسترجاع');
        }

        Session::onlyTrashed()->whereIn('id', $sessionIds)->restore();
        
        $count = count($sessionIds);
        return redirect()->route('sessions.trashed')
            ->with('success', "تم استرجاع {$count} جلسة بنجاح");
    }

    /**
     * Bulk force delete sessions permanently.
     */
    public function bulkForceDelete(Request $request)
    {
        $request->validate([
            'session_ids' => 'required|array|min:1',
            'session_ids.*' => 'integer'
        ]);

        $sessionIds = $request->session_ids;
        $sessions = Session::onlyTrashed()->whereIn('id', $sessionIds)->get();
        
        if ($sessions->isEmpty()) {
            return redirect()->back()->with('error', 'لم يتم العثور على جلسات محذوفة');
        }

        // حذف البيانات المرتبطة أولاً
        foreach ($sessions as $session) {
            if ($session->payment) {
                $session->payment->delete();
            }
            $session->drinks()->delete();
        }

        Session::onlyTrashed()->whereIn('id', $sessionIds)->forceDelete();
        
        $count = count($sessionIds);
        return redirect()->route('sessions.trashed')
            ->with('success', "تم حذف {$count} جلسة نهائياً");
    }



    /**
     * Calculate internet cost based on actual time
     */
    private function calculateInternetCostByTime(Session $session)
    {
        // إذا كانت هناك تكلفة مخصصة، استخدمها
        if ($session->custom_internet_cost !== null) {
            \Log::info('Using custom internet cost', [
                'session_id' => $session->id,
                'custom_cost' => $session->custom_internet_cost
            ]);
            return $session->custom_internet_cost;
        }
        
        $publicPrices = PublicPrice::first();
        $startTime = $session->start_at;
        
        // تحديد وقت الانتهاء: إما وقت الانتهاء الفعلي أو الوقت الحالي
        $endTime = $session->end_at ?? now();
        
        // حساب المدة بالدقائق ثم تحويلها إلى ساعات
        $durationInMinutes = $startTime->diffInMinutes($endTime);
        $durationInHours = $durationInMinutes / 60;
        
        $sessionCost = 0;
        
        switch ($session->session_category) {
            case 'hourly':
                $sessionCost = $durationInHours * ($publicPrices->hourly_rate ?? 5.00);
                break;
            case 'overtime':
                $hour = $startTime->hour;
                $isNight = $hour >= 18 || $hour <= 6;
                $rate = $isNight ? ($publicPrices->price_overtime_night ?? 7.00) : ($publicPrices->price_overtime_morning ?? 5.00);
                $sessionCost = $durationInHours * $rate;
                break;
            case 'prepaid':
            case 'subscription':
                $sessionCost = 0; // مدفوع مسبقاً أو اشتراك (بدون تكلفة مخصصة)
                break;
            default:
                $sessionCost = 0;
        }
        
        \Log::info('Calculated internet cost by time', [
            'session_id' => $session->id,
            'session_category' => $session->session_category,
            'duration_hours' => $durationInHours,
            'calculated_cost' => $sessionCost
        ]);
        
        return $sessionCost;
    }

    /**
     * Update internet cost for session
     */
    public function updateInternetCost(Request $request, Session $session)
    {
        $request->validate([
            'custom_internet_cost' => 'nullable|numeric|min:0',
        ]);

        // حفظ القيم القديمة
        $oldCustomCost = $session->custom_internet_cost;
        
        // تحديث تكلفة الإنترنت المخصصة
        $customCost = $request->custom_internet_cost;
        if ($customCost === '' || $customCost === null) {
            $session->update(['custom_internet_cost' => null]);
            $message = 'تم إزالة التكلفة المخصصة والعودة للحساب التلقائي';
        } else {
            $session->update(['custom_internet_cost' => $customCost]);
            $message = 'تم تحديث تكلفة الإنترنت المخصصة إلى: $' . number_format($customCost, 2);
        }

        // إعادة تحميل الجلسة والعلاقات للتأكد من التحديث
        $session->refresh();
        $session->load('payment');

        // تسجيل معلومات التحديث للتشخيص
        \Log::info('Updating internet cost for session', [
            'session_id' => $session->id,
            'session_category' => $session->session_category,
            'custom_cost' => $customCost,
            'has_payment' => $session->payment ? 'yes' : 'no'
        ]);

        // تسجيل audit log
        $session->logCustomAudit(
            'update_internet_cost',
            $message,
            ['custom_internet_cost' => $oldCustomCost],
            ['custom_internet_cost' => $customCost]
        );

        // تحديث إجمالي المبلغ في المدفوعة
        $this->updateSessionTotal($session);
        
        // تسجيل النتيجة النهائية
        \Log::info('Internet cost update completed', [
            'session_id' => $session->id,
            'final_total_price' => $session->payment->total_price,
            'final_remaining_amount' => $session->payment->remaining_amount,
            'final_payment_status' => $session->payment->payment_status
        ]);

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update session start time and recalculate internet cost
     */
    public function updateStartTime(Request $request, Session $session)
    {
        $request->validate([
            'start_time' => 'required|date_format:Y-m-d\TH:i',
        ]);

        try {
            \Log::info('Updating session start time', [
                'session_id' => $session->id,
                'old_start_time' => $session->start_at,
                'new_start_time' => $request->start_time
            ]);

            $newStartTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time);
            $oldStartTime = $session->start_at;

            // تحديث تاريخ بداية الجلسة وإعادة حساب التكلفة
            $session->updateStartTime($newStartTime);

            // تحديث إجمالي المبلغ في المدفوعة
            $this->updateSessionTotal($session);

            // إعادة تحميل الجلسة والعلاقات للتأكد من التحديث
            $session->refresh();
            $session->load('payment');

            $message = 'تم تحديث تاريخ بداية الجلسة بنجاح';
            
            // إذا تم إعادة حساب التكلفة، أضف رسالة إضافية
            if (!$session->hasCustomInternetCost()) {
                $newInternetCost = $session->calculateInternetCost();
                $message .= ' وتم إعادة حساب تكلفة الإنترنت إلى: $' . number_format($newInternetCost, 2);
            }

            \Log::info('Session start time updated successfully', [
                'session_id' => $session->id,
                'new_start_time' => $session->start_at
            ]);

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Error updating session start time', [
                'session_id' => $session->id,
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث تاريخ بداية الجلسة: ' . $e->getMessage());
        }
    }

    /**
     * Update expected end date for subscription sessions
     */
    public function updateExpectedEndDate(Request $request, Session $session)
    {
        $request->validate([
            'expected_end_date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        try {
            // التحقق من أن الجلسة من نوع اشتراك
            if (!$session->isSubscription()) {
                return redirect()->back()->with('error', 'يمكن تحديث تاريخ انتهاء الجلسة للجلسات الاشتراكية فقط');
            }

            // التحقق من أن الجلسة نشطة
            if ($session->session_status !== 'active') {
                return redirect()->back()->with('error', 'يمكن تحديث تاريخ انتهاء الجلسة للجلسات النشطة فقط');
            }

            $newExpectedEndDate = Carbon::createFromFormat('Y-m-d\TH:i', $request->expected_end_date);
            
            // تحديث التاريخ المتوقع للانتهاء
            $session->updateExpectedEndDate($newExpectedEndDate);

            $message = 'تم تحديث التاريخ المتوقع لانتهاء الجلسة بنجاح إلى: ' . $newExpectedEndDate->format('Y-m-d H:i');

            return redirect()->back()->with('success', $message);

        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Error updating expected end date', [
                'session_id' => $session->id,
                'request_data' => $request->all(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث التاريخ المتوقع لانتهاء الجلسة');
        }
    }

    /**
     * End subscription session manually
     */
    public function endSubscriptionSession(Request $request, Session $session)
    {
        $request->validate([
            'end_time' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        try {
            // التحقق من أن الجلسة من نوع اشتراك
            if (!$session->isSubscription()) {
                return redirect()->back()->with('error', 'يمكن إنهاء الجلسات الاشتراكية فقط');
            }

            // التحقق من أن الجلسة نشطة
            if ($session->session_status !== 'active') {
                return redirect()->back()->with('error', 'يمكن إنهاء الجلسات النشطة فقط');
            }

            $endTime = null;
            if ($request->filled('end_time')) {
                $endTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_time);
            }

            // إنهاء الجلسة يدوياً
            $session->endSessionManually($endTime);

            $message = 'تم إنهاء الجلسة بنجاح';
            if ($endTime) {
                $message .= ' في: ' . $endTime->format('Y-m-d H:i');
            }

            return redirect()->back()->with('success', $message);

        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Error ending subscription session', [
                'session_id' => $session->id,
                'request_data' => $request->all(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'حدث خطأ أثناء إنهاء الجلسة');
        }
    }

    /**
     * Cancel a completed session
     */
    public function cancelSession(Request $request, Session $session)
    {
        try {
            // التحقق من أن الجلسة مكتملة
            if ($session->session_status !== 'completed') {
                return redirect()->back()->with('error', 'يمكن إلغاء الجلسات المكتملة فقط');
            }

            // التحقق من أن الجلسة لديها مدفوعة
            if (!$session->payment) {
                return redirect()->back()->with('error', 'لا يمكن إلغاء جلسة بدون مدفوعة');
            }

            // تحديث حالة الجلسة إلى ملغية
            $session->update([
                'session_status' => 'cancelled'
            ]);

            // تحديث حالة الدفع إلى ملغية
            $session->payment->update([
                'payment_status' => 'cancelled'
            ]);

            // تسجيل العملية في سجل التدقيق
            $session->auditLogs()->create([
                'action' => 'session_cancelled',
                'action_type' => 'session',
                'description' => 'تم إلغاء الجلسة بواسطة المدير',
                'user_id' => auth()->id(),
                'old_values' => json_encode([
                    'session_status' => 'completed',
                    'payment_status' => $session->payment->payment_status
                ]),
                'new_values' => json_encode([
                    'session_status' => 'cancelled',
                    'payment_status' => 'cancelled'
                ])
            ]);

            return redirect()->back()->with('success', 'تم إلغاء الجلسة بنجاح');

        } catch (\Exception $e) {
            \Log::error('Error cancelling session', [
                'session_id' => $session->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'حدث خطأ أثناء إلغاء الجلسة');
        }
    }



}
