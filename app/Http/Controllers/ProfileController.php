<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // แสดงหน้าแก้ไขโปรไฟล์
    public function edit()
    {
        $user = Auth::user(); // ดึงข้อมูลผู้ใช้ที่ล็อกอินอยู่
        return view('user.profile.edit', compact('user')); // ส่งตัวแปร $user ไปยังวิว
    }

    // อัปเดตข้อมูลโปรไฟล์
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            // อื่น ๆ
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'อัปเดตโปรไฟล์เรียบร้อยแล้ว.');
    }

    // อัปเดตรหัสผ่าน
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();
        if (!\Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = \Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'อัปเดตรหัสผ่านเรียบร้อยแล้ว.');
    }
}
