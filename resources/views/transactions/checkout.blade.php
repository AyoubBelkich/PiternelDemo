@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-5">Your Cart</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <!-- Selling Products -->
            <div class="col-md-6 mb-4">
                <h2>Selling Products</h2>
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellProducts as $id => $details)
                            <tr>
                                <td>{{ $details['name'] }}</td>
                                <td>
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                        max="{{ $details['stock_quantity'] }}" class="form-control mr-2 quantity-input"
                                        data-id="{{ $id }}">
                                </td>
                                <td>€{{ number_format($details['price'], 2) }}</td>
                                <td>€<span class="total-price"
                                        data-id="{{ $id }}">{{ number_format($details['total'], 2) }}</span></td>
                                <td>
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Rental Products -->
            <div class="col-md-6 mb-4">
                <h2>Rental Products</h2>
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price Per Day</th>
                            <th>Rental Period</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentProducts as $id => $details)
                            <tr>
                                <td>{{ $details['name'] }}</td>
                                <td>
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                        max="{{ $details['stock_quantity'] }}" class="form-control mr-2 quantity-input"
                                        data-id="{{ $id }}">
                                </td>
                                <td>€{{ number_format($details['price_per_day'], 2) }}</td>
                                <td>
                                    {{ $details['from_date'] }} to {{ $details['to_date'] }}
                                </td>
                                <td>€<span class="total-price"
                                        data-id="{{ $id }}">{{ number_format($details['total'], 2) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-right">
            <h4>Total: €<span
                    id="grand-total">{{ number_format(array_sum(array_merge(array_column($sellProducts, 'total'), array_column($rentProducts, 'total'))), 2) }}</span>
            </h4>
        </div>
        <a href="{{ route('cart.checkout') }}" class="btn btn-success btn-lg btn-block mt-3">Proceed to Checkout</a>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    updateCartTotal();
                });
            });

            function updateCartTotal() {
                let grandTotal = 0;
                @foreach ($sellProducts as $id => $details)
                    const quantity = document.querySelector(`.quantity-input[data-id="${$id}"]`).value;
                    const price = {{ $details['price'] }};
                    const total = price * quantity;
                    document.querySelector(`.total-price[data-id="${$id}"]`).textContent = total.toFixed(2);
                    grandTotal += total;
                @endforeach
                @foreach ($rentProducts as $id => $details)
                    const quantity = document.querySelector(`.quantity-input[data-id="${$id}"]`).value;
                    const fromDate = new Date("{{ $details['from_date'] }}");
                    const toDate = new Date("{{ $details['to_date'] }}");
                    const days = (toDate - fromDate) / (1000 * 60 * 60 * 24) + 1;
                    const price = days * {{ $details['price_per_day'] }};
                    const total = price * quantity;
                    document.querySelector(`.total-price[data-id="${$id}"]`).textContent = total.toFixed(2);
                    grandTotal += total;
                @endforeach
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            }
        });
    </script>
@endpush
