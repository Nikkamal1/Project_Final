@extends('layouts.app')

@section('content')
<!-- Main Content -->
<main class="col-lg-9 col-md-12 ms-sm-10px px-md-4">
    <div class="card shadow-lg border-0 mb-4" style="background-color: #f0f8ff;">
        <div class="card-header bg-primary text-white text-center py-4">
            <h1 class="h3 fw-bold">ยินดีต้อนรับ {{ Auth::user()->name }} เข้าสู่ระบบ</h1>
        </div>
        <div class="card-body text-center py-5">
            <p class="lead mb-4">คุณสามารถดูและจัดการการนัดหมายของคุณได้ที่นี่.</p>
            <a href="{{ route('user.appointments.index') }}" class="btn btn-primary">ดูนัดหมาย</a>
            <br><br>
            <a href="{{ url('/line/authorize') }}" class="btn btn-success">รับการแจ้งเตือนผ่าน LINE Notify</a>

        </div>
    </div>
    
    <!-- Main Content Section -->
    @yield('main-content')
</main>
@endsection
