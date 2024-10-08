<!-- resources/views/admin/user/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>เพิ่มผู้ใช้ใหม่</h2>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">ชื่อ</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">อีเมล</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">สิทธิ์การเข้าถึง</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin">แอดมิน</option>
                <option value="staff">เจ้าหน้าที่</option>
                <option value="user">ผู้ใช้</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
</div>
@endsection
