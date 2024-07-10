<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DaysField;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\BookingHelper;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class OwnerVenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'owner_venue') {
            return abort(403, 'Unauthorized');
        }

        $userId = $user->id;

        $fields = Field::whereHas('venue', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $bookedFields = $fields->filter(function ($field) use ($today) {
            return $field->dayfields()->where('date', $today)->exists();
        });

        $venues = Venue::where('user_id', $userId)->get();

        $isApproved = false;
        foreach ($venues as $venue) {
            if ($venue->is_approve) {
                $isApproved = true;
                break;
            }
        }

        $bookingCounts = [];
        foreach ($fields as $field) {
            $bookingCounts[$field->id] = BookingHelper::getTotalBookingsForField($field->id);
        }

        $venueIds = $venues->pluck('id')->toArray();
    $currentMonth = Carbon::now()->month;

    $monthlyRevenue = Schedule::whereIn('days_field_id', function ($query) use ($venueIds) {
        $query->select('id')
            ->from('days_fields')
            ->whereIn('field_id', function ($subQuery) use ($venueIds) {
                $subQuery->select('id')
                    ->from('fields')
                    ->whereIn('venue_id', $venueIds);
            });
    })
        ->join('bookings', 'bookings.schedule_id', '=', 'schedules.id')
        ->where('bookings.status', 'approved')
        ->whereMonth('schedules.start_time', $currentMonth)
        ->sum(DB::raw('schedules.price'));

        $fields = Field::whereHas('venue', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        // Mengambil rata-rata nilai rating untuk setiap lapangan
        $ratings = Rating::whereIn('field_id', $fields->pluck('id'))->select('field_id', DB::raw('AVG(nilai) as average_rating'))->groupBy('field_id')->get();
        $averageRatings = $ratings->pluck('average_rating', 'field_id')->toArray();
        $venue = Venue::where('user_id',$user->id)->first();
        
        return view('owner-venues.index', compact('venues','venue', 'isApproved', 'bookedFields', 'fields', 'bookingCounts', 'monthlyRevenue', 'ratings'));
    }


    public function allBooking()
    {
        $user = Auth::user();

        if ($user->role !== 'owner_venue') {
            return abort(403, 'Unauthorized');
        }

        $userId = $user->id;
        $venue = Venue::where('user_id', $userId)->first();

        $bookings = Booking::whereHas('schedule.daysField.field.venue', function ($query) use ($venue) {
            $query->where('id', $venue->id);
        })->get();

        return view('owner-venues.all-booking', compact('bookings'));
    }



//     public function getBookedFields()
// {
//     $user = Auth::user();

//     if ($user->role !== 'owner_venue') {
//         return abort(403, 'Unauthorized');
//     }



//     return view('owner-venues.booked-fields', compact('bookedFields'));
// }


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
        //
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

    public static function getTotalBookingsForField($fieldId)
{
    return Booking::whereHas('schedule.daysField.field', function ($query) use ($fieldId) {
        $query->where('id', $fieldId);
    })->count();
}
}
