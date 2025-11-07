<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionAuditLog;
use Illuminate\Http\Request;

class SessionAuditController extends Controller
{
    /**
     * عرض سجلات التدقيق لجلسة معينة
     */
    public function show(Session $session)
    {
        $auditLogs = $session->auditLogs()
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('sessions.audit', compact('session', 'auditLogs'));
    }

    /**
     * عرض جميع سجلات التدقيق مع فلترة
     */
    public function index(Request $request)
    {
        $query = SessionAuditLog::with(['session', 'user']);

        // فلترة حسب الجلسة
        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        // فلترة حسب المستخدم
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // فلترة حسب نوع العملية
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // فلترة حسب نوع العنصر
        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // البحث في الوصف
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->paginate(50);

        // إحصائيات
        $stats = [
            'total_logs' => SessionAuditLog::count(),
            'today_logs' => SessionAuditLog::whereDate('created_at', today())->count(),
            'this_week_logs' => SessionAuditLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_logs' => SessionAuditLog::whereMonth('created_at', now()->month)->count(),
        ];

        // قوائم للفلترة
        $actions = SessionAuditLog::distinct()->pluck('action')->sort();
        $actionTypes = SessionAuditLog::distinct()->pluck('action_type')->sort();
        $users = \App\Models\User::whereIn('id', SessionAuditLog::distinct()->pluck('user_id'))
            ->orderBy('id', 'asc')
            ->get();
        $sessions = Session::whereIn('id', SessionAuditLog::distinct()->pluck('session_id'))->get();

        return view('audit.index', compact('auditLogs', 'stats', 'actions', 'actionTypes', 'users', 'sessions'));
    }

    /**
     * تصدير سجلات التدقيق
     */
    public function export(Request $request)
    {
        $query = SessionAuditLog::with(['session', 'user']);

        // تطبيق نفس الفلاتر
        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->get();

        // إنشاء ملف CSV
        $filename = 'audit_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($auditLogs) {
            $file = fopen('php://output', 'w');
            
            // رأس الجدول
            fputcsv($file, [
                'ID',
                'الجلسة',
                'المستخدم',
                'العملية',
                'نوع العنصر',
                'الوصف',
                'القيم القديمة',
                'القيم الجديدة',
                'عنوان IP',
                'التاريخ والوقت'
            ]);

            // البيانات
            foreach ($auditLogs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->session->id ?? 'غير محدد',
                    $log->user->name ?? 'غير محدد',
                    $log->getActionDisplayName(),
                    $log->getActionTypeDisplayName(),
                    $log->description,
                    $log->old_values ? json_encode($log->old_values, JSON_UNESCAPED_UNICODE) : '',
                    $log->new_values ? json_encode($log->new_values, JSON_UNESCAPED_UNICODE) : '',
                    $log->ip_address ?? '',
                    $log->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
