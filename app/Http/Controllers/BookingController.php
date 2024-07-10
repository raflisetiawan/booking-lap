<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $selectedSchedules = $request->input('schedules');
        $image = $request->file('payment_proof');
        $image->storeAs('public/bookings', $image->hashName());
        foreach ($selectedSchedules as $scheduleId) {
            Booking::create([
                'schedule_id' => $scheduleId,
                'user_id' => Auth::id(),
                'payment_proof' => $image->hashName()
            ]);
        }

           //upload image
            $userid=Auth::id();

        return redirect()->route('profil.index', ['id' => $userid]);
    }

    /**
     * Display the specified resource.
     */
    public function show($venueId)
    {
        $selectedSchedules = request()->input('schedules', []);
        $bookings = Booking::whereIn('schedule_id', $selectedSchedules)->get();
        $schedules = Schedule::whereIn('id', $selectedSchedules)->get();
        $daysFields = $schedules->pluck('days_field_id')->unique();

            // Ambil ID jadwal yang sudah dibooking
    $bookedScheduleIds = $bookings->pluck('schedule_id')->toArray();

    // Ambil jadwal yang belum dibooking
    $availableSchedules = $schedules->reject(function ($schedule) use ($bookedScheduleIds) {
        return in_array($schedule->id, $bookedScheduleIds);
    });

        // Cek jika ada DaysField terkait dengan jadwal yang dipilih
        if ($daysFields->isEmpty()) {
            return redirect()->back()->with('error', 'No fields available for the selected schedules.');
        }

        $fields = Field::whereHas('dayfields', function ($query) use ($daysFields) {
            $query->whereIn('id', $daysFields);
        })->get();

        $venue = Venue::findOrFail($venueId);

        return view('booking.show', compact('bookings', 'schedules', 'fields', 'venue', 'availableSchedules'));
    }


    // BookingController.php
public function updateStatus(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = $request->input('status');
    if($booking->status == "approved"){
        $schedule = Schedule::find($booking->schedule_id);
        $schedule->update([
            'is_booking' => true
        ]);
    }
    $booking->save();


    return redirect()->back()->with('success', 'Booking status updated successfully.');
}




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
