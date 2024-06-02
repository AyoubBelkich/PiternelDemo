@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Products</h1>
        <a href="{{ route('user.products.add') }}" class="btn btn-primary mb-4">Add Product</a>
        <div class="row">
            <div class="col-md-6">
                <h2>Sell Products</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Stock Quantity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            @if ($product->product_type == 1)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>${{ $product->price }}</td>
                                    <td>
                                        <a href="{{ route('user.products.edit', $product) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('user.products.destroy', $product) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Rent Products</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Stock Quantity</th>
                            <th>Price Per Day</th>
                            <th>Availability From</th>
                            <th>Availability To</th>
                            <th>Rental Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            @if ($product->product_type == 2)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>${{ $product->price_per_day }}</td>
                                    <td>{{ $product->available_from ? $product->available_from->format('Y-m-d') : 'N/A' }}
                                    </td>
                                    <td>{{ $product->available_to ? $product->available_to->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $product->rental_available ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('user.products.edit', $product) }}"
                                            class="btn btn-primary">Edit</a>
                                        <form action="{{ route('user.products.destroy', $product) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            text-align: center;
            margin-top: 20px;
            color: #343a40;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        /* Button Styles */
        .btn {
            border: none;
            padding: 12px 25px;
            margin: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 8px rgba(0, 91, 187, 0.3);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
            box-shadow: 0 6px 8px rgba(200, 35, 51, 0.3);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            box-shadow: 0 6px 8px rgba(90, 98, 104, 0.3);
        }

        /* Table Styles */
        .table {
            width: 100%;
            margin-bottom: 20px;
            background-color: #ffffff;
            border-collapse: collapse;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border: none;
        }

        .table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .table tr {
            transition: background-color 0.3s ease;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tr:hover {
            background-color: #e9ecef;
        }

        /* Form Styles */
        form {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-control,
        .form-control-file {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-control-file:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Container Styles */
        .container {
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endsection
