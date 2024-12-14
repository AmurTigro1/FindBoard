<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\BoardingHouse;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Fetch paginated rooms
    //     $rooms = Room::with('boardingHouse')->paginate(6);
    
    //     // Fetch boarding houses. This is fo the homepage that shows all the boaring houses available
    //     $bh = BoardingHouse::select('id', 'name', 'address', 'gender', 'description', 'curfew')
    //         ->with(['images' => function ($query) {
    //             $query->select('boarding_house_id', 'other_photo_path');
    //         }])
    //         ->orderBy('name', 'asc')
    //         ->paginate(15);
    
    //     // Fetch nearest boarding houses if location is provided
    //     $userLat = $request->input('lat');
    //     $userLon = $request->input('lon');
    
    //     $nearby = collect();
    
    //     if ($userLat && $userLon) {
    //         $nearby = BoardingHouse::with('images')
    //             ->get()
    //             ->map(function ($house) use ($userLat, $userLon) {
    //                 $house->distance = $this->calculateDistance($userLat, $userLon, $house->latitude, $house->longitude);
    //                 return $house;
    //             })
    //             ->filter(function ($house) {
    //                 return $house->distance !== null; // Filter out entries with invalid coordinates
    //             })
    //             ->sortBy('distance')
    //             ->take(6); // Limit to 6 results
    //     }
    
    //     \Log::info('Fetched nearest boarding houses:', $nearby->toArray());
    
    //     // Pass data to the view
    //     return view('all_user_homepage.index', [
    //         'bh' => $bh,
    //         'rooms' => $rooms,
    //         'nearby' => $nearby, // Pass as 'nearby'
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     // Fetch paginated rooms, but only for boarding houses with active trials
    //     $rooms = Room::with('boardingHouse')
    //         ->whereHas('boardingHouse.user', function ($query) {
    //             $query->where(function ($query) {
    //                 $query->whereNull('trial_ends_at')
    //                       ->orWhere('trial_ends_at', '>', Carbon::now());
    //             });
    //         })
    //         ->paginate(6);
    
    //     // Fetch boarding houses for the homepage, excluding those owned by users with expired trials
    //     $bh = BoardingHouse::select('id', 'name', 'address', 'gender', 'description', 'curfew')
    //         ->with(['images' => function ($query) {
    //             $query->select('boarding_house_id', 'other_photo_path');
    //         }])
    //         ->whereHas('user', function ($query) {
    //             $query->where(function ($query) {
    //                 $query->whereNull('trial_ends_at')
    //                       ->orWhere('trial_ends_at', '>', Carbon::now());
    //             });
    //         })
    //         ->orderBy('name', 'asc')
    //         ->paginate(15);
    
    //     // Fetch nearest boarding houses if location is provided
    //     $userLat = $request->input('lat');
    //     $userLon = $request->input('lon');
    
    //     $nearby = collect();
    
    //     if ($userLat && $userLon) {
    //         $nearby = BoardingHouse::with('images')
    //             ->get()
    //             ->map(function ($house) use ($userLat, $userLon) {
    //                 $house->distance = $this->calculateDistance($userLat, $userLon, $house->latitude, $house->longitude);
    //                 return $house;
    //             })
    //             ->filter(function ($house) {
    //                 return $house->distance !== null; // Filter out entries with invalid coordinates
    //             })
    //             ->sortBy('distance')
    //             ->take(6); // Limit to 6 results
    //     }
    
    //     \Log::info('Fetched nearest boarding houses:', $nearby->toArray());
    
    //     // Pass data to the view
    //     return view('all_user_homepage.index', [
    //         'bh' => $bh,
    //         'rooms' => $rooms,
    //         'nearby' => $nearby, // Pass as 'nearby'
    //     ]);
    // }
    

    // public function index(Request $request)
    // {
    //     // Fetch boarding houses with their rooms
    //     $bh = BoardingHouse::select('id', 'name', 'address', 'gender', 'description', 'curfew')
    //         ->with([
    //             'images' => function ($query) {
    //                 $query->select('boarding_house_id', 'other_photo_path');
    //             },
    //             'rooms' => function ($query) {
    //                 $query->select('id', 'type', 'price', 'boarding_house_id', 'description', 'main_images');
    //             }
    //         ])
    //         ->whereHas('user', function ($query) {
    //             $query->where(function ($query) {
    //                 $query->whereNull('trial_ends_at')
    //                       ->orWhere('trial_ends_at', '>', Carbon::now())
    //                       ->orWhereHas('subscription', function ($query) {
    //                           $query->where('status', 'active')
    //                                 ->where('end_date', '>=', Carbon::now());
    //                       });
    //             });
    //         })
    //         ->orderBy('name', 'asc')
    //         ->paginate(15);
    
    //     // Flatten and paginate rooms
    //     $rooms = collect($bh->items())->flatMap->rooms;
    
    //     // Manual pagination for rooms
    //     $perPage = 6; // Customize per page
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //     $paginatedRooms = new LengthAwarePaginator(
    //         $rooms->forPage($currentPage, $perPage), // Slice collection
    //         $rooms->count(), // Total items
    //         $perPage, // Per page
    //         $currentPage, // Current page
    //         ['path' => LengthAwarePaginator::resolveCurrentPath()] // Pagination path
    //     );
    
    //     // Pass data to the view
    //     return view('all_user_homepage.index', [
    //         'bh' => $bh,
    //         'rooms' => $paginatedRooms, // Use paginated rooms
    //     ]);
    // }
    public function index(Request $request)
{
    // Fetch boarding houses with their rooms, considering active trials or subscriptions
    $bh = BoardingHouse::select('id', 'name', 'address', 'gender', 'description', 'curfew')
        ->with([
            'images' => function ($query) {
                $query->select('boarding_house_id', 'other_photo_path');
            },
            'rooms' => function ($query) {
                $query->select('id', 'type', 'price', 'boarding_house_id', 'description', 'main_images');
            }
        ])
        ->whereHas('user', function ($query) {
            $query->where(function ($query) {
                $query->whereNull('trial_ends_at') // Users without trials
                      ->orWhere('trial_ends_at', '>', Carbon::now()) // Active trials
                      ->orWhereHas('subscription', function ($query) { // Active subscriptions
                          $query->where('status', 'active')
                                ->where('end_date', '>=', Carbon::now());
                      });
            });
        })
        ->withCount(['rooms as available_rooms_count' => function ($query) {
            $query->where('availability', 'available');
        }]) // Count only available rooms
        ->orderBy('name', 'asc')
        ->paginate(15);
    // Flatten rooms from all boarding houses
    $rooms = $bh->getCollection()->flatMap->rooms;

    // Paginate rooms manually
    $perPage = 6; // Customize items per page
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $paginatedRooms = new LengthAwarePaginator(
        $rooms->forPage($currentPage, $perPage), // Paginate the flattened collection
        $rooms->count(), // Total rooms count
        $perPage, // Rooms per page
        $currentPage, // Current page
        ['path' => $request->url()] // Pagination path
    );

    // Pass data to the view
    return view('all_user_homepage.index', [
        'bh' => $bh,
        'rooms' => $paginatedRooms, // Paginated rooms
    ]);
}

    
    
