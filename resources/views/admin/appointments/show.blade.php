@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">รายละเอียดการจอง</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ชื่อ:</strong> {{ $appointment->first_name }} {{ $appointment->last_name }}
                    </div>
                    <div class="mb-3">
                        <strong>เบอร์โทรศัพท์:</strong> {{ $appointment->phone }}
                    </div>
                    <div class="mb-3">
                        <strong>บ้านเลขที่:</strong> {{ $appointment->pickup_house_number }}
                    </div>
                    <div class="mb-3">
                        <strong>ตำบล:</strong> {{ $appointment->pickup_subdistrict }}
                    </div>
                    <div class="mb-3">
                        <strong>อำเภอ:</strong> {{ $appointment->pickup_district }}
                    </div>
                    <div class="mb-3">
                        <strong>จังหวัด:</strong> {{ $appointment->pickup_province }}
                    </div>
                    <div class="mb-3">
                        <strong>สถานที่ส่ง:</strong> {{ $appointment->dropoff_location }}
                    </div>
                    <div class="mb-3">
                        <strong>วันที่จอง:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                    </div>
                    <div class="mb-3">
                        <strong>เวลาจอง:</strong> {{ $appointment->appointment_time }}
                    </div>
                    <div class="mb-3">
                        <strong>สถานะ:</strong>
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
                    </div>
                    <div class="mb-3">
                        <a href="https://maps.google.com/?q={{ urlencode($appointment->dropoff_location) }}" target="_blank" class="btn btn-info">ดูแผนที่</a>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('staff.appointments.index') }}" class="btn btn-secondary">กลับไปยังรายการจอง</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
