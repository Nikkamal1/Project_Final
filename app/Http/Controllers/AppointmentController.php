<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Client; // เพิ่มการใช้งาน GuzzleHttp\Client
class AppointmentController extends Controller
{
   public function create(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $searchName = $request->input('search_name');
    $searchEmail = $request->input('search_email');
    $searchStatus = $request->input('search_status');

    $query = \App\Models\User::query();

    if ($searchName) {
        $query->where('name', 'like', '%' . $searchName . '%');
    }

    if ($searchEmail) {
        $query->where('email', 'like', '%' . $searchEmail . '%');
    }

    if ($searchStatus) {
        $status = $searchStatus === 'active' ? 1 : 0;
        $query->where('is_active', $status);
    }

    $users = $query->get();

    if (auth()->user()->is_admin == 1) {
        return view('admin.appointments.create', ['users' => $users]);
    } elseif (auth()->user()->is_admin == 2 && auth()->user()->is_staff == 2) {
        $activeUsers = $users->where('is_active', 1);
        return view('staff.appointments.create', ['users' => $activeUsers]);
    } else {
        return view('user.appointments.create', ['users' => $users->where('id', auth()->id())]);
    }
}

    

public function store(Request $request)
{
    // ตรวจสอบข้อมูลที่ได้รับ
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'pickup_house_number' => 'nullable|string|max:255',
        'pickup_street' => 'nullable|string|max:255',
        'pickup_subdistrict' => 'nullable|string|max:255',
        'pickup_district' => 'nullable|string|max:255',
        'pickup_province' => 'nullable|string|max:255',
        'dropoff_location' => 'required|string|max:255',
        'appointment_date' => 'required|date',
        'appointment_time' => 'nullable|date_format:H:i',
        'picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        'pickup_latitude' => 'nullable|numeric',
        'pickup_longitude' => 'nullable|numeric',
        'user_id' => 'required|exists:users,id',
    ]);

    $appointment = new Appointment($validatedData);
    $appointment->user_id = $request->input('user_id');
    $appointment->save();

    UserHistory::create([
        'user_id' => auth()->id(),
        'action' => 'จองคิวรถ',
        'details' =>
                     ', วันที่: ' . \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') .
                     ', เวลา: ' . $appointment->appointment_time .
                     ', สถานที่ส่ง: ' . $appointment->dropoff_location,
        'appointment_date' => $appointment->appointment_date,
        'appointment_time' => $appointment->appointment_time,
        'dropoff_location' => $appointment->dropoff_location,
        
    ]);
    return redirect()->route(auth()->user()->is_admin == 1 ? 'admin.appointments.index' : (auth()->user()->is_admin == 2 && auth()->user()->is_staff == 2 ? 'staff.appointments.index' : 'user.appointments.index'))
        ->with('success', 'จองการนัดหมายเรียบร้อยแล้ว.');
}
    
    public function index()
    {
        $user = auth()->user();
        $appointments = Appointment::paginate(10); // จำนวนรายการต่อหน้า
        if ($user->is_admin == 1) {
            $appointments = Appointment::paginate(10);
            return view('admin.appointments.index', compact('appointments'));
        } elseif ($user->is_admin == 2 && $user->is_staff == 2) {
            $appointments = Appointment::paginate(10);
            return view('staff.appointments.index', compact('appointments'));
        } else {
            $appointments = Appointment::where('user_id', $user->id)->paginate(10);
            return view('user.appointments.index', compact('appointments'));
        }
    }

    public function edit($id)
    {
        $user = auth()->user();
        $appointment = Appointment::findOrFail($id);
    
        // Load JSON data
        $json = file_get_contents(public_path('data/thailand.json'));
        $data = json_decode($json, true);
    
        if ($user->is_admin == 1) {
            $users = \App\Models\User::all();
            return view('admin.appointments.edit', compact('appointment', 'users', 'data'));
        } elseif ($user->is_admin == 2 && $user->is_staff == 2) {
            $users = \App\Models\User::all();
            return view('staff.appointments.edit', compact('appointment', 'users', 'data'));
        } else {
            return view('user.appointments.edit', compact('appointment', 'data'));
        }
    }
    
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->is_admin == 1) {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dropoff_location' => 'required|string|max:255',
                'appointment_date' => 'required|date',
                'status' => 'required|string|max:255',
                
            ]);
        } elseif ($user->is_admin == 2 && $user->is_staff == 2) {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dropoff_location' => 'required|string|max:255',
                'appointment_date' => 'required|date',
            ]);
        } else {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'pickup_house_number' => 'nullable|string|max:255',
                'pickup_subdistrict' => 'nullable|string|max:255',
                'pickup_district' => 'nullable|string|max:255',
                'pickup_province' => 'nullable|string|max:255',
                'appointment_date' => 'required|date',
                'dropoff_location' => 'nullable|string|max:255',
            ]);
        }

        $appointment = Appointment::findOrFail($id);

        if ($user->is_admin == 1) {
            $appointment->user_id = $request->user_id;
            $appointment->first_name = $request->first_name;
            $appointment->last_name = $request->last_name;
            $appointment->dropoff_location = $request->dropoff_location;
            $appointment->appointment_date = $request->appointment_date;
            $appointment->status = $request->status;
        } elseif ($user->is_admin == 2 && $user->is_staff == 2) {
            $appointment->first_name = $request->first_name;
            $appointment->last_name = $request->last_name;
            $appointment->dropoff_location = $request->dropoff_location;
            $appointment->appointment_date = $request->appointment_date;
        } else {
            $appointment->first_name = $request->first_name;
            $appointment->last_name = $request->last_name;
            $appointment->pickup_house_number = $request->pickup_house_number;
            $appointment->pickup_subdistrict = $request->pickup_subdistrict;
            $appointment->pickup_district = $request->pickup_district;
            $appointment->pickup_province = $request->pickup_province;
            $appointment->dropoff_location = $request->dropoff_location;
            $appointment->appointment_date = $request->appointment_date;
        }

        if ($appointment->save()) {
            // เช็คสถานะการจองว่าถ้าเปลี่ยนเป็น "อนุมัติ" ให้ส่งการแจ้งเตือนทาง LINE
            if ($appointment->status == 'approved') {
                $message = "การจองของคุณสำหรับวันที่ " . $appointment->appointment_date . 
                           "\nชื่อ-นามสกุล: " . $appointment->first_name . 
                                         " ".$appointment->last_name . 
                           "\nสถานที่ส่ง: " . $appointment->dropoff_location; // ลบข้อความดูรายละเอียดออก
    
                // แทรกตำแหน่งที่ตั้งใน Google Maps
                $latitude = $appointment->latitude; // สมมุติว่า latitude เก็บไว้ใน Appointment
                $longitude = $appointment->longitude; // สมมุติว่า longitude เก็บไว้ใน Appointment
                $mapLink = "https://www.google.com/maps?q=$latitude,$longitude";
                $message .= "\n\nดูแผนที่สถานที่ปักหมุดที่นี่: " . $mapLink;
    
                $this->sendLineNotify($appointment->user_id, $message);
            }
    
            if ($user->is_admin == 1) {
                return redirect()->route('admin.appointments.index')->with('success', 'การจองถูกอัปเดตเรียบร้อยแล้ว');
            } elseif ($user->is_admin == 2 && $user->is_staff == 2) {
                return redirect()->route('staff.appointments.index')->with('success', 'การจองถูกอัปเดตเรียบร้อยแล้ว');
            } else {
                return redirect()->route('user.appointments.index')->with('success', 'การจองถูกอัปเดตเรียบร้อยแล้ว');
            }
        } else {
            return back()->withErrors(['msg' => 'การอัปเดตการจองล้มเหลว กรุณาลองใหม่อีกครั้ง']);
        }
    }

    protected function sendLineNotify($userId, $message)
{
    // ดึง LINE Notify token จากตาราง line_notifies โดยอิงจาก user_id
    $lineNotify = \DB::table('line_notifies')->where('user_id', $userId)->first();

    if (!$lineNotify) {
        \Log::error('LINE Notify token not found for user ID: ' . $userId);
        return;
    }

    $token = $lineNotify->access_token; // token เก็บไว้ในคอลัมน์ access_token

    \Log::info("Sending LINE Notify with token: $token and message: $message");

    $client = new Client();

    try {
        $response = $client->post('https://notify-api.line.me/api/notify', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'message' => $message,
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            \Log::info('LINE Notify sent successfully.');
        } else {
            \Log::error('LINE Notify error: ' . $response->getBody());
        }
    } catch (\Exception $e) {
        \Log::error('LINE Notify error: ' . $e->getMessage());
    }
}

    

        public function destroy($id)
    {
        $user = auth()->user();
        $appointment = $this->getAppointmentByRole($user, $id);

        $appointment->delete();

        UserHistory::create([
            'user_id' => $user->id,
            'action' => 'delete',
            'details' => 'Deleted appointment with ID ' . $appointment->id
        ]);

        return redirect()->route(auth()->user()->is_admin == 1 ? 'admin.appointments.index' : (auth()->user()->is_admin == 2 && auth()->user()->is_staff == 2 ? 'staff.appointments.index' : 'user.appointments.index'))
            ->with('success', 'ยกเลิกการจองสำเร็จ.');
    }

    private function getAppointmentByRole($user, $id)
    {
        if ($user->is_admin == 1) {
            return Appointment::findOrFail($id);
        } elseif ($user->is_admin == 2 && $user->is_staff == 2) {
            return Appointment::where('id', $id)
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->firstOrFail();
        } else {
            return Appointment::where('user_id', $user->id)->findOrFail($id);
        }
    }
    
    public function calendar()
    {
        // ดึงข้อมูลการจองเฉพาะของผู้ใช้ที่ล็อกอินอยู่
        $appointments = Appointment::where('user_id', auth()->id())->get();
    
        // ส่งข้อมูลการจองไปยังหน้า view 'user.appointments.calendar'
        return view('user.appointments.calendar', compact('appointments'));
    }

// app/Http/Controllers/AppointmentController.php

public function show($id)
{
    $user = auth()->user();

    // ตรวจสอบบทบาทของผู้ใช้
    if ($user->is_admin == 1) {
        // ถ้าเป็นแอดมินสามารถดูรายการจองของทุกคนได้
        $appointment = Appointment::find($id);
        return view('admin.appointments.show', compact('appointment'));
    } elseif ($user->is_admin == 2 && $user->is_staff == 2) {
        // ถ้าเป็นเจ้าหน้าที่สามารถดูรายการจองของทุกคนได้
        $appointment = Appointment::find($id);
        return view('staff.appointments.show', compact('appointment'));
    } else {
        // ถ้าเป็นผู้ใช้ทั่วไปสามารถดูรายการจองของตัวเองเท่านั้น
        $appointment = Appointment::where('user_id', $user->id)->find($id);
        return view('user.appointments.show', compact('appointment'));
    }

    // ถ้าไม่พบรายการจอง
    if (!$appointment) {
        return redirect()->route('home')->with('error', 'ไม่พบการจองที่ระบุ');
    }
}




}

