<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BoardingHouseController extends Controller
{
    public function show(string $id)
    {
        $availableAmenities = Amenity::all();
        $boardingHouse = BoardingHouse::with(['amenities'])->findOrFail($id);
        // Check if the current user is the owner
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Pass the cover image and other images to the view
        return view('boarding_house.edit', [
            'boardingHouse' => $boardingHouse,
            'availableAmenities' => $availableAmenities,
            'amenities' => $boardingHouse->amenities,
        ]);
    }
    // public function viewHouses()
    // {
        
    //     $userId = Auth::id();
    //     $boardinghouses = BoardingHouse::select('id', 'name', 'address', 'gender')
    //         ->where('user_id', $userId)
    //         ->with(['images' => function($query) {
    //             $query->select('boarding_house_id', 'other_photo_path');
    //         }])
    //         ->latest()
    //         ->paginate(15);

    //     return view('boarding_house.view', [
    //         'boardinghouses' => $boardinghouses
    //     ]);
    // }

    //first attemt

    // public function viewHouses()
    // {
    //     $user = auth()->user();
    
    //     // Filter out boarding houses if the trial period has ended
    //     $boardinghouses = BoardingHouse::where('user_id', $user->id)
    //         ->when(
    //             $user->trial_ends_at && Carbon::now()->greaterThan($user->trial_ends_at),
    //             function ($query) {
    //                 $query->whereRaw('0 = 1'); // Exclude all results if the trial has ended
    //             }
    //         )
    //         ->with(['images' => function ($query) {
    //             $query->select('boarding_house_id', 'other_photo_path');
    //         }])
    //         ->latest()
    //         ->paginate(10);
    
    //     // Pass the filtered data to the view
    //     return view('boarding_house.view', [
    //         'boardinghouses' => $boardinghouses
    //     ]);
    // }

//2nd try
public function viewHouses()
    {
        $user = auth()->user();
    
        // Check if the user has an active subscription
        $hasActiveSubscription = $user->subscription 
            && $user->subscription->status == 'active' 
            && $user->subscription->end_date 
            && Carbon::now()->lessThanOrEqualTo($user->subscription->end_date);
    
        // Check if the trial has ended
        $trialEnded = $user->trial_ends_at && Carbon::now()->greaterThan($user->trial_ends_at);
    
        // If the user has an expired trial and no active subscription, return empty results
        if ($trialEnded && !$hasActiveSubscription) {
            return view('boarding_house.view', [
                'boardinghouses' => collect(), // Return empty collection
                'trialExpired' => true // Flag to show trial expired message
            ]);
        }
    
        // Fetch the user's boarding houses
        $boardinghouses = BoardingHouse::where('user_id', $user->id)
            ->when($trialEnded && !$hasActiveSubscription, function ($query) {
                // Exclude all results if the user has no active subscription and trial has ended
                $query->whereRaw('0 = 1');
            })
            ->with(['images' => function ($query) {
                $query->select('boarding_house_id', 'other_photo_path');
            }])
            ->latest()
            ->paginate(10);
    
        // Pass the filtered data to the view
        return view('boarding_house.view', [
            'boardinghouses' => $boardinghouses,
            'trialExpired' => $trialEnded, // Flag to show trial expired message
        ]);
    }

    // public function viewHouses()
    // {
    //     $user = auth()->user();
    
    //     // Check if the user has an active subscription
    //     $hasActiveSubscription = $user->subscription 
    //         && $user->subscription->status == 'active' 
    //         && $user->subscription->end_date 
    //         && Carbon::now()->lessThanOrEqualTo($user->subscription->end_date);
    
    //     // Check if the trial has ended
    //     $trialEnded = $user->trial_ends_at && Carbon::now()->greaterThan($user->trial_ends_at);
    
    //     // If the user has an expired trial and no active subscription, return empty results
    //     if ($trialEnded && !$hasActiveSubscription) {
    //         return view('boarding_house.view', [
    //             'boardinghouses' => collect(), // Return empty collection
    //             'trialExpired' => true // Flag to show trial expired message
    //         ]);
    //     }
    
    //     // Fetch the user's boarding houses
    //     $boardinghouses = BoardingHouse::where('user_id', $user->id)
    //         ->when($trialEnded && !$hasActiveSubscription, function ($query) {
    //             // Exclude all results if the user has no active subscription and trial has ended
    //             $query->whereRaw('0 = 1');
    //         })
    //         ->with(['images' => function ($query) {
    //             $query->select('boarding_house_id', 'other_photo_path');
    //         }])
    //         ->latest()
    //         ->paginate(10);
    
    //     // Pass the filtered data to the view
    //     return view('boarding_house.view', [
    //         'boardinghouses' => $boardinghouses,
    //         'trialExpired' => $trialEnded, // Flag to show trial expired message
    //     ]);
    // }
    

    

    // public function showHouse(string $id)
    // {
    //     $boardingHouse = BoardingHouse::with(['amenities'])->findOrFail($id);
    //     $rooms = $boardingHouse->rooms; // Assuming a relationship exists
    //     $reviews = $boardingHouse->reviews()->paginate(5);

    //     return view('boarding_house.show', [
    //         'boardingHouse' => $boardingHouse,
    //         'amenities' => $boardingHouse->amenities,
    //         'reviews' => $reviews,
    //         'rooms' => $rooms

    //     ]);
    // }
    public function showHouse(string $id)
    {
        
        $boardingHouse = BoardingHouse::with(['amenities', 'rooms', 'reviews', 'user'])->findOrFail($id);
     // Retrieve the owner (user) of the boarding house
     $owner = $boardingHouse->user; // assuming there's a 'user' relationship on the BoardingHouse model
        if (!$boardingHouse->latitude || !$boardingHouse->longitude) {
            return back()->with('error', 'Boarding house location is incomplete.');
        }
    
        $radius = 1000; // 1 km
        $nearbyBoardingHouses = BoardingHouse::selectRaw(
            "*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$boardingHouse->latitude, $boardingHouse->longitude, $boardingHouse->latitude]
        )
            ->having("distance", "<", $radius)
            ->where('id', '!=', $id) // Exclude the current boarding house
            ->orderBy("distance", "asc")
            ->get();
               // Count the available rooms for this boarding house
    $availableRoomsCount = $boardingHouse->rooms()->where('availability', 'available')->count();
    
        return view('boarding_house.show', [
            'boardingHouse' => $boardingHouse,
            'owner' => $owner,
            'amenities' => $boardingHouse->amenities,
            'reviews' => $boardingHouse->reviews()->paginate(5),
            'rooms' => $boardingHouse->rooms,
            'nearbyBoardingHouses' => $nearbyBoardingHouses,
            'availableRoomsCount' => $availableRoomsCount, // Pass the count to the view
        ]);
    }
    
    public function seeMore(Request $request)
    {
        $query = BoardingHouse::select('id', 'name', 'address', 'gender', 'description')
            ->with(['images' => function($query) {
                $query->select('boarding_house_id', 'other_photo_path');
            }]);
    
        // Filter by Gender Preference
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }
    
        // Filter by Rating (if provided)
        if ($request->has('rating') && $request->rating != '') {
            $rating = $request->rating;
            $query->whereHas('reviews', function($q) use ($rating) {
                $q->havingRaw('AVG(rating) >= ?', [$rating]);
            });
        }
    
        $bh = $query->orderBy('name', 'asc')->paginate(15);
    
        return view('boarding_house.see_more', compact('bh'));
    }
    

    public function listingGuide() {
        $userId = Auth::id();
        $bh = BoardingHouse::select('id', 'name', 'address', 'gender')
            ->where('user_id', $userId)
            ->with(['images' => function($query) {
                $query->select('boarding_house_id', 'other_photo_path');
            }])
            ->latest()
            ->paginate(15);
        return view('boarding_house.guide', compact('bh'));
    }

    public function create()
    {
        return view('boarding_house.create'); 
    }
