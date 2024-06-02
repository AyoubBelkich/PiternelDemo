<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cart = $this->verifyCartStructure($cart);
        session()->put('cart', $cart);

        $rentProducts = [];
        $sellProducts = [];

        foreach ($cart as $id => $details) {
            if (isset($details['price_per_day'])) {
                $rentProducts[$id] = $details;
            } else {
                $sellProducts[$id] = $details;
            }
        }

        return view('cart.index', compact('rentProducts', 'sellProducts'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if ($product->product_type == 2) {
            if (isset($cart[$product->id])) {
                if ($cart[$product->id]['quantity'] < $product->stock_quantity) {
                    $cart[$product->id]['quantity']++;
                } else {
                    return redirect()->back()->with('error', 'Not enough stock available.');
                }
            } else {
                $cart[$product->id] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price_per_day" => $product->price_per_day,
                    "image" => $product->image,
                    "from_date" => $product->available_from,
                    "to_date" => $product->available_to,
                    "available_from" => $product->available_from,
                    "available_to" => $product->available_to,
                    "stock_quantity" => $product->stock_quantity,
                    "total" => 0,
                ];
            }
        } else {
            if ($product->stock_quantity <= 0) {
                return redirect()->back()->with('error', 'Product is out of stock.');
            }

            if (isset($cart[$product->id])) {
                if ($cart[$product->id]['quantity'] < $product->stock_quantity) {
                    $cart[$product->id]['quantity']++;
                    $cart[$product->id]['total'] += $product->price;
                } else {
                    return redirect()->back()->with('error', 'Not enough stock available.');
                }
            } else {
                $cart[$product->id] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image,
                    "stock_quantity" => $product->stock_quantity,
                    "total" => $product->price,
                ];
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $product = Product::find($id);

        if ($request->quantity <= 0) {
            return $this->remove($id);
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = Carbon::parse($request->from_date);
            $toDate = Carbon::parse($request->to_date);

            if ($fromDate->lt(Carbon::parse($product->available_from)) || $toDate->gt(Carbon::parse($product->available_to))) {
                return redirect()->back()->with('error', 'Selected dates are outside the availability range.');
            }

            $days = $fromDate->diffInDays($toDate) + 1;
            $totalPrice = $days * $product->price_per_day;

            $cart[$id]['from_date'] = $request->from_date;
            $cart[$id]['to_date'] = $request->to_date;
            $cart[$id]['price'] = $totalPrice;
            $cart[$id]['total'] = $totalPrice * $request->quantity;
        } else {
            if ($request->quantity > $product->stock_quantity) {
                return redirect()->back()->with('error', 'Not enough stock available.');
            }
            $cart[$id]['quantity'] = $request->quantity;
            $cart[$id]['total'] = $cart[$id]['price'] * $request->quantity;
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('transactions.checkout', compact('cart'));
    }

    private function verifyCartStructure($cart)
    {
        foreach ($cart as $id => $details) {
            if (!isset($details['total'])) {
                $details['total'] = $details['price'] * $details['quantity'];
            }
            if (!isset($details['stock_quantity'])) {
                $product = Product::find($id);
                $details['stock_quantity'] = $product->stock_quantity;
            }
            if (!isset($details['available_from'])) {
                $product = Product::find($id);
                $details['available_from'] = $product->available_from;
            }
            if (!isset($details['available_to'])) {
                $product = Product::find($id);
                $details['available_to'] = $product->available_to;
            }
            if (!isset($details['price_per_day'])) {
                $product = Product::find($id);
                $details['price_per_day'] = $product->price_per_day;
            }
            $cart[$id] = $details;
        }
        return $cart;
    }
}
