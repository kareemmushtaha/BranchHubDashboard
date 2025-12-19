<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول للوصول إلى هذه الصفحة.');
        }

        $user = Auth::user();
        
        // التحقق من أن المستخدم لديه دور أو صلاحيات (دعم النظام القديم والجديد)
        $hasAdminRole = $user->hasRole('admin') || $user->hasRole('manager');
        $hasAdminType = $user->user_type === 'admin' || $user->user_type === 'manager';
        $hasAnyRole = $user->roles->count() > 0;
        
        // السماح بالوصول إذا:
        // 1. لديه دور admin أو manager (للتوافق مع النظام القديم)
        // 2. أو user_type هو admin أو manager (للتوافق مع النظام القديم)
        // 3. أو لديه أي دور معين (للنظام الجديد)
        if (!$hasAdminRole && !$hasAdminType && !$hasAnyRole) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'ليس لديك صلاحية للوصول إلى لوحة التحكم.');
        }

        return $next($request);
    }
} 