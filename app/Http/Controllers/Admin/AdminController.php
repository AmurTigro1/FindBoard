<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Reservation;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\BusinessPermitStatusNotification;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
class AdminController extends Controller
{
    public function index()
    {
        // Fetch key metrics
        $totalRevenue = Subscription::where('status', 'active')->sum('amount_paid');
        $totalUsers = User::count();
        $totalListings = BoardingHouse::count();
        $pendingPermits = User::where('business_permit_status', 'pending')
        ->whereNotNull('phone_verified_at') // Exclude unverified users
        ->count();

    
        // Generate dynamic user growth and revenue data
        $userGrowth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');
    
        $revenueGrowth = Subscription::where('status', 'active')
            ->selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');
    
        // Prepare labels and data for the charts
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $userGrowthLabels = [];
        $userGrowthData = [];
        $revenueLabels = [];
        $revenueData = [];
    
        foreach ($months as $index => $month) {
            $userGrowthLabels[] = $month;
            $userGrowthData[] = $userGrowth->get($index + 1)->count ?? 0;
    
            $revenueLabels[] = $month;
            $revenueData[] = isset($revenueGrowth[$index + 1]) ? $revenueGrowth[$index + 1]->total / 100 : 0; // Convert cents to PHP
        }
    
        // Return data to the view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalListings' => $totalListings,
            'pendingPermits' => $pendingPermits,
            'revenue' => ['totalRevenue' => $totalRevenue / 100], // Convert cents to PHP
    
            'userGrowthLabels' => $userGrowthLabels,
            'userGrowthData' => $userGrowthData,
            'revenueLabels' => $revenueLabels,
            'revenueData' => $revenueData,
        ]);
    }
    
    
    public function createUser()
    {
        return view('admin.users.create');
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'], // Adjust regex for your needs
            'address' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
    
        return redirect()->route('admin.manage.users')
                         ->with('success', 'User added successfully!');
    }

    public function showUser($id)
{
    // Fetch the user along with their boarding houses and rooms
    $user = User::with('boardingHouses.rooms')->findOrFail($id);

    return view('admin.users.show', compact('user'));
}

    public function profile() {
        return view('admin.profile');
    }

    public function manageUsers(Request $request)
    {
        $users = User::all(); 
        $query = User::query();

    if ($request->has('search')) {
        $query->where('name', 'LIKE', '%' . $request->input('search') . '%')
              ->orWhere('email', 'LIKE', '%' . $request->input('search') . '%')
              ->orWhere('role', 'LIKE', '%' . $request->input('search') . '%');
    }

    $users = $query->paginate(10)->appends($request->except('page')); // 10 items per page
    $query = $request->has('search') ? null : $request->input('search');
        return view('admin.manage_users', compact('users'));
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');;
    }

    public function updateBusinessPermitStatus(Request $request, $id)
    {
        $landlord = User::findOrFail($id);
        $status = $request->input('status'); // 'approved' or 'rejected'

        $landlord->update([
            'business_permit_status' => $status,
        ]);

        $landlord->notify(new BusinessPermitStatusNotification($status));

        return back()->with('success', 'Business permit status updated successfully.');
    }

    // public function showPendingPermits()
    // {
    //     // Fetch all landlords with pending permits, ordered by newest first
    //     $landlords = User::where('business_permit_status', 'pending')
    //     ->whereNotIn('business_permit_status', ['new']) // Exclude new users
    //     ->orderBy('created_at', 'asc')
    //     ->get();

    //     return view('admin.pending-permits', compact('landlords'));
    // }
    
    public function showPendingPermits()
    {
        // Fetch landlords with pending permits, but exclude users who haven't verified their email
        $landlords = User::where('business_permit_status', 'pending')
                         ->whereNotNull('phone_verified_at') // Exclude unverified users
                         ->orderBy('created_at', 'asc')
                         ->get();
    
        return view('admin.pending-permits', compact('landlords'));
    }
    
    public function destroyBoardingHouse($id){
        $boardingHouse = BoardingHouse::find($id);
        $boardingHouse->delete();

        return redirect()->back()->with('success', 'Deleted successfully');;
    }

    public function manageListings(Request $request)
    {
        $listings = BoardingHouse::all();
        $query = BoardingHouse::query();

    if ($request->has('search')) {
        $query->where('name', 'LIKE', '%' . $request->input('search') . '%')
              ->orWhere('address', 'LIKE', '%' . $request->input('search') . '%')
              ->orWhere('gender', 'LIKE', '%' . $request->input('search') . '%');
    }

    $listings = $query->paginate(10)->appends($request->except('page')); // 10 items per page
    $query = $request->has('search') ? null : $request->input('search');
        return view('admin.manage_listings', compact('listings'));
    }

    
}
