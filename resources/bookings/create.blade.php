@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('bookings.store') }}">
        @csrf
        <div>
            <label for="date">Date</label>
            <input id="date" type="date" name="date" required>
        </div>

        <div>
            <label for="time">Time</label>
            <input id="time" type="time" name="time" required>
        </div>

        <div>
            <label for="location">Location</label>
            <input id="location" type="text" name="location" required>
        </div>

        <div>
            <button type="submit">Book</button>
        </div>
    </form>
@endsection
