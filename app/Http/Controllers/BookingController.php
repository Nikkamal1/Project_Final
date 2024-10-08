<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|time',
            'location' => 'required|string|max:255',
        ]);

        Booking::create($validated);

        return redirect()->route('bookings.confirm', ['booking' => $validated]);
    }

    public function confirm($booking)
    {
        return view('bookings.confirm', compact('booking'));
    }
}
