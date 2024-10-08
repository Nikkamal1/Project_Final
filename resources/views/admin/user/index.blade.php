<!-- resources/views/admin/user/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>จัดการผู้ใช้</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">เพิ่มผู้ใช้ใหม่</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ฟอร์มค้นหา -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
        <div class="form-row">
            <div class="col">
                <input type="text" name="search_name" class="form-control" placeholder="ค้นหาตามชื่อ" value="{{ request('search_name') }}">
            </div>
            <div class="col">
                <select name="search_role" class="form-control">
                    <option value="">ค้นหาตามสิทธิ์การเข้าถึง</option>
                    <option value="admin" {{ request('search_role') == 'admin' ? 'selected' : '' }}>แอดมิน</option>
                    <option value="staff" {{ request('search_role') == 'staff' ? 'selected' : '' }}>เจ้าหน้าที่</option>
                    <option value="user" {{ request('search_role') == 'user' ? 'selected' : '' }}>ผู้ใช้งาน</option>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">ค้นหา</button>
            </div>
        </div>
    </form>

    <!-- ตารางแสดงข้อมูลผู้ใช้ -->
    <table class="table">
        <thead>
            <tr>
                <th>ชื่อ</th>
                <th>อีเมล</th>
                <th>สิทธิ์การเข้าถึง</th>
                <th>ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usersList as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin == 1 && $user->is_staff == 0)
                            แอดมิน
                        @elseif($user->is_admin == 2 && $user->is_staff == 2)
                            เจ้าหน้าที่
                        @else
                            ผู้ใช้งาน
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
