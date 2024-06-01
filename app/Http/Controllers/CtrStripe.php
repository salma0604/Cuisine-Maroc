<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Payment;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;

class CtrStripe extends Controller
{
    public function stripe(Request $request)
    {
        $stripe = new StripeClient(config('stripe.stripe_sk'));

        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'MAD',
                        'product_data' => [
                            'name' => $request->input('service_type'),
                        ],
                        'unit_amount' => $request->input('price') * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);

        if (isset($response->id) && $response->id != '') {
            session()->put('service_type', $request->service_type);
            session()->put('quantity', $request->quantity);
            session()->put('price', $request->price);

            return redirect($response->url);
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        if ($request->has('session_id')) {
            $stripe = new StripeClient(config('stripe.stripe_sk'));

            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->service_type = session()->get('service_type');
            $payment->quantity = session()->get('quantity');
            $payment->amount = session()->get('price');
            $payment->currency = $response->currency;
            $payment->customer_name = $response->customer_details->name ?? 'Unknown';
            $payment->customer_email = $response->customer_details->email ?? 'Unknown';

            $payment->save();

            // Clear session data after saving payment
            session()->forget(['service_type', 'quantity', 'price']);


            $user = Utilisateur::find(auth()->id());
            if ($user) {

                if ($payment->service_type=='Contacter_chef') {
                    # code...
                $user->contacter_chef = true;

                }else {
                $user->can_add_photo = true;

                }

                $user->save();
            }

            return redirect()->back()->with('success', 'Paiement effectué avec succès !');
        } else {
            return redirect()->route('cancel');
        }
    }

    public function cancel()
    {
        return "Payment was canceled.";
    }
}
