@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">Admin Dashboard</h1>

            <!-- Statistics Summary -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-header bg-primary text-white">การนัดหมายทั้งหมด</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $totalAppointments }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-header bg-warning text-dark">การนัดหมายที่รอดำเนินการ</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $pendingAppointments }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-header bg-success text-white">การนัดหมายที่ได้รับการอนุมัติ</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $approvedAppointments }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports and Notifications -->
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <h3>Reports</h3>
                    <a href="{{ route('admin.reports') }}" class="btn btn-primary">View Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
