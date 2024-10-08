<!-- resources/views/admin/user/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>แก้ไขผู้ใช้</h2>

    <form action="{{ route('admin.users.update', $userToEdit->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">ชื่อ</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $userToEdit->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">อีเมล</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $userToEdit->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">รหัสผ่าน (เว้นว่างหากไม่ต้องการเปลี่ยน)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

    <!-- การตั้งค่าการเข้าถึง -->
<div class="form-group">
    <label for="access_level">สิทธิ์การเข้าถึง:</label>
    <select id="access_level" name="access_level" class="form-control">
        <option value="0" {{ $userToEdit->is_admin == 0 && $userToEdit->is_staff == 0 ? 'selected' : '' }}>ผู้ใช้</option>
        <option value="1" {{ $userToEdit->is_admin == 1 && $userToEdit->is_staff == 0 ? 'selected' : '' }}>แอดมิน</option>
        <option value="2" {{ $userToEdit->is_admin == 2 && $userToEdit->is_staff == 2 ? 'selected' : '' }}>เจ้าหน้าที่</option>
    </select>
</div>


        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
    </form>
</div>
@endsection
