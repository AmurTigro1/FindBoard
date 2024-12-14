<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function show()
    {
        return view('verification.index'); // Create this view
    }
//     public function uploadPhoto(Request $request)
// {
//     $request->validate([
//         'photo' => 'required|image|max:2048',
//     ]);

//     $user = auth()->user();
//     $path = $request->file('photo')->store('profile-photos', 'public');

//     $user->profile_photo_path = $path;
//     $user->save();

//     return redirect()->route('verification.page')->with('success', 'Photo uploaded successfully!');
// }
public function uploadPhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
    ]);

    $user = auth()->user(); // Ensure you're getting the logged-in user

    // Store the photo in the 'public' disk
    $path = $request->file('photo')->store('profile_photos', 'public');

    // Update the user's profile photo path in the database
    $user->profile_photo_path = $path;
    $user->save();

    return back()->with('success', 'Photo uploaded successfully.');
}


public function verifyPhone(Request $request)
{
    $request->validate([
        'phone' => 'required|numeric|min:10', // Adjust validation rules as needed
    ]);

    $user = auth()->user();

    // Save the phone number and mark it as verified (for demo purposes)
    $user->phone = $request->input('phone');
    $user->phone_verified_at = now();
    $user->save();

    return redirect()->route('verification.page')->with('success', 'Phone number verified successfully!');
}

public function uploadBusinessPermit(Request $request)
{
    $request->validate([
        'business_permit' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $landlord = auth()->user();
    $filePath = $request->file('business_permit')->store('business_permits', 'public');

    $landlord->update([
        'business_permit' => $filePath,
        'business_permit_status' => 'pending',
    ]);

    return back()->with('success', 'Business permit uploaded successfully. Awaiting verification.');
}
public function resend(Request $request)
{
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('verification.page')->with('success', 'Your email is already verified.');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('resent', true);
}
}
