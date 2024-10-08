<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // ตรวจสอบว่าเป็น Admin
        if ($user && $user->is_admin == 1 && $user->is_staff == 0 && $request->is('admin/*'))  {
            return $next($request);
        }

        // ตรวจสอบว่าเป็น Staff และให้เข้าถึงเส้นทางที่ขึ้นต้นด้วย 'staff'
        if ($user && $user->is_staff == 2 && $user->is_admin == 2 && $request->is('staff/*')) {
            return $next($request);
        }

        // ตรวจสอบว่าเป็น User และให้เข้าถึงเส้นทางที่ขึ้นต้นด้วย 'user'
        if ($user && $user->is_admin == 0 && $request->is('user/*')) {
            return $next($request);
        }

        return redirect('home')->with('error', "คุณไม่มีสิทธิ์เข้าถึงส่วนนี้");
    }
}

