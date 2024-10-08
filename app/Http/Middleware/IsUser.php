<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // ตรวจสอบว่าเป็น User
        if ($user && $user->is_admin == 0) {
            return $next($request);
        }

        return redirect('home')->with('error', "คุณไม่มีสิทธิ์เข้าถึงส่วนนี้");
    }
}
