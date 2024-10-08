@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">ปฏิทินการจอง</h1>
    
    @php
        $today = \Carbon\Carbon::now();
        $currentMonth = $today->month;
        $currentYear = $today->year;
        $firstDayOfMonth = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1);
        $lastDayOfMonth = \Carbon\Carbon::createFromDate($currentYear, $currentMonth)->endOfMonth();
        $firstDayOfWeek = $firstDayOfMonth->startOfWeek(); // วันจันทร์ของสัปดาห์แรกของเดือน
        $appointmentsByDate = $appointments->groupBy(function ($appointment) {
            return \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y');
        });
    @endphp

    <div class="calendar">
        <div class="month bg-primary text-white p-3 text-center rounded mb-3">
            <h2>{{ $firstDayOfMonth->translatedFormat('F Y') }}</h2> <!-- แสดงชื่อเดือนและปี -->
        </div>
        
        <div class="row bg-light text-center fw-bold">
            <div class="col day">จ</div>
            <div class="col day">อ</div>
            <div class="col day">พ</div>
            <div class="col day">พฤ</div>
            <div class="col day">ศ</div>
            <div class="col day">ส</div>
            <div class="col day">อา</div>
        </div>

        <div class="row">
            @for ($i = 0; $i < $firstDayOfWeek->dayOfWeek; $i++)
                <div class="col day"></div> <!-- ช่องว่างสำหรับวันก่อนหน้า -->
            @endfor
            
            @for ($i = 1; $i <= $lastDayOfMonth->day; $i++)
                @php
                    $currentDate = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, $i);
                @endphp
                <div class="col day border" style="min-height: 120px; position: relative;">
                    <div class="date position-absolute top-0 end-0 p-2">{{ $i }}</div>
                    @if ($appointmentsByDate->has($currentDate->format('d/m/Y')))
                        @foreach ($appointmentsByDate[$currentDate->format('d/m/Y')] as $appointment)
                        <br />
                            <div class="appointment {{ $appointment->status == 'approved' ? 'bg-success' : 'bg-warning' }} text-white rounded p-1 m-1">
                                {{ $appointment->first_name }} {{ $appointment->last_name }}<br>
                                <span class="status">{{ $appointment->status == 'approved' ? '✔️ อนุมัติ' : '⏳ รออนุมัติ' }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="no-appointment text-muted">ไม่มีการจอง</div>
                    @endif
                </div>

                @if (($i + $firstDayOfWeek->dayOfWeek) % 7 == 0)
                    </div><div class="row"> <!-- เริ่มแถวใหม่ทุก 7 วัน -->
                @endif
            @endfor

            @for ($i = $lastDayOfMonth->day + $firstDayOfWeek->dayOfWeek; $i % 7 != 0; $i++)
                <div class="col day"></div> <!-- ช่องว่างสำหรับวันถัดไป -->
            @endfor
        </div>
    </div>
</div>

<style>
    .calendar {
        margin-top: 20px;
    }
    .day {
        padding: 10px;
        border: 1px solid #ddd;
        height: 120px;
        position: relative;
        transition: background-color 0.2s; /* เปลี่ยนสีเมื่อวางเมาส์ */
        overflow: hidden; /* ป้องกันการล débordement ของเนื้อหา */
    }
    .day:hover {
        background-color: #f0f8ff; /* สีเมื่อวางเมาส์ */
    }
    .appointment {
        font-size: 0.9em;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2); /* เพิ่มเงาให้กับการจอง */
    }
    .no-appointment {
        text-align: center;
        font-style: italic;
    }
    .status {
        font-weight: bold;
        color: yellow; /* สีสำหรับสถานะอนุมัติ */
    }
</style>
@endsection
