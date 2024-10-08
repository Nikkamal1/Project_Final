<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getData()
    {
        $data = [/* ข้อมูลที่ต้องการส่ง */];
        return response()->json($data);
    }
}

