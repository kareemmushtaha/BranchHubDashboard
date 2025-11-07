<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionPayment;
use App\Models\User;
use App\Models\Drink;
use App\Models\SessionDrink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // الإحصائيات العامة
        $totalRevenue = SessionPayment::where('payment_status', 'paid')->sum('total_price');
        $totalSessions = Session::count();
        $totalUsers = User::count();
        $activeSessions = Session::where('session_status', 'active')->count();
        
        // إحصائيات هذا الشهر
        $monthlyRevenue = SessionPayment::where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');
            
        $monthlySessions = Session::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // أفضل المستخدمين (بناءً على عدد الجلسات)
        $topUsers = User::withCount('sessions')
            ->orderBy('sessions_count', 'desc')
            ->limit(5)
            ->get();

        // أفضل المشروبات (بناءً على المبيعات)
        $topDrinks = Drink::withCount('sessionDrinks')
            ->orderBy('session_drinks_count', 'desc')
            ->limit(5)
            ->get();

        return view('reports.index', compact(
            'totalRevenue', 'totalSessions', 'totalUsers', 'activeSessions',
            'monthlyRevenue', 'monthlySessions', 'topUsers', 'topDrinks'
        ));
    }

    public function revenue(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        // إجمالي الإيرادات في الفترة المحددة
        $totalRevenue = SessionPayment::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');
            
        $totalCash = SessionPayment::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount_cash');
            
        $totalBank = SessionPayment::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount_bank');

        // الإيرادات اليومية
        $dailyRevenue = SessionPayment::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as sessions_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // الإيرادات حسب فئة الجلسة
        $revenueByCategory = Session::with('payment')
            ->whereBetween('user_sessions.created_at', [$startDate, $endDate])
            ->whereHas('payment', function($query) {
                $query->where('payment_status', 'paid');
            })
            ->select('session_category', DB::raw('SUM(session_payments.total_price) as revenue'))
            ->join('session_payments', 'user_sessions.id', '=', 'session_payments.session_id')
            ->where('session_payments.payment_status', 'paid')
            ->groupBy('session_category')
            ->get();

        return view('reports.revenue', compact(
            'totalRevenue', 'totalCash', 'totalBank', 'dailyRevenue',
            'revenueByCategory', 'startDate', 'endDate'
        ));
    }

    public function users(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // إحصائيات المستخدمين
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        // المستخدمون الأكثر نشاطاً
        $mostActiveUsers = User::withCount(['sessions' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('sessions_count', 'desc')
            ->limit(10)
            ->get();

        // إحصائيات حسب نوع المستخدم
        $usersByType = User::select('user_type', DB::raw('COUNT(*) as count'))
            ->groupBy('user_type')
            ->get();

        // المستخدمون حسب حالة النشاط
        $usersByStatus = User::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // نشاط المستخدمين اليومي (عدد الجلسات)
        $dailyActivity = Session::whereBetween('user_sessions.created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(user_sessions.created_at) as date'),
                DB::raw('COUNT(DISTINCT user_sessions.user_id) as unique_users'),
                DB::raw('COUNT(*) as total_sessions')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('reports.users', compact(
            'totalUsers', 'activeUsers', 'newUsers', 'mostActiveUsers',
            'usersByType', 'usersByStatus', 'dailyActivity',
            'startDate', 'endDate'
        ));
    }

    public function drinks(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // إحصائيات المشروبات
        $totalDrinks = Drink::count();
        $availableDrinks = Drink::where('status', 'available')->count();
        $totalSold = SessionDrink::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalDrinksRevenue = SessionDrink::whereBetween('created_at', [$startDate, $endDate])->sum('price');

        // أفضل المشروبات مبيعاً
        $topSellingDrinks = Drink::withCount(['sessionDrinks' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->with(['sessionDrinks' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('session_drinks_count', 'desc')
            ->limit(10)
            ->get();

        // مبيعات المشروبات اليومية
        $dailySales = SessionDrink::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as quantity'),
                DB::raw('SUM(price) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('reports.drinks', compact(
            'totalDrinks', 'availableDrinks', 'totalSold', 'totalDrinksRevenue',
            'topSellingDrinks', 'dailySales', 'startDate', 'endDate'
        ));
    }
}
