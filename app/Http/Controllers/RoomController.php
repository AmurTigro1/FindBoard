<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\RoomAmenity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
     // Show all rooms for a specific boarding house
     public function index(BoardingHouse $boardingHouse)
     {
         // Fetch the rooms associated with the boarding house
         $rooms = $boardingHouse->rooms()->get();
 
         // Pass the rooms and boarding house data to the view
         return view('boarding_house.rooms.index', [
             'boardingHouse' => $boardingHouse,
             'rooms' => $rooms
         ]);
     }
    //  public function roomHomepage()
    //  {
    //      // Fetch all rooms with related boarding house details and images
    //      $rooms = Room::with('boardingHouse')->get();
 
    //      // Return the view with the rooms data
    //      return view('all_rooms.homepage', compact('rooms'));
    //  }
    // public function allRooms(Request $request)
    // {
    //     $query = \DB::table('rooms')
    //         ->join('room_amenities', 'rooms.id', '=', 'room_amenities.room_id')
    //         ->select('rooms.*', 'room_amenities.*'); // Select room and amenities
    
    //     // Apply filters based on amenities
    //     if ($request->has('amenities')) {
    //         $amenities = $request->input('amenities');
    
    //         foreach ($amenities as $amenity) {
    //             $query->where("room_amenities.$amenity", true);
    //         }
    //     }
    
    //     $rooms = $query->get(); // Fetch rooms
    
    //     return view('all_rooms.index', compact('rooms'));
    // }
    public function allRooms(Request $request)
{
    $query = \DB::table('rooms')
        ->join('room_amenities', 'rooms.id', '=', 'room_amenities.room_id')
        ->join('boarding_houses', 'rooms.boarding_house_id', '=', 'boarding_houses.id') // Join boarding_houses
        ->join('users', 'boarding_houses.user_id', '=', 'users.id') // Join users table to check trial status
        ->select('rooms.*', 'room_amenities.*', 'boarding_houses.user_id', 'users.trial_ends_at'); // Select room, amenities, and trial_ends_at

    // Apply filters based on amenities
    if ($request->has('amenities')) {
        $amenities = $request->input('amenities');
        foreach ($amenities as $amenity) {
            $query->where("room_amenities.$amenity", true);
        }
    }

    // Exclude rooms from users whose trial has ended
    $query->where(function($query) {
        $query->whereNull('users.trial_ends_at') // Include users with no trial period
              ->orWhere('users.trial_ends_at', '>', Carbon::now()); // Include users whose trials are still active
    });

    // Fetch rooms
    $rooms = $query->get();

    return view('all_rooms.index', compact('rooms'));
}

    
     
     public function filter(Request $request)
     {
         $amenities = $request->input('amenities', []);
         $rooms = Room::whereHas('roomAmenities', function ($query) use ($amenities) {
             foreach ($amenities as $amenity) {
                 $query->where($amenity, true);
             }
         })->with('boardingHouse')->get();
     
         return view('all_rooms.index', compact('rooms'))->with('isFiltered', true);
     }
     
    public function store(Request $request, $boardingHouseId)
{
    // Validate the room data
    $request->validate([
        'type' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'number_of_beds' => 'required|integer|min:1',
        'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png,avif,webp|max:2048',
        'main_images' => 'nullable|array',
        'main_images.*' => 'nullable|image|mimes:jpg,jpeg,png,avif,webp|max:2048',
        'availability' => 'nullable|in:available,not_available',
        'availability_date' => 'nullable|date',
        'description' => 'nullable|string',
        'occupancy' => 'nullable|integer|min:1',
        'wifi' => 'nullable|boolean',
        'cabinet' => 'nullable|boolean',
        'chair' => 'nullable|boolean',
        'table' => 'nullable|boolean',
        'air_conditioning' => 'nullable|boolean',
        'electric_fan' => 'nullable|boolean',
    ]);
    
     // Find the BoardingHouse
    $boardingHouse = BoardingHouse::findOrFail($boardingHouseId);

    // Get the current user and their subscription
    $user = Auth::user();
    $subscription = $user->subscription; // Assuming the `subscription` relationship retrieves the latest active subscription

    // Subscription Logic
    if ($subscription) {
        // Use the subscription's max room limit
        $maxRooms = $subscription->max_rooms;
        $existingRoomsCount = $boardingHouse->rooms()->count();

        if ($existingRoomsCount >= $maxRooms) {
            return back()->withErrors('You have reached the maximum number of rooms allowed by your subscription plan.');
        }
    } else {
        // Trial Period Logic
        if ($user->trial_ends_at && Carbon::now()->lessThanOrEqualTo($user->trial_ends_at)) {
            // During the trial, limit to 1 room per boarding house
            if ($boardingHouse->rooms()->count() >= 1) {
                return back()->withErrors('You can only create 1 room in your boarding house during your trial period.');
            }
        } else {
            // If trial expired and no subscription, block the action
            return back()->withErrors('Your trial has expired. Please subscribe to add more rooms.');
        }
    }

    // Create the room
    $room = $boardingHouse->rooms()->create([
        'type' => $request->type,
        'price' => $request->price,
        'number_of_beds' => $request->number_of_beds,
        'occupancy' => $request->occupancy,
        'thumbnail_image' => $request->hasFile('thumbnail_image') 
            ? $request->file('thumbnail_image')->store('room_thumbnails', 'public') 
            : null,
        'main_images' => $request->hasFile('main_images') 
            ? json_encode(array_map(fn($image) => $image->store('room_images', 'public'), $request->file('main_images'))) 
            : null,
        'availability' => $request->availability ?? 'available',
        'availability_date' => $request->availability_date,
        'description' => $request->description,
    ]);

    // Create the amenities record
    $room->roomAmenity()->create([
        'wifi' => $request->wifi ?? false,
        'cabinet' => $request->cabinet ?? false,
        'chair' => $request->chair ?? false,
        'table' => $request->table ?? false,
        'air_conditioning' => $request->air_conditioning ?? false,
        'electric_fan' => $request->electric_fan ?? false,
    ]);
    
    return redirect()
        ->route('boarding_house-rooms.index', $boardingHouse->id)
        ->with('room', $room)
        ->with('success', 'Room added successfully.');
}

    

    public function show($roomId)
    {
        $room = Room::with('roomAmenity', 'boardingHouse')->findOrFail($roomId);
        $boardingHouse = $room->boardingHouse; // Retrieve the related boarding house
    
        return view('rooms.show', compact('room', 'boardingHouse'));
    }  

        public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }
    public function update(Request $request, $id)
{
    $room = Room::findOrFail($id);

    $request->validate([
        'type' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'number_of_beds' => 'required|integer|min:1',
        'occupancy' => 'required|integer|min:1',
        'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'main_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'availability' => 'nullable|in:available,not_available',
        'available_date' => 'nullable|date', 
        'description' => 'nullable|string',
    ]);

    $room->type = $request->type;
    $room->price = $request->price;
    $room->number_of_beds = $request->number_of_beds;
    $room->availability = $request->availability ?? 'available';
    $room->description = $request->description;
    $room->occupancy = $request->occupancy;

       // Handle available_date when availability is 'not_available'
       if ($request->availability === 'not_available') {
        $room->available_date = $request->available_date;
    } else {
        // Clear the date if the room is 'available'
        $room->available_date = null;
    }

    if ($request->hasFile('thumbnail_image')) {
        $room->thumbnail_image = $request->file('thumbnail_image')->store('room_thumbnails', 'public');
    }

    if ($request->hasFile('main_images')) {
        $room->main_images = json_encode(array_map(fn($image) => $image->store('room_images', 'public'), $request->file('main_images')));
    }

    $room->save();

    return redirect()->route('boarding_house-rooms.index', $room->boarding_house_id)
        ->with('success', 'Room updated successfully.');
}

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->back()->with('success', 'Room deleted successfully.');
    }

}
