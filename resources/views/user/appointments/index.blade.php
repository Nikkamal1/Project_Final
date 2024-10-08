@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="dashboard-header mb-4">
                <h2 class="text-center">รายการจองของคุณ</h2>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ชื่อสกุล</th>
                        <th>สถานที่ส่ง</th>
                        <th>วันที่จอง</th>
                        <th>เวลา</th>
                        <th>สถานะ</th>
                        <th>ดูรายละเอียด</th>
                        @if (auth()->user()->is_admin)
                            <th>จัดการ</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                            <td>{{ $appointment->dropoff_location }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                            <td>{{ $appointment->appointment_time }}</td>
                            <td>
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
                            </td>
                            <td>
                                <a href="{{ route('user.appointments.show', $appointment->id) }}" class="btn btn-info btn-sm">ดูรายละเอียด</a>
                                <a href="{{ route('user.appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                <form action="{{ route('staff.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                            </td>
                            @if (auth()->user()->is_admin)
                                <td>
                                    <a href="{{ route('staff.appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="{{ route('staff.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">ลบ</button>
                                    </form>
                                    <form action="{{ route('staff.appointments.update', $appointment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="status" value="pending" class="btn btn-secondary btn-sm">รออนุมัติ</button>
                                        <button type="submit" name="status" value="approved" class="btn btn-success btn-sm">อนุมัติแล้ว</button>
                                        <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">ยกเลิก</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->is_admin ? 7 : 6 }}" class="text-center">ไม่มีการจอง</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
