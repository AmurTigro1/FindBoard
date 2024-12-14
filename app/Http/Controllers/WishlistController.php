<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
    
        // Fetch only the boarding houses in the user's wishlist
        $bh = BoardingHouse::select('id', 'name', 'address', 'gender', 'description')
            ->with([
                'images' => function ($query) {
                    $query->select('boarding_house_id', 'other_photo_path');
                }
            ])
            ->whereHas('wishlists', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('name', 'asc')
            ->get(); // Fetch all wishlist items for simplicity, not paginated
    
        return view('wishlist.index', compact('bh'));
    }
    

    public function store(Request $request)
    {
        $user = auth()->user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $boardingHouseId = $request->boarding_house_id;
    
        // Check if this boarding house is already in the user's wishlist
        $wishlist = $user->wishlists()->where('boarding_house_id', $boardingHouseId)->first();
    
        if ($wishlist) {
            // Remove from wishlist
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Add to wishlist
            $user->wishlists()->create(['boarding_house_id' => $boardingHouseId]);
            return response()->json(['status' => 'added']);
        }
    }
    
    
    
    public function add($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $house = BoardingHouse::findOrFail($id);

        $wishlist = new Wishlist();
        $wishlist->user_id = auth()->id();
        $wishlist->boarding_house_id = $id;
        $wishlist->save();

        return response()->json(['message' => 'Added to the wishlist']);
    }

    public function remove($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('boarding_house_id', $id)
            ->firstOrFail();
        $wishlist->delete();

        return response()->json(['message' => 'Removed from the wishlist']);
    }
    
    public function destroy($boardingHouseId)
{
    $userId = Auth::id();

    // Find the wishlist entry and delete it
    $wishlist = Wishlist::where('user_id', $userId)
        ->where('boarding_house_id', $boardingHouseId)
        ->first();

    if ($wishlist) {
        $wishlist->delete();
        return response()->json(['success' => true], 200);
    }

    return response()->json(['error' => 'Boarding house not found in wishlist'], 404);
}

}
