<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function storeImages(Request $request, $boardingHouseId)
    {
        // Validate the request input, including the images
        $validator = Validator::make($request->all(), [
            'other_photo_path.*' => 'nullable|image|mimes:jpg,png,jpeg|max:20480',
        ]);

        if ($validator->passes()) {
            // Get the specific boarding house
            $boardingHouse = BoardingHouse::findOrFail($boardingHouseId);

            // Handle the file upload for other photos
            if ($request->hasFile('other_photo_path')) {
                foreach ($request->file('other_photo_path') as $photo) {
                    // Store the photo in the 'public' disk under 'boarding-houses/photos'
                    $photoPath = $photo->store('house-images', 'public');

                    // Save the image path in the database
                    $boardingHouse->images()->create([
                        'boarding_house_id' => $boardingHouse->id,
                        'other_photo_path' => $photoPath, // Store path in the 'other_photo_path' column
                    ]);
                }
            }

            return back()->with('success', 'Photos uploaded successfully!');
        } else {
            return back()->withInput()->withErrors($validator);
        }
    }
}