@extends('layouts.app')

@section('content')
    <div>
        <h1>Confirm Booking</h1>
        <p>Date: {{ $booking['date'] }}</p>
        <p>Time: {{ $booking['time'] }}</p>
        <p>Location: {{ $booking['location'] }}</p>
        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="date" value="{{ $booking['date'] }}">
            <input type="hidden" name="time" value="{{ $booking['time'] }}">
            <input type="hidden" name="location" value="{{ $booking['location'] }}">
            <button type="submit">Confirm</button>
        </form>
    </div>
@endsection
