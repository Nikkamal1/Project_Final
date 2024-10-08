@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Assessment</h1>
    <form action="{{ route('assessments.update', $assessment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="patient_name">Patient Name</label>
            <input type="text" name="patient_name" class="form-control" id="patient_name" value="{{ $assessment->patient_name }}" required>
        </div>
        <div class="form-group">
            <label for="assessment_date">Assessment Date</label>
            <input type="date" name="assessment_date" class="form-control" id="assessment_date" value="{{ $assessment->assessment_date }}" required>
        </div>
        <div class="form-group">
            <label for="details">Details</label>
            <textarea name="details" class="form-control" id="details" required>{{ $assessment->details }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
