@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">ประวัติการใช้งานของผู้ใช้</h1>

    <!-- ตารางประวัติการใช้งาน -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">รายการประวัติการใช้งาน</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>การกระทำ</th>
                        <th>รายละเอียด</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>สถานที่ส่ง</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($histories as $history)
                        <tr>
                            <td>{{ $history->action }}</td>
                            <td>{{ $history->details }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->appointment_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->appointment_time)->format('H:i') }}</td>
                            <td>{{ $history->dropoff_location }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">ไม่พบประวัติการใช้งาน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- แสดงลิงก์สำหรับการแบ่งหน้า -->
            <div class="d-flex justify-content-center">
                {{ $histories->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
