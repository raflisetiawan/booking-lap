<?php

namespace App\Http\Controllers;

use App\Models\DaysField;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $venue = Venue::where('user_id', $userId)->first();
        $fields = Field::where('venue_id', $venue->id)->get();
        $i = 1;
        return view('field.index', compact('fields', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = auth()->id();


        $venueId = Venue::where('user_id', $userId)->value('id');


        $categories = Venue::findOrFail($venueId)->categories;

        return view('field.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'image_field' => 'required|image|mimes:jpeg,jpg,png|max:10000',
            'name_field' => 'required|string',
            'category' => 'required|string',
            'type_field' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $image = $request->file('image_field');
        if (!$image) {
            return redirect()->back()->withErrors(['message' => 'Invalid image file']);
        }

        if ($request->hasFile('image_field') && $image->isValid()) {

            $image->storeAs('public/fields', $image->hashName());
        } else {
            return redirect()->back()->withErrors(['message' => 'Invalid image file']);
        }

        $userId = auth()->id();
        if (!$userId) {

            return redirect()->back()->withErrors(['message' => 'User does not have a venue']);
        }

        $venueId = Venue::where('user_id', $userId)->value('id');


        if (!$venueId) {

            return redirect()->back()->withErrors(['message' => 'User does not have a venue']);
        }


        $field = Field::create([
            'image_field' => $image->hashName(),
            'name_field' => $request->name_field,
            'category' => $request->category,
            'type_field' => $request->type_field,
            'venue_id' => $venueId,
        ]);

        return redirect()->route('index-field')->with(['success' => 'Field created successfully']);
    }

    /**
     * Display the specified resource.
     */
public function show(string $id)
{
    $field = Field::findOrFail($id);



    return view('field.show', compact('field'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userId = auth()->id();

        $venueId = Venue::where('user_id', $userId)->value('id');


        $categories = Venue::findOrFail($venueId)->categories;
        $field = Field::findOrFail($id);


        return view('field.edit', compact('categories','field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name_field' => 'required|string',
            'category' => 'required|string',
            'type_field' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userId = auth()->id();
        if (!$userId) {
            return redirect()->back()->withErrors(['message' => 'User does not have a venue']);
        }

        $venueId = Venue::where('user_id', $userId)->value('id');
        if (!$venueId) {
            return redirect()->back()->withErrors(['message' => 'User does not have a venue']);
        }

        $field = Field::find($id);
        $image = $request->file('image_field');
        if (!$image) {
            $field->update([
                'name_field' => $request->name_field,
                'category' => $request->category,
                'type_field' => $request->type_field,
                'venue_id' => $venueId,
            ]);
            return redirect()->route('index-field')->with(['success' => 'Field updated successfully']);
        }

        if ($request->hasFile('image_field') && $image->isValid()) {
            $oldImagePath = $field->image_field;
            $image->storeAs('public/fields', $image->hashName());


            if ($oldImagePath) {
                Storage::delete('public/fields/' . $oldImagePath);
            }
        } else {
            return redirect()->back()->withErrors(['message' => 'Invalid image file']);
        }

        $field->update([
            'image_field' => $image->hashName(),
            'name_field' => $request->name_field,
            'category' => $request->category,
            'type_field' => $request->type_field,
            'venue_id' => $venueId,
        ]);

        return redirect()->route('index-field')->with(['success' => 'Field updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field = Field::find($id);

        if (!$field) {
            return redirect()->back()->withErrors(['message' => 'Field not found']);
        }

        $imagePath = $field->image_field;


        if ($imagePath) {
            Storage::delete('public/fields/' . $imagePath);
        }

        $field->delete();

        return redirect()->route('index-field')->with(['success' => 'Field deleted successfully']);
    }
    public function search(Request $request)
    {
        $date = $request->input('date');
        $time = $request->input('time');


        $selectedDateTime = Carbon::parse($date . ' ' . $time);


        $selectedDayOfWeek = $selectedDateTime->dayOfWeek;

        
        $daysFields = DaysField::with('field', 'venue', 'schedules')
            ->where('date', $date)
            ->whereHas('schedules', function ($query) use ($time) {
                $query->where('start_time', $time);
            })
            ->get();

        return view('field.search', compact('daysFields'));
    }


}