// Helper method to calculate distance
private function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    if (!$lat2 || !$lon2) {
        return null; // Return null if coordinates are invalid
    }

    $earthRadius = 6371; // Radius in km

    $latDiff = deg2rad($lat2 - $lat1);
    $lonDiff = deg2rad($lon2 - $lon1);

    $a = sin($latDiff / 2) * sin($latDiff / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($lonDiff / 2) * sin($lonDiff / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}


//     public function dashboard(Request $request)
// {
//     $bh = BoardingHouse::all(); 
//     $query = BoardingHouse::query();
//     // Filter by address
//     if ($request->filled('address')) {
//         $query->where('address', 'like', '%' . $request->address . '%');
//     }

//     // Filter by gender preference
//     if ($request->filled('gender_preference')) {
//         $query->where('gender_preference', $request->gender_preference);
//     }

//     // Filter by price range (assuming price is in related "rooms" table)
//     if ($request->filled('price_min') || $request->filled('price_max')) {
//         $query->whereHas('rooms', function($q) use ($request) {
//             $q->whereBetween('price', [
//                 $request->price_min ?? 0,
//                 $request->price_max ?? PHP_INT_MAX
//             ]);
//         });
//     }

//     // Paginate the filtered results
//     $bh = $query->paginate(10);

//     // Pass search parameters to view
//     return view('all_user_homepage.index', [
//         'bh' => $bh,
//         'searchAddress' => $request->address,
//         'searchGender' => $request->gender_preference,
//         'priceMin' => $request->price_min,
//         'priceMax' => $request->price_max,
//     ]);
// }
public function dashboard(Request $request)
{
  // Fetch paginated rooms
  $rooms = Room::with('boardingHouse')->paginate(6);
    
  // Fetch boarding houses
  $bh = BoardingHouse::select('id', 'name', 'address', 'gender', 'description')
      ->with(['images' => function ($query) {
          $query->select('boarding_house_id', 'other_photo_path');
      }])
      ->orderBy('name', 'asc')
      ->paginate(15);

  // Fetch nearest boarding houses if location is provided
  $userLat = $request->input('lat');
  $userLon = $request->input('lon');

  $nearby = collect();

  if ($userLat && $userLon) {
      $nearby = BoardingHouse::with('images')
          ->get()
          ->map(function ($house) use ($userLat, $userLon) {
              $house->distance = $this->calculateDistance($userLat, $userLon, $house->latitude, $house->longitude);
              return $house;
          })
          ->filter(function ($house) {
              return $house->distance !== null; // Filter out entries with invalid coordinates
          })
          ->sortBy('distance')
          ->take(6); // Limit to 6 results
  }

  \Log::info('Fetched nearest boarding houses:', $nearby->toArray());

  // Pass data to the view
  return view('all_user_homepage.index', [
      'bh' => $bh,
      'rooms' => $rooms,
      'nearby' => $nearby, // Pass as 'nearby'
  ]);
}

    public function search(Request $request)
{
    $bh = BoardingHouse::all(); 
    $query = BoardingHouse::query();
    // Filter by address
    if ($request->filled('address')) {
        $query->where('address', 'like', '%' . $request->address . '%');
    }

    $bh = $query->paginate(10);

    return view('boarding_house.see_more', [
        'bh' => $bh,
        'searchAddress' => $request->address,
    ]);
}
public function searchAndFilter(Request $request)
{
    $query = BoardingHouse::select('id', 'name', 'address', 'gender', 'description')
        ->with(['images' => function ($query) {
            $query->select('boarding_house_id', 'other_photo_path');
        }]);

    if ($request->filled('address')) {
        $query->where('address', 'like', '%' . $request->address . '%');
    }

    if ($request->has('gender') && $request->gender != '') {
        $query->where('gender', $request->gender);
    }

    if ($request->has('rating') && $request->rating != '') {
        $rating = $request->rating;
        $query->whereHas('reviews', function ($q) use ($rating) {
            $q->havingRaw('AVG(rating) >= ?', [$rating]);
        });
    }

    $bh = $query->orderBy('name', 'asc')->paginate(15);

    if ($request->ajax()) {
        return view('boarding_house.partials.results', compact('bh'))->render();
    }

    return view('boarding_house.see_more', compact('bh'));
}

public function getNearestBoardingHouses(Request $request) {
    $userLat = $request->input('lat');
    $userLon = $request->input('lon');

    if ($userLat && $userLon) {
        // Fetch all boarding houses and calculate the distance
        $bh = BoardingHouse::all()->map(function ($boardingHouse) use ($userLat, $userLon) {
            $distance = $this->calculateDistance($userLat, $userLon, $boardingHouse->latitude, $boardingHouse->longitude);
            $boardingHouse->distance = $distance;
            return $boardingHouse;
        })->sortBy('distance')->values(); // Sort by distance and reindex the array

        return response()->json($bh);
    }

    return response()->json([]); // Return empty array if no coordinates
}

}
