<?php

namespace App\Http\Controllers;

use App\Mail\ReservationNotification;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

// use Barryvdh\DomPDF\Facade\PDF;
class ReservationController extends Controller
{//ORIG
//     public function index(Request $request)
// {
//     $query = Reservation::query();

//     // Search functionality
//     if ($request->has('search') && $request->search) {
//         $query->where('name', 'like', '%' . $request->search . '%')
//               ->orWhere('room_id', 'like', '%' . $request->search . '%')
//               ->orWhere('status', 'like', '%' . $request->search . '%')
//               ->orWhere('visit_time', 'like', '%' . $request->search . '%');
//     }

//     // Filter by 'pending' status
//     $query->where('status', 'pending');

//     // Paginate results (10 per page)
//     $reservations = $query->paginate(10);

//     return view('owner.reservations.index', compact('reservations'));
// }
//2nd
// public function index(Request $request)
// {
//     // Get the current logged-in user
//     $userId = auth()->id();

//     // Retrieve reservations for rooms owned by the logged-in user
//     $query = Reservation::whereHas('room', function ($query) use ($userId) {
//         $query->where('user_id', $userId);
//     });

//     // Search functionality
//     if ($request->has('search') && $request->search) {
//         $query->where(function ($subQuery) use ($request) {
//             $subQuery->where('name', 'like', '%' . $request->search . '%')
//                      ->orWhere('email', 'like', '%' . $request->search . '%')
//                      ->orWhere('room_id', 'like', '%' . $request->search . '%')
//                      ->orWhere('status', 'like', '%' . $request->search . '%')
//                      ->orWhere('visit_time', 'like', '%' . $request->search . '%');
//         });
//     }

//     // Filter by 'pending' status
//     $query->where('status', 'pending');

//     // Paginate results (10 per page)
//     $reservations = $query->paginate(10);

//     return view('owner.reservations.index', compact('reservations'));
// }

public function index(Request $request)
{
    // Get the current logged-in user's ID
    $ownerId = auth()->id();

    // Retrieve reservations related to the logged-in user's boarding houses and rooms
    $query = Reservation::with(['user', 'room.boardingHouse'])
        ->whereHas('room.boardingHouse', function ($query) use ($ownerId) {
            $query->where('user_id', $ownerId); // Match the logged-in user's ID
        });

    // Search functionality
    if ($request->has('search') && $request->search) {
        $query->where(function ($subQuery) use ($request) {
            $subQuery->where('name', 'like', '%' . $request->search . '%')
                     ->orWhere('room_id', 'like', '%' . $request->search . '%')
                     ->orWhere('status', 'like', '%' . $request->search . '%')
                     ->orWhere('visit_time', 'like', '%' . $request->search . '%');
        });
    }

    // Filter by 'pending' status
    $query->where('status', 'pending');

    // Paginate results (10 per page)
    $reservations = $query->paginate(10);

    return view('owner.reservations.index', compact('reservations'));
}


public function myReservations()
{
    // Ensure the user is authenticated
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in to view your reservations.');
    }

    // Get the authenticated user's reservations with pagination (e.g., 10 per page)
    $reservations = $user->reservations()->paginate(10); // Adjust the number as needed

    return view('user_profile.myReservations', compact('reservations'));
}


        public function cancel($id)
        {
            // Find the reservation by ID
            $reservation = Reservation::findOrFail($id);
        
            // Ensure the reservation belongs to the authenticated user
            if ($reservation->user_id !== auth()->id()) {
                return redirect()->route('reservations.myReservations')->with('error', 'Unauthorized action.');
            }
        
            // Cancel the reservation (update status or delete)
            $reservation->delete(); // or you can update the status if you don't want to delete
        
            return redirect()->route('reservations.myReservations')->with('success', 'Reservation canceled successfully.');
        }
        

    // Accept a reservation
    public function accept(Reservation $reservation)
    {
        // Change the status to 'accepted'
        $reservation->status = 'accepted';
        $reservation->save();  // Save the changes
    
        // Redirect back with a success message
        return redirect()->route('reservations.index')->with('success', 'Reservation accepted!');
    }

    // Decline a reservation
    public function decline(Reservation $reservation)
    {
        // Change the status to 'declined'
        $reservation->status = 'declined';
        $reservation->save();  // Save the changes

        // Redirect back with a success message
        return redirect()->route('reservations.index')->with('success', 'Reservation declined!');
    }


    // Delete a reservation
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required|date_format:H:i',
        ]);
        $validated['user_id'] = auth()->id();

        $reservation = Reservation::create($validated);

        // Send email notification
        Mail::to($reservation->email)->send(new ReservationNotification($reservation));

        return redirect()->back()->with('success', 'Reservation successfully created and confirmation email sent!');
    }
    // Controller Method to Show Accepted Reservations
public function showAcceptedReservations()
{
    // Fetch all reservations where the status is 'accepted'
    $acceptedReservations = Reservation::where('status', 'accepted')->paginate(10); // Use pagination if needed

    // Return the view with the accepted reservations
    return view('owner.reservations.accepted', compact('acceptedReservations'));
}
public function acceptedDestroy($id)
{
    $reservation = Reservation::findOrFail($id);
    $reservation->delete();
    return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully');
}

    public function download($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Check if reservation is accepted
        if ($reservation->status != 'Accepted') {
            return redirect()->route('reservations.myReservations')->with('error', 'Reservation not accepted yet.');
        }

        // Pass reservation details to the view for PDF generation
        $pdf = PDF::loadView('reservations.pdf', compact('reservation'));
        
        // Download the PDF
        return $pdf->download('reservation_' . $reservation->id . '.pdf');
    }

    public function downloadReceipt($id)
{
   
    $reservation = Reservation::findOrFail($id);
    
    // Check if reservation is accepted
    if ($reservation->status != 'Accepted') {
        return redirect()->route('reservations.myReservations')->with('error', 'Reservation not accepted yet.');
    }

    // Prepare the receipt data
    $receiptData = [
        'reservation' => $reservation,
        'type' => $reservation->type,
        'room_id' => $reservation->room_id,
        'visit_date' => $reservation->visit_date, // Assuming you have a guest model
        'visit_time' => $reservation->visit_time, // Assuming this field exists
        'paymentMethod' => $reservation->payment_method, // Assuming this field exists
        'paymentStatus' => $reservation->payment_status, // Assuming this field exists
        // Add any other information needed for the receipt
    ];

    // Generate the PDF receipt
    $pdf = PDF::loadView('reservations.receipt', $receiptData);
    
    // Return the downloadable PDF receipt
    return $pdf->download('receipt_' . $reservation->id . '.pdf');
}
}
