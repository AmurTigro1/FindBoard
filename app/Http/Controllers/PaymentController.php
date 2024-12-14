<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayMongo\PayMongo;
use GuzzleHttp\Client;
class PaymentController extends Controller
{
    public function createGCashPayment(Request $request)
    {
        $client = new Client();

        try {
            // Create a source for GCash payment
            $response = $client->post(env('PAYMONGO_BASE_URL') . '/sources', [
                'auth' => [env('PAYMONGO_SECRET_KEY'), ''],
                'json' => [
                    'data' => [
                        'attributes' => [
                            'amount' => $request->input('amount') * 100, // Amount in centavos
                            'currency' => 'PHP',
                            'type' => 'gcash',
                            'redirect' => [
                                'success' => route('paymongo.success'),
                                'failed' => route('paymongo.failed'),
                            ],
                        ],
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Redirect to GCash payment page
            return redirect($data['data']['attributes']['redirect']['checkout_url']);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment creation failed: ' . $e->getMessage());
        }
    }

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
}
