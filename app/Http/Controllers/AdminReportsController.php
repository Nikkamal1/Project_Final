<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index()
    {
        // ตรงนี้สามารถดึงข้อมูลรายงานจากฐานข้อมูลได้
        return view('adminReports');
    }
}
