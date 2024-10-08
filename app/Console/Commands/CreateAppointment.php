<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;

class CreateAppointment extends Command
{
    protected $signature = 'appointment:create';
    protected $description = 'Create a new appointment';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $appointment = new Appointment();
        $appointment->user_id = 2;
        $appointment->first_name = 'test';
        $appointment->last_name = '1';
        $appointment->phone = '0';
        $appointment->pickup_house_number = '25';
        $appointment->pickup_province = 'นราธิวาส';
        $appointment->pickup_district = 'แว้ง';
        $appointment->pickup_subdistrict = 'แว้ง';
        $appointment->dropoff_location = 'โรงพยาบาลนราธิวาสราชนครินทร์';
        $appointment->appointment_date = '2024-09-22';
        $appointment->appointment_time = '23:47';
        $appointment->pickup_latitude = 6.4481574;
        $appointment->pickup_longitude = 101.7865766;
        $appointment->save();

        $this->info('Appointment created successfully!');
    }
}
