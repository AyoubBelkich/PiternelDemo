<!-- resources/views/components/products/product-card.blade.php -->
<div class="card">
    @if ($product->image)
        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
    @endif
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">{{ $product->description }}</p>
        @if ($product->product_type == 1)
            <p class="card-text"><strong>Price: €{{ $product->price }}</strong></p>
            <p class="card-text"><strong>Stock: {{ $product->stock_quantity }}</strong></p>
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
            <a href="{{ route('checkout', $product->id) }}" class="btn btn-success mt-2">Buy Now</a>
        @else
            <p class="card-text"><strong>Price Per Day: €{{ $product->price_per_day }}</strong></p>
            <p class="card-text"><strong>Availability: </strong>{{ $product->available_from }} to
                {{ $product->available_to }}</p>
            <p class="card-text"><strong>Stock: {{ $product->stock_quantity }}</strong></p>
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
            <a href="{{ route('checkout', $product->id) }}" class="btn btn-success mt-2">Rent Now</a>
        @endif
    </div>
</div>
