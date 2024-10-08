<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // ตรวจสอบเส้นทางที่เป็นหน้าเข้าสู่ระบบ
            if ($request->is('login') || $request->is('register')) {
                return redirect('/home'); // เปลี่ยนเส้นทางที่ต้องการ
            }
        }

        return $next($request);
    }
}
