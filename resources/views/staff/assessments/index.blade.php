<!-- resources/views/staff/assessments/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>รายการประเมินอาการ</h2>

    <div class="mb-3">
        <a href="{{ route('staff.assessments.index') }}" class="btn btn-primary">เพิ่มการประเมินอาการ</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ชื่อผู้ใช้</th>
                <th>รายละเอียดการประเมิน</th>
                <th>วันที่</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assessments as $assessment)
                <tr>
                    <td>{{ $assessment->user->name }}</td>
                    <td>{{ $assessment->description }}</td>
                    <td>{{ $assessment->date }}</td>
                    <td>
                        <!-- ลิงค์ไปที่หน้าแสดงรายละเอียดการประเมิน -->
                        <a href="{{ route('staff.assessments.show', $assessment) }}" class="btn btn-info">ดูรายละเอียด</a>
                        <!-- ลิงค์ไปที่หน้าแก้ไขการประเมิน -->
                        <a href="{{ route('staff.assessments.edit', $assessment) }}" class="btn btn-warning">แก้ไข</a>
                        <!-- ฟอร์มสำหรับลบการประเมิน -->
                        <form action="{{ route('staff.assessments.destroy', $assessment) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">ไม่มีรายการประเมิน</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
