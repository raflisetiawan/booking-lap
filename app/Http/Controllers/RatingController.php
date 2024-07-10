<?php

namespace App\Http\Controllers;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'field_id' => 'required',
            'nilai' => 'required',
            'comment' => 'nullable|string|max:255',
        ]);

        $user = auth()->id();
        $fieldId = $validatedData['field_id'];

        $existingRating = Rating::where('field_id', $fieldId)
            ->where('user_id', $user)
            ->first();

        if ($existingRating) {
            $existingRating->update([
                'nilai' => $validatedData['nilai'],
                'comment' => $validatedData['comment'],
            ]);

            return redirect()->back()->with('success', 'Rating updated successfully.');
        }

        Rating::create([
            'field_id' => $fieldId,
            'nilai' => $validatedData['nilai'],
            'comment' => $validatedData['comment'],
            'user_id' => $user,
        ]);
        return redirect()->back()->with('success', 'Rating submitted successfully.');
    }


}
