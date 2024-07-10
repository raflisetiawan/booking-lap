<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class  AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $user = auth()->user();
         if (!$user || $user->role !== 'admin') {
             abort(403, 'Unauthorized');
         }

         $revenueData = $this->getMonthlyRevenueData();

         return view('admin.index', compact('revenueData'));
     }

     private function getMonthlyRevenueData()
     {
         $revenueData = Booking::join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
             ->where('bookings.status', 'approved')
             ->select(
                 DB::raw('MONTH(schedules.start_time) AS month'),
                 DB::raw('SUM(schedules.price) AS total_revenue')
             )
             ->groupBy('month')
             ->get();

         $formattedData = [];
         foreach ($revenueData as $data) {
             $formattedData[$data->month] = $data->total_revenue;
         }

         // Fill in missing months with zero revenue
         $currentMonth = Carbon::now()->month;
         for ($month = 1; $month <= 12; $month++) {
             if (!isset($formattedData[$month])) {
                 $formattedData[$month] = 0;
             }
             if ($month > $currentMonth) {
                 break; // Stop filling in future months
             }
         }

         return $formattedData;
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

    public function getAllVenues()
    {
        $venues = Venue::all();
        return view('admin.venues', compact('venues'));
    }
    public function updateApprove(Request $request, $id)
{
    $venue = Venue::findOrFail($id);

    $venue->is_approve = !$venue->is_approve;
    $venue->save();

    return redirect()->back()->with('success', 'Status approve venue berhasil diubah.');
}
}
