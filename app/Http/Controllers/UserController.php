<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->with('schedule.daysField.field.venue')->get();
        $bookingCount = Booking::where('user_id', $user->id)->count();


        return view('profil.index', compact('user', 'bookings', 'bookingCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
{
    $user = Auth::user();
    return view('profil.edit', compact('user'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $user = User::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
        ]);
        $image = $request->file('profile_picture');

        if ($request->hasFile('profile_picture')) {
            $oldImagePath = $user->profile_picture;
            $image->storeAs('public/users', $image->hashName());


            if ($oldImagePath) {
                Storage::delete('public/users/' . $oldImagePath);
            }
        } else {
            return redirect()->back()->withErrors(['message' => 'Invalid image file']);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profil.show', $user->id)->with('success', 'Profil berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
