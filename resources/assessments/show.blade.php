<!-- resources/views/appointments/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">รายละเอียดการจอง</h2>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">การจองของ {{ $appointment->first_name }} {{ $appointment->last_name }}</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><strong>สถานที่ส่ง:</strong> {{ $appointment->dropoff_location }}</li>
                        <li><strong>วันที่จอง:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</li>
                        <li><strong>เวลา:</strong> {{ $appointment->appointment_time }}</li>
                        <li><strong>สถานะ:</strong> 
                            @switch($appointment->status)
                                @case('pending')
                                    <span class="badge bg-warning text-dark">รออนุมัติ</span>
                                    @break
                                @case('approved')
                                    <span class="badge bg-success">อนุมัติ</span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">ยกเลิก</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">ไม่ทราบสถานะ</span>
                            @endswitch
                        </li>
                    </ul>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">กลับ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
