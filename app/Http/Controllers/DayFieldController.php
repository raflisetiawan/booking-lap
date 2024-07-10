<?php

namespace App\Http\Controllers;

use App\Models\DaysField;
use App\Models\Field;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DayFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $userId = auth()->id();


    $venueId = Venue::where('user_id', $userId)->value('id');
    $i = 1;

    $dayFields = DaysField::where('venue_id', $venueId)
        ->with('field')
        ->get();
    return view('day.index', compact('dayFields', 'i'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = auth()->id();


        $venueId = Venue::where('user_id', $userId)->value('id');
        $fields = Field::where('venue_id', $venueId)->get();
        return view('day.create',compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'field_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = auth()->id();

       
        $venueId = Venue::where('user_id', $userId)->value('id');

        DaysField::create([
            'date' => $request->date,
            'field_id' => $request->field_id,
            'venue_id' => $venueId
        ]);
        return redirect()->route('index-day')->with(['success' => 'Field created successfully']);
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

}
