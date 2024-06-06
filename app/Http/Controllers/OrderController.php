<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('user.orders.show', compact('order'));
    }

    public function complete(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->route('user.orders.index')->with('success', 'Order marked as completed.');
    }

    public function validateOrder(Request $request, Order $order)
    {
        $items = json_decode($order->items, true);
        $productType = $items[0]['product_type'] ?? 1;

        if ($productType == 2) {
            $order->update(['status' => 'busy']);
        } else {
            $order->update(['status' => 'completed']);
        }

        return redirect()->route('user.orders.index')->with('success', 'Order validated and processed.');
    }

    public function unvalidate(Order $order)
    {
        // Refund logic goes here
        $order->update(['status' => 'cancelled']);
        return redirect()->route('user.orders.index')->with('success', 'Order cancelled and refunded.');
    }

    public function pending()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->whereIn('status', ['pending', 'busy'])->get();
        return view('user.orders.pending', compact('orders'));
    }

    public function completed()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->where('status', 'completed')->get();
        return view('user.orders.completed', compact('orders'));
    }

    public function cancelled()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->where('status', 'cancelled')->get();
        return view('user.orders.cancelled', compact('orders'));
    }
}
