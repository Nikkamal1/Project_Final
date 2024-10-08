<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // แสดงรายการผู้ใช้ทั้งหมด
   // แสดงรายการผู้ใช้ทั้งหมดพร้อมฟังก์ชันการค้นหา
   public function index(Request $request)
   {
       $query = User::query();

       // ค้นหาตามชื่อ
       if ($request->filled('search_name')) {
           $query->where('name', 'like', '%' . $request->search_name . '%');
       }

       // ค้นหาตามสิทธิ์การเข้าถึง
       if ($request->filled('search_role')) {
           if ($request->search_role === 'admin') {
               $query->where('is_admin', 1)->where('is_staff', 0);
           } elseif ($request->search_role === 'staff') {
               $query->where('is_admin', 2)->where('is_staff', 2);
           } elseif ($request->search_role === 'user') {
               $query->where('is_admin', 0);
           }
       }

       $usersList = $query->get();

       return view('admin.user.index', compact('usersList'));
   }

    // แสดงฟอร์มสร้างผู้ใช้ใหม่
    public function create()
    {
        return view('admin.user.create');
    }

    // ฟังก์ชันสำหรับจัดการการบันทึกผู้ใช้ใหม่
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff,user',
        ]);
    
        // กำหนดค่า is_admin และ is_staff ตาม role ที่เลือก
        $isAdmin = 0;
        $isStaff = 0;
    
        if ($request->role == 'admin') {
            $isAdmin = 1;
        } elseif ($request->role == 'staff') {
            $isAdmin = 2;
            $isStaff = 2;
        }
    
        // สร้างผู้ใช้ใหม่
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $isAdmin,
            'is_staff' => $isStaff,
        ]);
    
        return redirect()->route('admin.users.index')->with('success', 'ผู้ใช้ใหม่ถูกสร้างเรียบร้อยแล้ว');
    }
    // แสดงฟอร์มแก้ไขผู้ใช้
    public function edit($id)
    {
        $userToEdit = User::findOrFail($id);
        return view('admin.user.edit', compact('userToEdit'));
    }

    // อัปเดตข้อมูลผู้ใช้
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // กำหนดสิทธิ์การเข้าถึงตามค่า access_level ที่แก้ไข
    if ($request->access_level == 1) {
        // แอดมิน
        $user->is_admin = 1;
        $user->is_staff = 0;
    } elseif ($request->access_level == 2) {
        // เจ้าหน้าที่
        $user->is_admin = 2;
        $user->is_staff = 2;
    } else {
        // ผู้ใช้ทั่วไป
        $user->is_admin = 0;
        $user->is_staff = 0;
    }

    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'แก้ไขข้อมูลผู้ใช้เรียบร้อยแล้ว');
}

    

    // ลบผู้ใช้
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
    
}
