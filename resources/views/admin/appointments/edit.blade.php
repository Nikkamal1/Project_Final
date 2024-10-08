@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <h2 class="mb-4">แก้ไขการจอง</h2>

            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="user_id">ผู้ใช้</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $appointment->user_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="first_name">ชื่อ</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $appointment->first_name }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="last_name">นามสกุล</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $appointment->last_name }}" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="dropoff_location">สถานที่ส่ง</label>
                            <input type="text" name="dropoff_location" id="dropoff_location" class="form-control" value="{{ $appointment->dropoff_location }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="appointment_date">วันที่นัดหมาย</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="status">สถานะ</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>รออนุมัติแล้ว</option>
                                <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>อนุมัติแล้ว</option>
                                <option value="rejected" {{ $appointment->status == 'rejected' ? 'selected' : '' }}>ไม่อนุมัติ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
