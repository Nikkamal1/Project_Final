<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsStaff
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // ตรวจสอบว่าเป็น Staff
        if ($user && $user->is_admin == 2 && $user->is_staff == 2) {
            return $next($request);
        }

        return redirect('home')->with('error', "คุณไม่มีสิทธิ์เข้าถึงส่วนนี้");
    }
}
