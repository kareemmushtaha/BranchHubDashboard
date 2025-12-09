<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Session;
use App\Models\SessionPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_sessions' => Session::where('session_status', 'active')->count(),
            'today_revenue' => SessionPayment::whereDate('created_at', Carbon::today())->sum('total_price'),
            'pending_payments' => SessionPayment::where('payment_status', 'pending')->sum('remaining_amount'),
            'subscription_sessions' => Session::where('session_category', 'subscription')->where('session_status', 'active')->count(),
            'overdue_subscriptions' => Session::where('session_category', 'subscription')->where('session_status', 'active')->get()->filter(function($session) {
                return $session->isOverdue();
            })->count(),
            // Session statistics
            'total_sessions' => Session::count(),
            'completed_sessions' => Session::where('session_status', 'completed')->count(),
            'cancelled_sessions' => Session::where('session_status', 'cancelled')->count(),
            'active_subscription_sessions' => Session::where('session_category', 'subscription')->where('session_status', 'active')->count(),
            'overdue_subscription_sessions' => Session::where('session_category', 'subscription')->where('session_status', 'active')->get()->filter(function($session) {
                return $session->isOverdue();
            })->count(),
            // Refund-related statistics
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

        $recent_sessions = Session::with(['user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'recent_sessions'));
    }
}
