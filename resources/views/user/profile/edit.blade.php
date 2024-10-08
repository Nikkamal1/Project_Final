@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">แก้ไขโปรไฟล์</h1>

    <!-- แสดงข้อความสำเร็จ -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- แสดงข้อความผิดพลาด -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ฟอร์มแก้ไขข้อมูลโปรไฟล์ -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">ข้อมูลโปรไฟล์</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">ชื่อ:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">อีเมล:</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <button type="submit" class="btn btn-primary">อัปเดตข้อมูลโปรไฟล์</button>
            </form>
        </div>
    </div>

    <!-- ฟอร์มเปลี่ยนรหัสผ่าน -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">เปลี่ยนรหัสผ่าน</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.profile.password.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">รหัสผ่านปัจจุบัน:</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">รหัสผ่านใหม่:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">ยืนยันรหัสผ่านใหม่:</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">อัปเดตรหัสผ่าน</button>
            </form>
        </div>
    </div>
</div>
@endsection