//Original store function
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'address' => 'required|string',
    //         'maplink' => 'nullable|string',
    //         'description' => 'nullable|string',
    //         'policies' => 'nullable|string',
    //         'gender' => 'required|in:male only,female only,male and female',
    //         'bathrooms' => 'nullable|integer|min:0',
    //         'wifi' => 'boolean',
    //         'cctv' => 'boolean',
    //         'kitchen_use' => 'boolean',
    //         'laundry_facilities' => 'boolean',
    //         'storage_spaces' => 'boolean',
    //         'air_conditioning' => 'boolean',
    //         'parking_area' => 'boolean',
    //         'pet_friendly' => 'boolean',
    //         'study_area' => 'boolean',
    //         'outdoor_space' => 'boolean',
    //         //rooms
            
    //     ]);

    //     // Create the boarding house
    //     $boardingHouse = BoardingHouse::create([
    //         'user_id' => Auth::id(),
    //         'name' => $request->name,
    //         'address' => $request->address,
    //         'maplink' => $request->maplink,
    //         'description' => $request->description,
    //         'policies' => $request->policies,
    //         'gender' => $request->gender,
    //     ]);

    //     // Create the amenities
    //     Amenity::create([
    //         'boarding_house_id' => $boardingHouse->id,
    //         'bathrooms' => $request->bathrooms,
    //         'wifi' => $request->has('wifi'),
    //         'cctv' => $request->has('cctv'),
    //         'kitchen_use' => $request->has('kitchen_use'),
    //         'laundry_facilities' => $request->has('laundry_facilities'),
    //         'cabinet' => $request->has('cabinet'),
    //         'chair' => $request->has('chair'),
    //         'table' => $request->has('table'),
    //         'air_conditioning' => $request->has('air_conditioning'),

    //     ]);

     
    //         return redirect()->route('boarding_house.edit', ['id' =>$boardingHouse->id])
    //         ->with('success', 'Boarding house created successfully.');
    // }

