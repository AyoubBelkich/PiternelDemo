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
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="form-inline">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                            min="1" max="{{ $details['stock_quantity'] }}"
                                            class="form-control mr-2 quantity-input" data-type="sell"
                                            data-id="{{ $id }}">
                                    </form>
                                </td>
                                <td>€{{ number_format($details['price'], 2) }}</td>
                                <td>€<span class="total-price"
                                        data-id="{{ $id }}">{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                                </td>
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
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="form-inline">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                            min="1" max="{{ $details['stock_quantity'] }}"
                                            class="form-control mr-2 quantity-input" data-type="rent"
                                            data-id="{{ $id }}">
                                    </form>
                                </td>
                                <td>€{{ number_format($details['price_per_day'], 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="form-inline">
                                        @csrf
                                        <input type="text" name="from_date" id="from_date_{{ $id }}"
                                            class="form-control mr-2 date-input" value="{{ $details['from_date'] }}"
                                            required data-id="{{ $id }}" data-type="from">
                                        <input type="text" name="to_date" id="to_date_{{ $id }}"
                                            class="form-control date-input" value="{{ $details['to_date'] }}" required
                                            data-id="{{ $id }}" data-type="to">
                                    </form>
                                </td>
                                <td>€<span class="total-price"
                                        data-id="{{ $id }}">{{ number_format($details['price_per_day'] * $details['quantity'] * (Carbon\Carbon::parse($details['to_date'])->diffInDays(Carbon\Carbon::parse($details['from_date'])) + 1), 2) }}</span>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($rentProducts as $id => $details)
                flatpickr("#from_date_{{ $id }}", {
                    defaultDate: "{{ $details['from_date'] }}",
                    minDate: "{{ $details['available_from'] }}",
                    maxDate: "{{ $details['available_to'] }}",
                    onChange: function(selectedDates, dateStr, instance) {
                        const toDateInput = document.getElementById('to_date_{{ $id }}');
                        toDateInput._flatpickr.set('minDate', dateStr);
                        updateRentCartTotal();
                    }
                });
                flatpickr("#to_date_{{ $id }}", {
                    defaultDate: "{{ $details['to_date'] }}",
                    minDate: "{{ $details['available_from'] }}",
                    maxDate: "{{ $details['available_to'] }}",
                    onChange: function(selectedDates, dateStr, instance) {
                        const fromDateInput = document.getElementById('from_date_{{ $id }}');
                        fromDateInput._flatpickr.set('maxDate', dateStr);
                        updateRentCartTotal();
                    }
                });
            @endforeach

            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.getAttribute('data-type') === 'sell') {
                        updateSellCartTotal();
                    } else {
                        updateRentCartTotal();
                    }
                });
            });

            const dateInputs = document.querySelectorAll('.date-input');
            dateInputs.forEach(input => {
                input.addEventListener('change', function() {
                    updateRentCartTotal();
                });
            });

            updateSellCartTotal();
            updateRentCartTotal();

            async function updateSellCartTotal() {
                @foreach ($sellProducts as $id => $details)
                    {
                        const quantity = document.querySelector(
                            'input[data-type="sell"][data-id="{{ $id }}"]').value;
                        const price = {{ $details['price'] }};
                        const total = price * quantity;
                        document.querySelector('span.total-price[data-id="{{ $id }}"]').textContent =
                            total.toFixed(2);
                        await updateCart('{{ $id }}', quantity, null, null, 'sell');
                    }
                @endforeach
                updateGrandTotal();
            }

            async function updateRentCartTotal() {
                @foreach ($rentProducts as $id => $details)
                    {
                        const quantity = document.querySelector(
                            'input[data-type="rent"][data-id="{{ $id }}"]').value;
                        const fromDate = new Date(document.querySelector(
                            'input[data-type="from"][data-id="{{ $id }}"]').value);
                        const toDate = new Date(document.querySelector(
                            'input[data-type="to"][data-id="{{ $id }}"]').value);
                        const days = (toDate - fromDate) / (1000 * 60 * 60 * 24) + 1;
                        const price = days * {{ $details['price_per_day'] }};
                        const total = price * quantity;
                        document.querySelector('span.total-price[data-id="{{ $id }}"]').textContent =
                            total.toFixed(2);
                        await updateCart('{{ $id }}', quantity, fromDate, toDate, 'rent');
                    }
                @endforeach
                updateGrandTotal();
            }

            async function updateCart(id, quantity, fromDate, toDate, type) {
                const data = {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                };
                if (type === 'rent') {
                    data.from_date = fromDate.toISOString().split('T')[0];
                    data.to_date = toDate.toISOString().split('T')[0];
                }
                await fetch(`{{ url('cart/update') }}/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('span.total-price').forEach(span => {
                    grandTotal += parseFloat(span.textContent);
                });
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            }
        });
    </script>
@endpush

<style>
    .container {
        margin-top: 20px;
    }

    .table {
        margin-bottom: 20px;
        background: #f8f9fa;
    }

    .thead-dark {
        background: #343a40;
        color: #fff;
    }

    .btn {
        margin-top: 10px;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
        font-weight: bold;
        text-align: center;
    }

    .total-price {
        font-weight: bold;
    }

    .text-right {
        margin-top: 20px;
        font-size: 1.5rem;
        color: #333;
    }

    .btn-success {
        margin-top: 20px;
    }

    .alert {
        margin-top: 20px;
    }

    .form-inline .form-control {
        width: auto;
        display: inline-block;
    }

    .form-inline .btn {
        display: inline-block;
    }
</style>
