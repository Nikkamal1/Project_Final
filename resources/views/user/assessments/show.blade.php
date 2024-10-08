@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assessment Details</h1>
    <div class="form-group">
        <label for="patient_name">Patient Name</label>
        <input type="text" name="patient_name" class="form-control" id="patient_name" value="{{ $assessment->patient_name }}" readonly>
    </div>
    <div class="form-group">
        <label for="assessment_date">Assessment Date</label>
        <input type="date" name="assessment_date" class="form-control" id="assessment_date" value="{{ $assessment->assessment_date }}" readonly>
    </div>
    <div class="form-group">
        <label for="details">Details</label>
        <textarea name="details" class="form-control" id="details" readonly>{{ $assessment->details }}</textarea>
    </div>
    <a href="{{ route('assessments.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