//sample store function orig
// public function store(Request $request)
// {
//     $rules = [
//         'name' => 'required|string|max:255',
//         'address' => 'required|string',
//         'maplink' => 'nullable|string',
//         'description' => 'nullable|string',
//         'policies' => 'nullable|string',
//         'gender' => 'required|in:male only,female only,male and female',
//         'bathrooms' => 'nullable|integer|min:0',
//         'wifi' => 'nullable|string|in:available,shared,in-room',
//         'refrigerator' => 'nullable|string|in:available,shared,personal',
//         'electric_bill' => 'nullable|string|in:separate,shared',
//         'water_bill' => 'nullable|string|in:separate,shared',
//         'cctv' => 'nullable|string|in:available,shared,in-room',
//         'kitchen' => 'nullable|string|in:available,shared,in-room',
//         'laundry_service' => 'nullable|string|in:available,shared,in-room',
//     ];

//     $request->validate($rules);

//     $boardingHouse = BoardingHouse::create([
//         'user_id' => Auth::id(),
//         'name' => $request->name,
//         'address' => $request->address,
//         'maplink' => $request->maplink,
//         'description' => $request->description,
//         'policies' => $request->policies,
//         'gender' => $request->gender,
//     ]);

//     $amenities = [
//         'wifi' => $request->wifi,
//         'refrigerator' => $request->refrigerator ?? 'available',
//         'electric_bill' => $request->electric_bill ?? 'separate',
//         'water_bill' => $request->water_bill ?? 'shared',
//         'cctv' => $request->cctv,
//         'kitchen' => $request->kitchen,
//         'laundry_service' => $request->laundry_service,
//     ];

