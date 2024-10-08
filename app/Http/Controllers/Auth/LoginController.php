<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $user = auth()->user();
            
            // ตรวจสอบค่าของ is_admin
            if ($user->is_admin == 1 && $user->is_staff == 0) {  // Admin
                return redirect()->route('admin.home');
            } elseif ($user->is_admin == 2 && $user->is_staff == 2) {  // Staff
                return redirect()->route('staff.home');
            } else {  // User
                return redirect()->route('user.home');
            }
        } else {
            return redirect()->route('login')->with('error', 'Email address and password are wrong.');
        }
    }
}
