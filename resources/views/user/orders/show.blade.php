@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-5">Order Details</h1>

        <div class="order-details">
            <h2>Order #{{ $order->id }}</h2>
            <p>Total Price: €{{ number_format($order->total_price, 2) }}</p>
            <p>Status: {{ $order->status }}</p>
            <h3>Items:</h3>
            <ul>
                @foreach (json_decode($order->items, true) as $item)
                    <li>{{ $item['name'] }} - {{ $item['quantity'] }} x
                        €{{ number_format($item['price'] ?? $item['price_per_day'], 2) }}</li>
                @endforeach
            </ul>
        </div>

        @if ($order->status !== 'completed')
            <form action="{{ route('user.orders.complete', $order->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-success">Mark as Completed</button>
            </form>
        @endif

        @if ($order->status === 'pending')
            <form action="{{ route('user.orders.validate', $order->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-warning">Validate Order</button>
            </form>
        @endif

        <form action="{{ route('user.orders.unvalidate', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-danger">Unvalidate Order</button>
        </form>
    </div>
@endsection
