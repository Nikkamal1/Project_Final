@extends('layouts.app')

@section('content')

{{-- resources/views/user/assessments/index.blade.php --}}
    <div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8">
        <h2>รายการการประเมินอาการ</h2>

        {{-- ตรวจสอบข้อความแจ้งเตือน --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        {{-- ตารางแสดงข้อมูลการประเมิน --}}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อผู้ป่วย</th>
                    <th>วันที่ประเมิน</th>
                    <th>รายละเอียด</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assessments as $assessment)
                    <tr>
                        <td>{{ $assessment->id }}</td>
                        <td>{{ $assessment->patient_name }}</td>
                        <td>{{ $assessment->assessment_date }}</td>
                        <td>{{ Str::limit($assessment->details, 50) }}</td>
                        <td>
                            {{-- ปุ่มดูรายละเอียด --}}
                            <a href="{{ route('assessments.show', $assessment->id) }}" class="btn btn-info btn-sm">ดู</a>

                            {{-- ปุ่มแก้ไขข้อมูล --}}
                            @if(auth()->user()->is_admin || (auth()->user()->is_staff && $assessment->staff_id == auth()->user()->id))
                                <a href="{{ route('assessments.edit', $assessment->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                            @endif

                            {{-- ปุ่มลบข้อมูล --}}
                            @if(auth()->user()->is_admin || (auth()->user()->is_staff && $assessment->staff_id == auth()->user()->id))
                                <form action="{{ route('assessments.destroy', $assessment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบการประเมินนี้?')">ลบ</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">ไม่พบข้อมูลการประเมิน</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

