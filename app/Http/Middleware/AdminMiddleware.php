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
        
        // التحقق من أن المستخدم إداري أو مدير
        if ($user->user_type !== 'admin' && $user->user_type !== 'manager') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'ليس لديك صلاحية للوصول إلى لوحة التحكم.');
        }

        return $next($request);
    }
} 