<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscription.index');
    }
//ORIG FREE TRIAL
    public function freeTrial()
    {
        // Get the authenticated user
    $user = Auth::user();

    // Ensure trial_ends_at is a Carbon instance
    $trialEndsAt = $user->trial_ends_at;

    // Check if the trial has expired or is still active
    if ($trialEndsAt && $trialEndsAt->isPast()) {
        // If the trial is expired
        $remainingDays = 0;
        $trialStatus = "Your free trial has ended.";
    } else {
        // If the trial is still active
       // Calculate remaining time as a Carbon instance
    $remainingDays = $trialEndsAt->diffForHumans(Carbon::now());

        $trialStatus = "Your free trial is active.";
    }
        // Subscription details
        $subscription = Subscription::where('user_id', $user->id)
        ->where('status', 'active')
        ->first();

        $subscriptionDetails = null;

        if ($subscription) {
            $startDate = Carbon::parse($subscription->start_date);
            $endDate = $startDate->addDays($subscription->plan_name === 'Pro' ? 60 : 90); // Adjust based on the plan
            $remainingSubscriptionDays = $endDate->diffForHumans(Carbon::now());

        $subscriptionDetails = [
            'plan_name' => $subscription->plan_name,
            'end_date' => $endDate->toDateString(),
            'remaining_days' => $remainingSubscriptionDays,
            'max_boarding_houses' => $subscription->max_boarding_houses,
            'max_rooms' => $subscription->max_rooms,
        ];
    } else {
        $subscriptionDetails = null;
    }
    return view('trial.index', compact('remainingDays', 'trialStatus', 'subscriptionDetails'));
    }
   
    // public function subscribe(Request $request)
    // {
    //     // Validate the selected plan
    //     $request->validate([
    //         'plan_name' => 'required|string|in:basic,pro,premium',
    //     ]);

    //     // Define plan details (boarding houses and rooms allowed for each plan)
    //     $plans = [
    //         'basic' => ['max_boarding_houses' => 1, 'max_rooms' => 2, 'duration_days' => 30],
    //         'pro' => ['max_boarding_houses' => 2, 'max_rooms' => 3, 'duration_days' => 60],
    //         'premium' => ['max_boarding_houses' => 3, 'max_rooms' => 5, 'duration_days' => 90],
    //     ];

    //     // Determine the selected plan
    //     $selectedPlan = strtolower($request->plan_name);

    //     if (!array_key_exists($selectedPlan, $plans)) {
    //         return redirect()->back()->withErrors(['error' => 'Invalid subscription plan.']);
    //     }

    //     // Get the details of the selected plan
    //     $planDetails = $plans[$selectedPlan];

    //     // Create or update the subscription for the user
    //     $subscription = Subscription::updateOrCreate(
    //         ['user_id' => Auth::id()],
    //         [
    //             'plan_name' => ucfirst($selectedPlan),
    //             'max_boarding_houses' => $planDetails['max_boarding_houses'],
    //             'max_rooms' => $planDetails['max_rooms'],
    //             'start_date' => now(),
    //             'end_date' => now()->addDays($planDetails['duration_days']),
    //         ]
    //     );

    //     // Activate subscription for the user
    //     $user = Auth::user();
    //     $user->update(['subscription_active' => true]);

    //     return redirect()->route('subscriptions.index')->with('success', 'Subscription activated successfully!');
    // }
    //2nd free
    // public function freeTrial()
    // {
    //     // Get the authenticated user
    //     $user = Auth::user();
    
    //     // Ensure trial_ends_at is a Carbon instance
    //     $trialEndsAt = $user->trial_ends_at;
    
    //     // Check if the trial has expired or is still active
    //     if ($trialEndsAt && $trialEndsAt->isPast()) {
    //         // If the trial is expired
    //         $remainingDays = 0;
    //         $trialStatus = "Your free trial has ended.";
    //     } else {
    //         // If the trial is still active
    //         $remainingDays = $trialEndsAt->diffForHumans(Carbon::now());
    //         $trialStatus = "Your free trial is active.";
    //     }
    
    //     // Subscription details (if subscription exists)
    //     $subscription = Subscription::where('user_id', $user->id)
    //         ->where('status', 'active')
    //         ->first();
    
    //     $subscriptionDetails = null;
    
    //     // Only show subscription details if subscription is active and valid
    //     if ($subscription) {
    //         $startDate = Carbon::parse($subscription->start_date);
    //         $endDate = $startDate->addDays($subscription->plan_name === 'Pro' ? 60 : 90); // Adjust based on the plan
    
    //         // Check if the subscription is still valid
    //         if (Carbon::now()->lessThanOrEqualTo($endDate)) {
    //             // If subscription is still active, show subscription details
    //             $remainingSubscriptionDays = $endDate->diffForHumans(Carbon::now());
    
    //             $subscriptionDetails = [
    //                 'plan_name' => $subscription->plan_name,
    //                 'end_date' => $endDate->toDateString(),
    //                 'remaining_days' => $remainingSubscriptionDays,
    //                 'max_boarding_houses' => $subscription->max_boarding_houses,
    //                 'max_rooms' => $subscription->max_rooms,
    //             ];
    //         } else {
    //             // If subscription is expired, display a message
    //             $subscriptionDetails = null; // No subscription details to show
    //         }
    //     }
    
    //     return view('trial.index', compact('remainingDays', 'trialStatus', 'subscriptionDetails'));
    // }
    
  

    public function paymentSuccess(Request $request)
    {
        // Handle successful payment callback
        return view('payment.success', ['status' => 'Payment Successful!']);
    }

    public function paymentFailed(Request $request)
    {
        // Handle failed payment callback
        return view('payment.failed', ['status' => 'Payment Failed!']);
    }

    // public function subscribe(Request $request)
    // {
    //     $validated = $request->validate([
    //         'amount' => 'required|numeric|min:1',
    //         'description' => 'required|string',
    //         'remarks' => 'nullable|string',
    //     ]);

    //     $paymongoSecretKey = env('PAYMONGO_SECRET_KEY');

    //     try {
    //         $response = Http::withBasicAuth($paymongoSecretKey, '')
    //             ->withHeaders([
    //                 'Accept' => 'application/json',
    //                 'Content-Type' => 'application/json',
    //             ])
    //             ->post('https://api.paymongo.com/v1/links', [
    //                 'data' => [
    //                     'attributes' => [
    //                         'amount' => $validated['amount'] * 100, // Convert to cents if needed
    //                         'description' => $validated['description'],
    //                         'remarks' => $validated['remarks'] ?? null,
    //                     ],
    //                 ],
    //             ]);

    //         if ($response->successful()) {
    //             return response()->json([
    //                 'link' => $response->json('data.attributes.checkout_url'),
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'error' => $response->json('errors'),
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
    public function subscribe(Request $request)
{
    // Validate the selected plan
    $request->validate([
        'plan_name' => 'required|string|in:basic,pro,premium',
    ]);

    // Define plan details
    $plans = [
        'basic' => ['max_boarding_houses' => 1, 'max_rooms' => 2, 'duration_days' => 30, 'amount' => 50000], // PHP 500
        'pro' => ['max_boarding_houses' => 2, 'max_rooms' => 3, 'duration_days' => 60, 'amount' => 100000],  // PHP 1,000
        'premium' => ['max_boarding_houses' => 3, 'max_rooms' => 5, 'duration_days' => 90, 'amount' => 150000], // PHP 1,500
    ];

    // Get selected plan
    $selectedPlan = strtolower($request->plan_name);

    if (!array_key_exists($selectedPlan, $plans)) {
        return redirect()->back()->withErrors(['error' => 'Invalid subscription plan.']);
    }

    $planDetails = $plans[$selectedPlan];

    // Generate payment link using PayMongo API
    try {
        $paymongoSecretKey = env('PAYMONGO_SECRET_KEY');

        if (empty($paymongoSecretKey)) {
            return redirect()->back()->withErrors(['error' => 'PayMongo secret key not found in the environment configuration.']);
        }

        // Use the API key as the first parameter in Basic Authentication
        $response = Http::withBasicAuth($paymongoSecretKey, '')
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.paymongo.com/v1/links', [
                'data' => [
                    'attributes' => [
                        'amount' => $planDetails['amount'],
                        'description' => ucfirst($selectedPlan) . ' Plan Subscription',
                        'remarks' => 'Subscription for ' . $planDetails['duration_days'] . ' days',
                    ],
                ],
            ]);

        if ($response->successful()) {
            $paymentLink = $response->json('data.attributes.checkout_url');

            // Save pending subscription details in the database
            Subscription::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'plan_name' => ucfirst($selectedPlan),
                    'max_boarding_houses' => $planDetails['max_boarding_houses'],
                    'max_rooms' => $planDetails['max_rooms'],
                    'start_date' => Carbon::now()->toDateString(),
                    'end_date' => Carbon::now()->addDays($planDetails['duration_days'])->toDateString(),
                    // 'end_date' => Carbon::now()->addMonths($planDetails['duration'])->toDateString(),
                    'status' => 'active', // Add a 'status' field to track payment state
                    'amount_paid' => $planDetails['amount'], // Save payment amount
                ]
            );

            // Redirect to the payment link
            return redirect($paymentLink);
        } else {
            // Log the error for debugging purposes
            Log::error('PayMongo API Error:', $response->json());
            return redirect()->back()->withErrors(['error' => 'Failed to create payment link. Please try again.']);
        }
    } catch (\Exception $e) {
        // Log the exception for debugging purposes
        Log::error('Subscription Error:', ['exception' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
    }
}



public function handle(Request $request)
{
    // Assuming PayMongo sends a webhook with payment status in the payload
    $payload = $request->all();

    // Check if the payment status is "paid"
    if ($payload['data']['attributes']['status'] === 'paid') {
        $metadata = $payload['data']['attributes']['metadata'];

        $userId = $metadata['user_id'] ?? null;
        $planName = $metadata['plan_name'] ?? null;

        if ($userId && $planName) {
            // Get the subscription that is pending
            $subscription = Subscription::where('user_id', $userId)
                ->where('plan_name', ucfirst($planName))
                ->where('status', 'pending')
                ->first();

            if ($subscription) {
                // Update subscription to "active"
                $plans = [
                    'basic' => ['max_boarding_houses' => 1, 'max_rooms' => 2, 'duration_days' => 30],
                    'pro' => ['max_boarding_houses' => 2, 'max_rooms' => 3, 'duration_days' => 60],
                    'premium' => ['max_boarding_houses' => 3, 'max_rooms' => 5, 'duration_days' => 90],
                ];

                $planDetails = $plans[$planName];

                $subscription->update([
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addDays($planDetails['duration_days']),
                ]);

                // Optionally update user data (if required)
                $user = User::find($userId);
                $user->update(['subscription_active' => true]);
            }
        }
    } else {
        // Handle payment failure or other statuses
        // For example, you can update subscription to failed or remove it
    }

    return response()->json(['success' => true], 200);
}

}



