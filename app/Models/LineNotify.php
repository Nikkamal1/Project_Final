<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineNotify extends Model
{
    use HasFactory;

    // กำหนดชื่อของตาราง
    protected $table = 'line_notifies'; 

    // กำหนดว่าคอลัมน์ไหนบ้างที่สามารถบันทึกได้
    protected $fillable = [
        'user_id',
        'access_token',
    ];

    // กำหนดความสัมพันธ์กับผู้ใช้ (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
