@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">รายละเอียดการจอง</div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ชื่อสกุล:</strong> {{ $appointment->first_name }} {{ $appointment->last_name }}</li>
                        <li class="list-group-item"><strong>สถานที่ส่ง:</strong> {{ $appointment->dropoff_location }}</li>
                        <li class="list-group-item"><strong>วันที่จอง:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</li>
                        <li class="list-group-item"><strong>เวลา:</strong> {{ $appointment->appointment_time }}</li>
                        <li class="list-group-item"><strong>สถานะ:</strong>
                            @switch($appointment->status)
                                @case('pending')
                                    รออนุมัติ
                                    @break
                                @case('approved')
                                    อนุมัติแล้ว
                                    @break
                                @case('rejected')
                                    ยกเลิก
                                    @break
                                @default
                                    ไม่ทราบสถานะ
                            @endswitch
                        </li>
                        <!-- Add more fields as needed -->
                    </ul>

                    <!-- Map Container -->
                    <div id="map" style="height: 400px; margin-top: 20px;"></div>

                    <a href="{{ route('user.appointments.index') }}" class="btn btn-primary mt-3">กลับไปที่รายการจอง</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
