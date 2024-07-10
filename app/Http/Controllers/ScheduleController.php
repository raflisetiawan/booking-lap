<?php

namespace App\Http\Controllers;

use App\Models\DaysField;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $dayField = DaysField::find($id);
        $i = 1;
        $userId = Auth::id();
        // if($dayField->venue_id !== $userId){
        //     return view('dashboard');
        // }

        $schedules = Schedule::where('days_field_id', $id)->get();
        return view('schedule.index', compact('schedules', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $dayField = DaysField::with('field')->findOrFail($id);
        return view('schedule.create', compact('dayField'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'price' => 'required',
        ]);

        $schedule = Schedule::create([
            'days_field_id' => $id,
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'price' => $validatedData['price'],
        ]);

        if ($schedule) {

            return redirect()->route('index-day')->with('success', 'Schedule created successfully');
        } else {

            return redirect()->back()->with('error', 'Failed to create schedule');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function updateIsBooking(string $id)
    {
        $schedule = Schedule::find($id);
        $schedule->is_booking = !$schedule->is_booking;
        $schedule->save();

        return redirect()->back()->with('success', 'Booking status updated successfully');
    }


}
