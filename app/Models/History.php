<?php
// app/Models/History.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    // กำหนดว่าให้สามารถ fill ได้ที่ไหนบ้าง
    protected $fillable = ['details', 'date']; // เพิ่มฟิลด์ที่เกี่ยวข้อง
}