//     Amenity::create(array_merge(['boarding_house_id' => $boardingHouse->id], $amenities));

//     return redirect()->route('boarding_house.edit', $boardingHouse->id)
//         ->with('success', 'Boarding house created successfully.');
// }

public function store(Request $request)
{
    //  // Get the currently authenticated user's ID
    //  $userId = Auth::id();

    //  // Check if the user has already listed a boarding house
    //  $existingBoardingHouseCount = BoardingHouse::where('user_id', $userId)->count();
 
    //  // Check if the user has an active subscription
    //  $user = Auth::user();
    //  $hasSubscription = $user->subscription_active ?? false; // Assuming 'subscription_active' is a boolean column
 
    //  // Restrict the user to posting only one free boarding house
    //  if ($existingBoardingHouseCount >= 1 && !$hasSubscription) {
    //      return redirect()->back()->withErrors([
    //          'error' => 'You can only list one boarding house for free. Please subscribe to post more.',
    //      ]);
    //  }
    $user = Auth::user();

    // Check if the user has an active subscription
    $subscription = $user->subscription; // Assuming you have a relationship defined

    if ($subscription) {
        // Subscription is active, apply subscription limits
        $maxBoardingHouses = $subscription->max_boarding_houses;
        $currentBoardingHouses = $user->boardingHouses()->count();

        if ($currentBoardingHouses >= $maxBoardingHouses) {
            return redirect()->back()->withErrors(['error' => 'You have reached the maximum number of boarding houses allowed by your subscription plan.']);
        }
    } else {
        // No active subscription, check trial period restrictions
        if ($user->trial_ends_at && Carbon::now()->lessThanOrEqualTo($user->trial_ends_at)) {
            if ($user->boardingHouses()->count() >= 1) {
                return redirect()->back()->withErrors(['error' => 'You can only create 1 boarding house during your trial period.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Your free trial has expired. Please subscribe to create more boarding houses.']);
        }
    }

    $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'maplink' => 'nullable|string',
        'description' => 'nullable|string',
        'policies' => 'nullable|string',
        'gender' => 'required|in:male only,female only,male and female',
        'bathrooms' => 'nullable|integer|min:0',
        'wifi' => 'nullable|string|in:available,shared,in-room,not-available',
        'refrigerator' => 'nullable|string|in:available,shared,in-room,not-available',
        'electric_bill' => 'nullable|string|in:separate,shared,not-available',
        'water_bill' => 'nullable|string|in:separate,shared,not-available',
        'cctv' => 'nullable|string|in:available,shared,in-room,not-available',
        'kitchen' => 'nullable|string|in:available,shared,in-room,not-available',
        'laundry_service' => 'nullable|string|in:available,shared,in-room,not-available',
        // 'curfew' => 'required|regex:/^(0?[1-9]|1[0-2]):([0-5][0-9]) (AM|PM)$/i',
        'facebook_link' => 'required|string',
        
        // 'latitude' => 'required|numeric',
        // 'longitude' => 'required|numeric',
    ];
    $curfewTime = Carbon::createFromFormat('h:i A', $request->curfew)->format('H:i');
    $request->validate($rules);

    $boardingHouse = BoardingHouse::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'address' => $request->address,
        'maplink' => $request->maplink,
        'description' => $request->description,
        'policies' => $request->policies,
        'gender' => $request->gender,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'curfew' => $curfewTime,
        'facebook_link' => $request->facebook_link,
    ]);

    $amenities = [
        'bathrooms' => $request->bathrooms,
        'wifi' => $request->wifi,
        'refrigerator' => $request->refrigerator ?? 'available',
        'electric_bill' => $request->electric_bill ?? 'separate',
        'water_bill' => $request->water_bill ?? 'shared',
        'cctv' => $request->cctv,
        'kitchen' => $request->kitchen,
        'laundry_service' => $request->laundry_service,
    ];

    Amenity::create(array_merge(['boarding_house_id' => $boardingHouse->id], $amenities));

    return redirect()->route('boarding_house.edit', $boardingHouse->id)
        ->with('success', 'Boarding house created successfully.');
}




    public function updateInfo($id, Request $request)
    {
        $boardingHouse = BoardingHouse::findOrFail($id);

        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'maplink' => 'nullable|url',
            'gender' => 'required|string|in:male only,female only,male and female',
        ]);

        // Update the house
        $boardingHouse->update($validatedData);

        return redirect()->route('boarding_house.edit', $boardingHouse->id)
            ->with('success', 'Boarding house updated successfully.');
    }


    public function updatePolicies($id, Request $request)
    {
        $house = BoardingHouse::findOrFail($id);

        if ($house->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $validator = Validator::make($request->all(), [
            'policies' => 'nullable|string',
        ]);

        if ($validator->passes()) {
            $house->policies = $request->policies;
            $house->save();

            return redirect()->route('boarding_house.edit', $id)
                ->with('success', 'Policy updated successfully.');
        } else {
            return redirect()->route('boarding_house.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function updateDescription($id, Request $request)
    {
        // Retrieve the boarding house instance
        $boardingHouse = BoardingHouse::findOrFail($id);

        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Validate the input
        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string',
        ]);

        if ($validator->passes()) {
            // Update the description
            $boardingHouse->description = $request->description;
            $boardingHouse->save();

            return redirect()->route('boarding_house.edit', $id)
                ->with('success', 'Description updated successfully.');
        } else {
            return redirect()->route('boarding_house.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function updateAmenities(Request $request, $id)
    {
        // Retrieve the boarding house and validate ownership
        $boardingHouse = BoardingHouse::findOrFail($id);
        if ($boardingHouse->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
    
        // Validate request data
        // $validator = Validator::make($request->all(), [
        //     'bathrooms' => 'nullable|integer|min:0',
        //     'wifi' => 'nullable|string|in:available,shared,in-room',
        //     'cctv' => 'nullable|string|in:available,shared,in-room',
        //     'electric_bill' => 'nullable|string|in:separate,shared',
        //     'water_bill' => 'nullable|string|in:separate,shared',
        //     'refrigerator' => 'nullable|string|in:available,shared,personal',
        //     'kitchen' => 'nullable|string|in:available,shared,in-room',
        //     'laundry_service' => 'nullable|string|in:available,shared,in-room',
        // ]);
    
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
    
        // Update amenities with fallback defaults
        $amenities = $boardingHouse->amenities;
        $defaultAmenities = [
            'wifi' => 'available',
            'cctv' => 'available',
            'electric_bill' => 'separate',
            'water_bill' => 'shared',
            'refrigerator' => 'available',
            'kitchen' => 'available',
            'laundry_service' => 'available',
            'air_conditioning' => 'available',
        ];
    
        $amenities->update([
            'bathrooms' => $request->bathrooms ?? $amenities->bathrooms,
            'wifi' => $request->wifi ?? $defaultAmenities['wifi'],
            'cctv' => $request->cctv ?? $defaultAmenities['cctv'],
            'electric_bill' => $request->electric_bill ?? $defaultAmenities['electric_bill'],
            'water_bill' => $request->water_bill ?? $defaultAmenities['water_bill'],
            'refrigerator' => $request->refrigerator ?? $defaultAmenities['refrigerator'],
            'kitchen' => $request->kitchen ?? $defaultAmenities['kitchen'],
            'air_conditioning' => $request->air_conditioning ?? $defaultAmenities['air_conditioning'],
            'laundry_service' => $request->laundry_service ?? $defaultAmenities['laundry_service'],
        ]);
    
        // Redirect with success message
        return redirect()
            ->route('boarding_house.edit', $boardingHouse->id)
            ->with('success', 'Amenities updated successfully.');
    }
    
    
}
