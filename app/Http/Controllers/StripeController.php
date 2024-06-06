<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $lineItems = [];

        foreach ($cart as $id => $details) {
            if (isset($details['price_per_day'])) {
                $days = \Carbon\Carbon::parse($details['from_date'])->diffInDays(\Carbon\Carbon::parse($details['to_date'])) + 1;
                $price = $details['price_per_day'] * 100; // Convert to cents
                $quantity = $details['quantity'] * $days;
            } else {
                $price = $details['price'] * 100; // Convert to cents
                $quantity = $details['quantity'];
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $details['name'],
                    ],
                    'unit_amount' => $price,
                ],
                'quantity' => $quantity,
            ];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index'),
        ]);

        return redirect($session->url);
    }
    public function showCheckoutForm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        return view('cart.checkout', compact('cart'));
    }
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_method' => 'required|string|in:standard,express',
        ]);

        session()->put('checkout_details', $validated);

        // Proceed to Stripe checkout
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $lineItems = [];

        foreach ($cart as $id => $details) {
            if (isset($details['price_per_day'])) {
                $days = \Carbon\Carbon::parse($details['from_date'])->diffInDays(\Carbon\Carbon::parse($details['to_date'])) + 1;
                $price = $details['price_per_day'] * 100; // Convert to cents
                $quantity = $details['quantity'] * $days;
            } else {
                $price = $details['price'] * 100; // Convert to cents
                $quantity = $details['quantity'];
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $details['name'],
                    ],
                    'unit_amount' => $price,
                ],
                'quantity' => $quantity,
            ];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index'),
        ]);

        return redirect($session->url);
    }
    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Payment failed or cancelled.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($sessionId);

        if (!$session || $session->payment_status != 'paid') {
            return redirect()->route('home')->with('error', 'Payment failed or cancelled.');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('home')->with('error', 'You must be logged in to place an order.');
        }

        $cart = session()->get('cart', []);
        $checkoutDetails = session()->get('checkout_details', []);
        $total = array_sum(array_map(function ($item) {
            if (isset($item['price_per_day'])) {
                $days = \Carbon\Carbon::parse($item['from_date'])->diffInDays(\Carbon\Carbon::parse($item['to_date'])) + 1;
                return $item['price_per_day'] * $item['quantity'] * $days;
            } else {
                return $item['price'] * $item['quantity'];
            }
        }, $cart));

        $order = new Order();
        $order->user_id = $user->id;
        $order->items = json_encode($cart);
        $order->total_price = $total;
        $order->address = $checkoutDetails['address'];
        $order->city = $checkoutDetails['city'];
        $order->postal_code = $checkoutDetails['postal_code'];
        $order->country = $checkoutDetails['country'];
        $order->phone = $checkoutDetails['phone'];
        $order->shipping_method = $checkoutDetails['shipping_method'];
        $order->status = 'pending';
        $order->save();

        // Deduct stock quantities and record transactions
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            $product->stock_quantity -= $details['quantity'];
            $product->save();

            $transactionType = isset($details['price_per_day']) ? 'rent' : 'sell';
            $amount = isset($details['price_per_day']) ? $details['price_per_day'] * $details['quantity'] * (\Carbon\Carbon::parse($details['to_date'])->diffInDays(\Carbon\Carbon::parse($details['from_date'])) + 1) : $details['price'] * $details['quantity'];

            Transaction::create([
                'user_id' => $user->id,
                'product_id' => $id,
                'transaction_type' => $transactionType,
                'amount' => $amount,
                'transaction_date' => now(),
            ]);
        }

        // Clear the cart
        session()->forget('cart');
        session()->forget('checkout_details');

        return redirect()->route('home')->with('success', 'Payment succeeded and order placed!');
    }
}
