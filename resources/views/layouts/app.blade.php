<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon-precomposed.png') }}">

<!-- FullCalendar Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.min.js"></script>


    <!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.getJSON(' https://ab23-1-47-93-170.ngrok-free.app/data/thailand.json', function(data) {

            // Populate districts
            $('#pickup_province').on('change', function() {
                const province = $(this).val();
                $('#pickup_district').empty().append('<option value="">เลือกอำเภอ</option>');
                $('#pickup_subdistrict').empty().append('<option value="">เลือกตำบล</option>');
                if (province) {
                    $.each(data[province], function(district, subdistricts) {
                        $('#pickup_district').append(`<option value="${district}">${district}</option>`);
                    });
                }
            });


            // Populate subdistricts
            $('#pickup_district').on('change', function() {
                const province = $('#pickup_province').val();
                const district = $(this).val();
                $('#pickup_subdistrict').empty().append('<option value="">เลือกตำบล</option>');
                if (province && district) {
                    const subdistricts = data[province][district];
                    $.each(subdistricts, function(index, subdistrict) {
                        $('#pickup_subdistrict').append(`<option value="${subdistrict}">${subdistrict}</option>`);
                    });
                }
            });
        });
    });
</script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-info fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('#') }}">
                    <img src="{{ asset('img/hospitallogo-png.png') }}" style="width: 50px; height: 50px;" alt="Logo" />
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('ลงทะเบียน') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('img/Account-Setting--Streamline-Core-Gradient.png') }}"
                                        alt="User Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <img src="{{ asset('img/Account-Setting--Streamline-Core-Gradient.png') }}"
                                            alt="Logout Icon" style="width: 16px; height: 16px; margin-right: 8px;">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
<br />
@if (!Request::is('login') && !Request::is('register'))
    <div class="container-fluid mt-5 pt-3">
        <div class="row">
            <!-- Sidebar -->
            @if(Auth::check())
                <button id="sidebarToggle" class="btn btn-primary d-md-none w-100 mb-2">☰ เมนู</button>
                <nav id="sidebarMenu" class="sidebar col-lg-2 col-md-2 collapse d-md-block bg-light">
                    <ul class="nav flex-column">
                        @if(Auth::user()->is_admin == 1)
                            <li class="nav-item">
                                <a href="{{ route('admin.home') }}" class="nav-link text-dark">หน้าหลัก</a>
                            </li>
                            <li class="nav-item">
    <a href="{{ route('admin.users.index') }}" class="nav-link text-dark">การจัดการบัญชีผู้ใช้งาน</a>
</li>

                            <li class="nav-item">
                                <a href="{{ route('admin.appointments.index') }}" class="nav-link text-dark">รายการจองทั้งหมด</a>
                            </li>
                        @elseif(Auth::user()->is_staff == 2)
                            <li class="nav-item">
                                <a href="{{ route('staff.home') }}" class="nav-link text-dark">หน้าหลัก</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.appointments.create') }}" class="nav-link text-dark">เพิ่มการจองสำหรับผู้ใช้</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.appointments.index') }}" class="nav-link text-dark">รายการจองทั้งหมด</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('user.home') }}" class="nav-link text-dark">หน้าหลัก</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.appointments.create') }}" class="nav-link text-dark">จองคิวรถ รับ-ส่ง</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.appointments.index') }}" class="nav-link text-dark">รายการจอง</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.appointments.calendar') }}" class="nav-link text-dark">ปฏิทินการจอง</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.assessments.index') }}" class="nav-link text-dark">ประเมินอาการ</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.history.index') }}" class="nav-link text-dark">ประวัติการใช้งาน</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.profile.edit') }}">แก้ไขโปรไฟล์</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif

            <!-- Main Content -->
            <main class="col-lg-10 col-md-9 ms-sm-auto px-md-4">
                @yield('content')
            </main>
        </div>
    </div>
@else
    <main class="py-4">
        @yield('content')
    </main>
@endif

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        const sidebarMenu = document.getElementById('sidebarMenu');
        if (sidebarMenu.classList.contains('collapse')) {
            sidebarMenu.classList.remove('collapse');
        } else {
            sidebarMenu.classList.add('collapse');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        // กำหนดค่าตัวแปร map และ marker
        var map = L.map('map').setView([13.7563, 100.5018], 13); // เริ่มต้นที่กรุงเทพฯ

        // เพิ่ม layer ของแผนที่
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        // ฟังก์ชันอัปเดตแผนที่
        function updateMap(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            }
            map.setView([lat, lng], 13);
            document.getElementById('pickup_latitude').value = lat;
            document.getElementById('pickup_longitude').value = lng;
        }

        // ใช้ Geolocation API เพื่อรับตำแหน่งปัจจุบัน
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                // ตั้งค่าแผนที่และหมุดที่ตำแหน่งปัจจุบัน
                updateMap(lat, lng);

                // จัดการการคลิกแผนที่
                map.on('click', function(e) {
                    updateMap(e.latlng.lat, e.latlng.lng);
                });

                // จัดการการลากหมุด
                if (marker) {
                    marker.on('moveend', function(e) {
                        var latlng = e.target.getLatLng();
                        updateMap(latlng.lat, latlng.lng);
                    });
                }
            }, function() {
                alert("ไม่สามารถดึงตำแหน่งของคุณได้ ตำแหน่งเริ่มต้นจะถูกใช้");
            });
        } else {
            alert("เบราว์เซอร์ของคุณไม่รองรับ Geolocation");
        }

        // จัดการการตั้งค่าตำแหน่งปัจจุบันจากปุ่ม
        document.getElementById('setCurrentLocation').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    updateMap(lat, lng);
                });
            } else {
                alert("เบราว์เซอร์ของคุณไม่รองรับ Geolocation");
            }
        });
    });
</script>

</body>

</html>
