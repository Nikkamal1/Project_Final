@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">รายการจองทั้งหมด</h2>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ชื่อ</th>
                            <th>สถานที่ส่ง</th>
                            <th>วันที่จอง</th>
                            <th>เวลา</th>
                            <th>สถานะ</th>
                            <th>แผนที่</th>
                            <th>ดูรายละเอียด</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                                <td>{{ $appointment->dropoff_location }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</td>
                                <td>{{ $appointment->appointment_time }}</td>
                                <td>
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
                                </td>
                                <td>
                                <a href="https://maps.google.com/?q={{ $appointment->pickup_latitude }},{{ $appointment->pickup_longitude }}" target="_blank" class="btn btn-info btn-sm">ดูแผนที่</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-primary btn-sm">ดูรายละเอียด</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                      <!--  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือว่าต้องการลบรายการนี้?');">ลบ</button> -->
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination links, assuming $appointments is a paginated result -->
            <div class="d-flex justify-content-center">
                {{$appointments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection
