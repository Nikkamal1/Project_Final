@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-4">จัดการบัญชีผู้ใช้</h2>
            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.appointments.create') }}" class="mb-4">
                <div class="row g-3">
                    <!-- Existing search fields -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="search_name">ค้นหาตามชื่อ:</label>
                            <input type="text" name="search_name" id="search_name" class="form-control"
                                value="{{ request('search_name') }}" placeholder="กรอกชื่อ">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="search_status">ค้นหาตามสถานะ:</label>
                            <select name="search_status" id="search_status" class="form-select">
                                <option value="">ทั้งหมด</option>
                                <option value="admin" {{ request('search_status') == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="staff" {{ request('search_status') == 'staff' ? 'selected' : '' }}>Staff
                                </option>
                                <option value="user" {{ request('search_status') == 'user' ? 'selected' : '' }}>User
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">ค้นหา</button>
                    </div>
                </div>
            </form>

            <!-- User Table -->
            <!-- ฟอร์มสำหรับอัปเดตสถานะและสิทธิ์ผู้ใช้ -->
            <form method="POST" action="{{ route('admin.appointments.store') }}">
                @csrf
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <input type="checkbox" name="active_users[]" value="{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <select name="roles[{{ $user->id }}]" class="form-select">
                                        <option value="0" {{ !$user->is_admin && !$user->is_staff ? 'selected' : '' }}>User
                                        </option>
                                        <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ $user->is_staff ? 'selected' : '' }}>Staff</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary w-100">บันทึก</button>
            </form>
            <div class="d-flex justify-content-center">
                {{$appointments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
        
    </div>
</div>
@endsection