<?php
// app/Models/Appointment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  
        'first_name',
        'last_name',
        'phone',
        'pickup_house_number',
        'pickup_street',
        'pickup_subdistrict',
        'pickup_district',
        'pickup_province',
        'dropoff_location',
        'appointment_date',
        'appointment_time',
        'picture',
        'pickup_latitude',
        'pickup_longitude',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
