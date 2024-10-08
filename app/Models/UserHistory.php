<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $fillable = ['user_id', 'action', 'details']; // เพิ่มฟิลด์ที่สามารถกรอกได้
}