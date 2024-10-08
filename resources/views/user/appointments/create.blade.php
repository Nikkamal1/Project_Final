@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h2 class="h4 mb-0">จองคิวรถ รับ-ส่ง</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.appointments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- เลือกผู้ใช้ -->
                        <div class="mb-4">
                            <label for="user_id" class="form-label">ผู้ใช้</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">เลือกผู้ใช้</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- ข้อมูลพื้นฐาน -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary">ข้อมูลพื้นฐาน</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">ชื่อ</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">นามสกุล</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" name="phone" id="phone" class="form-control" required>
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
                                        <input type="text" name="pickup_house_number" id="pickup_house_number" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="pickup_province" class="form-label">จังหวัด</label>
                                        <select name="pickup_province" id="pickup_province" class="form-select" required>
                                            <option value="">เลือกจังหวัด</option>
                                            <option value="นราธิวาส">นราธิวาส</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="pickup_district" class="form-label">อำเภอ</label>
                                        <select name="pickup_district" id="pickup_district" class="form-select" required>
                                            <option value="">เลือกอำเภอ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="pickup_subdistrict" class="form-label">ตำบล</label>
                                        <select name="pickup_subdistrict" id="pickup_subdistrict" class="form-select" required>
                                            <option value="">เลือกตำบล</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <label for="dropoff_location" class="form-label">สถานที่ส่ง</label>
        <select name="dropoff_location" id="dropoff_location" class="form-select" required>
            <option value="">เลือกสถานที่ส่ง</option>
            <option value="โรงพยาบาลนราธิวาสราชนครินทร์">โรงพยาบาลนราธิวาสราชนครินทร์</option>
            <option value="โรงพยาบาลส่งเสริมสุขภาพตำบลลำภู">โรงพยาบาลส่งเสริมสุขภาพตำบลลำภู</option>
            <option value="โรงพยาบาลกัลยาณิวัฒนาการุณย์">โรงพยาบาลกัลยาณิวัฒนาการุณย์</option>
        </select>
    </div>
</div>

<!-- วันที่และเวลา -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title text-primary">วันที่และเวลา</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="appointment_date" class="form-label">วันที่จอง</label>
                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="appointment_time" class="form-label">เวลาจอง</label>
                <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
            </div>
        </div>
    </div>
</div>

                        <!-- ส่วนของแผนที่ Leaflet -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary">ปักหมุดตำแหน่งรับ</h5>
                                <div id="map" style="height: 400px;"></div>

                                <div class="mt-3">
                                    <label for="pickup_latitude" class="form-label">ละติจูด (Latitude) และ ลองจิจูด (Longitude)</label>
                                    <div class="input-group">
                                        <input type="text" name="pickup_latitude" id="pickup_latitude" class="form-control" placeholder="Latitude" readonly>
                                        <input type="text" name="pickup_longitude" id="pickup_longitude" class="form-control" placeholder="Longitude" readonly>
                                    </div>
                                    <button type="button" id="setCurrentLocation" class="btn btn-secondary mt-2">ตั้งค่าตำแหน่งปัจจุบัน</button>
                                </div>
                            </div>
                        </div>

                        <!-- ปุ่มบันทึกการจอง -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">บันทึกการจอง</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
