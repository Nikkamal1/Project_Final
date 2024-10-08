<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->is_admin) {
            return redirect()->route('admin.home');
        } elseif ($user->is_staff) {
            return redirect()->route('staff.home');
        } else {
            return redirect()->route('user.home');
        }
    }

    public function adminHome(Request $request)
    {
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $approvedAppointments = Appointment::where('status', 'approved')->count();

        return view('adminHome', compact('totalAppointments', 'pendingAppointments', 'approvedAppointments'));
    }

   // ใน HomeController

public function staffHome(Request $request)
{
    $user = $request->user();

    // ดึงข้อมูลการนัดหมายทั้งหมดที่เกี่ยวข้องกับสตาฟ (ผ่าน user_id)
    $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

    // ส่งตัวแปรไปยัง View
    return view('staffHome', compact('totalAppointments', 'pendingAppointments'));
}

    public function userHome(Request $request)
    {
        return view('userHome');
    }
    
}
