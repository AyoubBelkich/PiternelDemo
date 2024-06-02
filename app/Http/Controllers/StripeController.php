<?php

// app/Http/Controllers/StripeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout(Product $product)
    {
        return view('transactions.checkout', compact('product'));
    }

    public function processPayment(Request $request, Product $product)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $amount = $product->price * 100; // amount in cents

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
            ]);

            return response()->json(['client_secret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentSuccess()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $order = new Order();
        $order->user_id = Auth::id();
        $order->items = json_encode($cart);
        $order->total_price = $total;
        $order->save();

        // Deduct stock quantities
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            $product->stock_quantity -= $details['quantity'];
            $product->save();
        }

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Payment succeeded and order placed!');
    }
}
