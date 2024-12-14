<?php

namespace App\Jobs;
use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteExpiredReservations implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
           // Get all reservations that are older than 2 days
           $expiredReservations = Reservation::where('created_at', '<', Carbon::now()->subDays(2))
           ->whereNull('deleted_at')  // Ensure they are not already deleted
           ->get();

// Delete expired reservations
foreach ($expiredReservations as $reservation) {
$reservation->delete();
}
    }
}
