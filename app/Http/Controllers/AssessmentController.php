<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // กรณีเป็น Admin จะดึงข้อมูล Assessment ทั้งหมด
        if ($user->is_admin) {
            $assessments = Assessment::all();
        } 
        // กรณีเป็น Staff จะดึงข้อมูลเฉพาะที่ Staff คนนั้นเกี่ยวข้อง
        elseif ($user->is_staff) {
            $assessments = Assessment::all();
        } 
        // กรณีเป็น User จะดึงข้อมูลเฉพาะของตัวผู้ใช้เอง
        else {
            $assessments = Assessment::where('user_id', $user->id)->get();
        }

        // กำหนดเส้นทางตามบทบาทผู้ใช้เพื่อใช้ใน view
        $routePrefix = $user->is_admin ? 'admin' : ($user->is_staff ? 'staff' : 'user');

        return view('user.assessments.index', compact('assessments', 'routePrefix'));
    }

    public function create()
    {
        $user = auth()->user();
        
        // Admin หรือ Staff สามารถสร้าง assessment ได้
        if ($user->is_admin || $user->is_staff) {
            return view('assessments.create');
        }
        
        // ถ้าไม่ใช่ Admin หรือ Staff จะไม่สามารถเข้าถึงได้
        return redirect()->route('assessments.index')->with('error', 'Unauthorized access.');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // ถ้าไม่ใช่ Admin หรือ Staff จะไม่สามารถบันทึกข้อมูลได้
        if (!$user->is_admin && !$user->is_staff) {
            return redirect()->route('assessments.index')->with('error', 'Unauthorized access.');
        }

        // ตรวจสอบข้อมูลก่อนบันทึก
        $validatedData = $request->validate([
            'patient_name' => 'required|string|max:255',
            'assessment_date' => 'required|date',
            'details' => 'required|string',
        ]);

        // ถ้าเป็น Staff จะบันทึก staff_id ด้วย
        if ($user->is_staff) {
            $validatedData['staff_id'] = $user->id;
        }

        // สร้าง Assessment ใหม่
        Assessment::create($validatedData);

        return redirect()->route('assessments.index')->with('success', 'Assessment created successfully.');
    }

    public function show($id)
    {
        $user = auth()->user();
        $assessment = Assessment::findOrFail($id);

        // ตรวจสอบสิทธิ์การเข้าถึงข้อมูลของ Admin, Staff หรือ User
        if ($user->is_admin || ($user->is_staff && $assessment->staff_id == $user->id) || ($user->id == $assessment->user_id)) {
            return view('assessments.show', compact('assessment'));
        }

        return redirect()->route('assessments.index')->with('error', 'Unauthorized access.');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $assessment = Assessment::findOrFail($id);

        // ตรวจสอบสิทธิ์การแก้ไขข้อมูลของ Admin, Staff หรือ User
        if ($user->is_admin || ($user->is_staff && $assessment->staff_id == $user->id) || ($user->id == $assessment->user_id)) {
            return view('assessments.edit', compact('assessment'));
        }

        return redirect()->route('assessments.index')->with('error', 'Unauthorized access.');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $assessment = Assessment::findOrFail($id);
    
        // ตรวจสอบสิทธิ์การแก้ไขข้อมูล
        if ($user->is_admin || ($user->is_staff && $assessment->staff_id == $user->id) || ($user->id == $assessment->user_id)) {
            
            // ตรวจสอบข้อมูลก่อนการอัพเดต
            $validatedData = $request->validate([
                'patient_name' => 'required|string|max:255',
                'assessment_date' => 'required|date',
                'details' => 'required|string',
                // เพิ่มฟิลด์อื่น ๆ ที่ต้องการ
            ]);
    
            // อัพเดตข้อมูล Assessment
            $assessment->update($validatedData);
    
            return redirect()->route('assessments.index')->with('success', 'Assessment updated successfully.');
        }
    
        return redirect()->route('assessments.index')->with('error', 'Unauthorized access.');
    }
    
    public function destroy($id)
    {
        $user = auth()->user();
        $assessment = Assessment::findOrFail($id);

        // ตรวจสอบสิทธิ์การลบข้อมูลของ Admin, Staff หรือ User
        if ($user->is_admin || ($user->is_staff && $assessment->staff_id == $user->id) || ($user->id == $assessment->user_id)) {
            // ลบข้อมูล Assessment
            $assessment->delete();

            return redirect()->route('assessments.index')->with('success', 'Assessment deleted successfully.');
        }

        return redirect()->route('assessments.index')->with('error', 'Unauthorized access.');
    }
}
