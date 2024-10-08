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
                    <form action="{{ route('user.appointments.update', $appointment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- ข้อมูลพื้นฐาน -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            value="{{ old('first_name', $appointment->first_name) }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                            value="{{ old('last_name', $appointment->last_name) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ข้อมูลที่อยู่ -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary">ข้อมูลที่อยู่</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pickup_house_number" class="form-label">บ้านเลขที่</label>
                                        <input type="text" name="pickup_house_number" id="pickup_house_number" class="form-control"
                                            value="{{ old('pickup_house_number', $appointment->pickup_house_number) }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="pickup_province" class="form-label">จังหวัด</label>
                                        <select name="pickup_province" id="pickup_province" class="form-select" required>
                                            <option value="">เลือกจังหวัด</option>
                                            @foreach(array_keys($data) as $province)
                                                <option value="{{ $province }}" {{ old('pickup_province', $appointment->pickup_province) == $province ? 'selected' : '' }}>
                                                    {{ $province }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="pickup_district" class="form-label">อำเภอ</label>
                                        <select name="pickup_district" id="pickup_district" class="form-select" required>
                                            <option value="">เลือกอำเภอ</option>
                                            @if(isset($data[$appointment->pickup_province]))
                                                @foreach(array_keys($data[$appointment->pickup_province]) as $district)
                                                    <option value="{{ $district }}" {{ old('pickup_district', $appointment->pickup_district) == $district ? 'selected' : '' }}>
                                                        {{ $district }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="pickup_subdistrict" class="form-label">ตำบล</label>
                                        <select name="pickup_subdistrict" id="pickup_subdistrict" class="form-select" required>
                                            <option value="">เลือกตำบล</option>
                                            @if(isset($data[$appointment->pickup_province][$appointment->pickup_district]))
                                                @foreach($data[$appointment->pickup_province][$appointment->pickup_district] as $subdistrict)
                                                    <option value="{{ $subdistrict }}" {{ old('pickup_subdistrict', $appointment->pickup_subdistrict) == $subdistrict ? 'selected' : '' }}>
                                                        {{ $subdistrict }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ข้อมูลการจอง -->
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

                        <!-- วันที่และเวลา -->
                        <div class="mb-4">
                            <h5 class="card-title">วันที่และเวลา</h5>
                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">วันที่จอง</label>
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control"
                                    value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
                            </div>
                         <!--   <div class="mb-3">
                                <label for="appointment_time" class="form-label">เวลาจอง</label>
                                <input type="time" name="appointment_time" id="appointment_time" class="form-control"
                                    value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
                            </div>
                        </div> -->

                        <!-- ปุ่มบันทึกการจอง -->
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
