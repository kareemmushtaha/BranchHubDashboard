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
        ];

        $recent_sessions = Session::with(['user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'recent_sessions'));
    }
}
