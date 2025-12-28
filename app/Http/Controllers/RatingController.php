<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created rating in storage.
     */
    public function store(Request $request, Food $food)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user has already rated this food
        $existingRating = Rating::where('food_id', $food->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRating) {
            return redirect()->back()->with('error', 'You have already rated this recipe. Please edit your existing rating.');
        }

        $rating = new Rating();
        $rating->food_id = $food->id;
        $rating->user_id = Auth::id();
        $rating->rating = $request->rating;
        $rating->comment = $request->comment;
        $rating->save();

        return redirect()->back()->with('success', 'Your rating has been submitted successfully!');
    }

    /**
     * Update the specified rating in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        // Check if user is authorized to update this rating
        if (Auth::id() !== $rating->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to update this rating.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rating->rating = $request->rating;
        $rating->comment = $request->comment;
        $rating->save();

        return redirect()->back()->with('success', 'Your rating has been updated successfully!');
    }

    /**
     * Remove the specified rating from storage.
     */
    public function destroy(Rating $rating)
    {
        // Check if user is authorized to delete this rating
        if (Auth::id() !== $rating->user_id && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'You are not authorized to delete this rating.');
        }

        $rating->delete();

        return redirect()->back()->with('success', 'Rating has been deleted successfully!');
    }
}
