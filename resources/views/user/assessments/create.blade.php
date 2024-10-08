@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Assessment</h1>
    <form action="{{ route('assessments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="patient_name">Patient Name</label>
            <input type="text" name="patient_name" class="form-control" id="patient_name" required>
        </div>
        <div class="form-group">
            <label for="assessment_date">Assessment Date</label>
            <input type="date" name="assessment_date" class="form-control" id="assessment_date" required>
        </div>
        <div class="form-group">
            <label for="details">Details</label>
            <textarea name="details" class="form-control" id="details" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
