<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DaysField;
use App\Models\Field;
use App\Models\Rating;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Venue;
use App\Models\VenueCategory;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        //    return response()->json(['venue' => $venues], 201);
        return view('venues.index', compact('venues'));
    }

    public function getVenuesByUserId(){

    }

    public function create()
    {
        $categories = Category::all();

        return view('venues.create', compact('categories'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //validate form
        $validator = Validator::make($request->all(), [
            'image_venue'     => 'required|image|mimes:jpeg,jpg,png|max:10000',
            'name_venue'     => 'required|string',
            'address_venue' => 'required|string',
            'contact_venue' => 'required|string',
            'description_venue' => 'required|string',
            'facility_venue' => 'required|string',
            'lowest_price_venue' => 'required|string',
            'user_id' => 'required|exists:users,id',


        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        //upload image
        $image = $request->file('image_venue');
        $image->storeAs('public/venues', $image->hashName());

        //create post
        $venue = Venue::create([
            'image_venue'     => $image->hashName(),
            'name_venue'     => $request->name_venue,
            'address_venue'     => $request->address_venue,
            'contact_venue'     => $request->contact_venue,
            'description_venue'     => $request->description_venue,
            'facility_venue'     => $request->facility_venue,
            'lowest_price_venue'     => $request->lowest_price_venue,
            'user_id'     =>Auth::id(),

        ]);




        $categories = array_values($request->categories);

        foreach ($categories as $category) {
            VenueCategory::create([
                'venue_id' => $venue->id,
                'category_id' => $category
            ]);
        }

        // dd($request->user_id);

        $user = User::find($venue->user_id);
        $user->role = 'owner_venue';
        $user->save();


        //redirect to index
        // return response()->json(['venue' => $venue], 201);
        return redirect()->route('Dashboard-owner')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function show(string $venueId)
    {
        $venue = Venue::findOrFail($venueId);
        $fields = Field::whereHas('venue', function ($query) use ($venueId) {
            $query->where('id', $venueId);
        })->get();

        $dayFields = DaysField::whereIn('field_id', $fields->pluck('id'))
            ->with(['field', 'schedules' => function ($query) {
                $query->where('is_booking', false);
            }])
            ->get();

        $categories = VenueCategory::where('venue_id', $venueId)->get();

        $categoryVenue = [];

        foreach ($categories as $category) {
            $categoryVenue = Category::findOrFail($category->category_id)->get();
        }

        $dayFieldsWithDay = $dayFields->map(function ($dayField) {
            $date = Carbon::parse($dayField->date);
            $dayOfWeek = $date->isoFormat('dddd, DD MMMM YYYY');

            $dayField->dayOfWeek = $dayOfWeek;

            return $dayField;
        });

        $fieldIds = $fields->pluck('id');
        $averageRatings = Rating::whereIn('field_id', $fieldIds)
            ->select('field_id', DB::raw('AVG(nilai) as average_rating'))
            ->groupBy('field_id')
            ->get();

        return view('venues.show', compact('venue', 'categoryVenue', 'dayFields', 'fields', 'dayFieldsWithDay', 'averageRatings'));
    }





    public function edit(string $id): View
    {
        //get post by ID
        $venue = Venue::findOrFail($id);
        $categories = Category::all();

        //render view with post
        return view('venues.edit', compact('venue', 'categories'));
    }

    public function update(Request $request, $id)
    {
        //validate form
        $validator = Validator::make($request->all(), [
            'image_venue'     => 'image|mimes:jpeg,jpg,png|max:10000',
            'name_venue'     => 'required|string',
            'address_venue' => 'required|string',
            'contact_venue' => 'required|string',
            'description_venue' => 'required|string',
            'facility_venue' => 'required|string',
            'lowest_price_venue' => 'required|string',
            'user_id' => 'required|exists:users,id',


        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $venue = Venue::findOrFail($id);
        //upload image
        if ($request->hasFile('image_venue')) {
            $image = $request->file('image_venue');
            $image->storeAs('public/venues', $image->hashName());

            Storage::delete('public/venues/' . $venue->image_venue);

            //create post
            $venue->update([
                'image_venue'     => $image->hashName(),
                'name_venue'     => $request->name_venue,
                'address_venue'     => $request->address_venue,
                'contact_venue'     => $request->contact_venue,
                'description_venue'     => $request->description_venue,
                'facility_venue'     => $request->facility_venue,
                'lowest_price_venue'     => $request->lowest_price_venue,
                'user_id'     => $request->user_id,

            ]);



            $venue->categories()->sync($request->categories);
        } else {
            $venue->update([
                'name_venue'     => $request->name_venue,
                'address_venue'     => $request->address_venue,
                'contact_venue'     => $request->contact_venue,
                'description_venue'     => $request->description_venue,
                'facility_venue'     => $request->facility_venue,
                'lowest_price_venue'     => $request->lowest_price_venue,
                'user_id'     => $request->user_id,

            ]);




            $venue->categories()->sync($request->categories);

        }
        return redirect()->route('venues.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $venue = Venue::findOrFail($id);
        $categories = VenueCategory::where('venue_id',$id)->get();
        $venue->categories()->detach($categories);

        //delete image
        Storage::delete('public/venues/'. $venue->image);

        //delete venue$venue
        $venue->delete();

        //redirect to index
        return redirect()->route('venues.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
