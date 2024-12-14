<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    //  public function index () {
    //     $user = auth()->user();
    //     $hasBoardingHouseWithRooms = $user->boardingHouses()
    //         ->whereHas('rooms') // Ensure the boarding house has at least one room
    //         ->exists();
    // return view('user_profile.index', compact('hasBoardingHouseWithRooms'));
    // }
    public function index()
{
    $user = auth()->user();

    // Check if the user has boarding houses with rooms
    $hasBoardingHouseWithRooms = $user->boardingHouses()
        ->whereHas('rooms') // Ensure the boarding house has at least one room
        ->exists();

    // Fetch reservations for the user
    $reservations = $user->reservations()->with('room.boardingHouse')->get();

    return view('user_profile.index', compact('hasBoardingHouseWithRooms', 'reservations'));
}

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    // public function uploadPhoto(Request $request)
    // {
    //     $request->validate([
    //         'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    
    //     $user = Auth::user();
    //     $image = $request->file('profile_picture');
    //     $imageName = time() . '.' . $image->getClientOriginalExtension();
    //     $image->move(public_path('images/profiles'), $imageName);
    
    //     // Update user's profile picture path in the database
    //     $user->profile_picture = 'images/profiles/' . $imageName;
    //     $user->save();
    
    //     return back()->with('success', 'Profile photo updated successfully.');
    // }
    public function uploadPhoto(Request $request)
    {
        // Validate the request data, including the image file
        $validated = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
        ]);
    
        $user = auth()->user(); // Assuming the logged-in user
    
        if ($request->hasFile('profile_image')) {
            // Delete the old image if it exists (if needed)
            if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }
    
            // Store the new image
            $imagePath = $request->file('profile_image')->store('public/profile_images');
    
            // Update the user's profile image path in the database
            $user->update([
                'profile_image' => basename($imagePath), // Store only the filename
            ]);
        }
    
        return back()->with('success', 'Profile updated successfully!');
    }
    
}
