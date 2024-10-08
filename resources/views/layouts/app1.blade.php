<!-- resources/views/layouts/app1.blade.php -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-lg-2 d-lg-block w3-sidebar w3-bar-block w3-light-grey w3-card position-sticky"
            style="background-color:corn-flower-blue; height: 100vh; overflow-y: auto;">
            <h5 class="w3-bar-item text-black">เมนู</h5>
            <a href="{{ route('user.home') }}" class="w3-bar-item w3-button text-black">หน้าหลัก</a>
            <a href="{{ route('user.appointments.create') }}" class="w3-bar-item w3-button text-black">จองคิวรถ รับ-ส่ง</a>
            <a href="{{ route('user.appointments.index') }}" class="w3-bar-item w3-button text-black">รายการจอง</a>
            <a href="{{ route('user.appointments.calendar') }}" class="w3-bar-item w3-button text-black">ปฏิทินการจอง</a>
            <a href="{{ route('user.assessments.index') }}" class="w3-bar-item w3-button text-black">ประเมินอาการ</a>
            <a href="{{ route('user.history.index') }}" class="w3-bar-item w3-button text-black">ประวัติการใช้งาน</a>
        </nav>

        <!-- Main Content -->
        <main class="col-lg-10 ms-sm-auto px-md-4" style="padding: 20px;">
            <!-- เนื้อหาหลัก -->
            @yield('main-content')
        </main>
    </div>
</div>
