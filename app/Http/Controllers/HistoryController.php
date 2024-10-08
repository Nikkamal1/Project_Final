<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserHistory;

class HistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ดึงข้อมูลประวัติการใช้งานของผู้ใช้ที่ล็อกอิน
        $histories = UserHistory::where('user_id', $user->id)->paginate(10);

        // ส่งข้อมูลไปยัง view
        return view('history.index', compact('histories'));
    }
}
