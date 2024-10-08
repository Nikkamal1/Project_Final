<!-- resources/views/staffHome.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mb-4 text-center">สำหรับเจ้าหน้าที่</h1>

            <!-- Statistics Summary -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card border-primary shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">การนัดหมายทั้งหมด</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h3 class="text-primary">{{ $totalAppointments }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-warning shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">การนัดหมายที่รอดำเนินการ</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h3 class="text-warning">{{ $pendingAppointments }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
