@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
            <h2 class="h4 mb-0">แก้ไขการจอง</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('staff.appointments.update', $appointment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body">
                                
                                    <div class="col-md-6 mb-3">
                    <label for="user_id" class="form-label">ผู้ใช้</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $appointment->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">ชื่อ</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $appointment->first_name }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">นามสกุล</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $appointment->last_name }}" required>
                </div>
                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5 class="card-title">ข้อมูลการจอง</h5>
                            <div class="mb-3">
                                <label for="dropoff_location" class="form-label">สถานที่ส่ง</label>
                                <select type="text" name="dropoff_location" id="dropoff_location" class="form-control"
                                    value="{{ old('dropoff_location', $appointment->dropoff_location) }}" required>
                                    <option value="">เลือกสถานที่ส่ง</option>
                                    <option value="โรงพยาบาลนราธิวาสราชนครินทร์">โรงพยาบาลนราธิวาสราชนครินทร์
                                    </option>
                                    <option value="โรงพยาบาลส่งเสริมสุขภาพตำบลลำภู">
                                        โรงพยาบาลส่งเสริมสุขภาพตำบลลำภู
                                    </option>
                                    <option value="โรงพยาบาลกัลยาณิวัฒนาการุณย์">โรงพยาบาลกัลยาณิวัฒนาการุณย์
                                    </option>
                                    </select>
                            </div>
                        </div>


                <div class="mb-3">
                    <label for="appointment_date" class="form-label">วันที่จอง</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">สถานะ</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>รออนุมัติ</option>
                        <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>อนุมัติแล้ว</option>
                        <option value="rejected" {{ $appointment->status == 'rejected' ? 'selected' : '' }}>ไม่อนุมัติ</option>
                    </select>
                </div>
                <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">อัปเดตการจอง</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
