<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $boardingHouseId)
    {
        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        if (!$request->input('rating') && !$request->input('comment')) {
            return redirect()->back()->withErrors('Please provide at least a rating or a comment.')->withInput();
        }

        $existingReview = Review::where('user_id', Auth::id())
                                ->where('boarding_house_id', $boardingHouseId)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->withErrors('You have already submitted a review for this boarding house.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'boarding_house_id' => $boardingHouseId,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
