<!-- resources/views/admin/products/show.blade.php -->

@extends('layouts.admin')

@section('content')
    <h1>Product Details</h1>

    <div class="row">
        <div class="col-md-6">
            <h3>Product Information</h3>
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</p>
            <p><strong>Price:</strong>
                {{ $product->product_type == 1 ? '$' . $product->price : '$' . $product->price_per_day . '/day' }}</p>
            <p><strong>Type:</strong> {{ $product->product_type == 1 ? 'For Sale' : 'For Rent' }}</p>
            @if ($product->product_type == 2)
                <p><strong>Availability From:</strong> {{ $product->available_from }}</p>
                <p><strong>Availability To:</strong> {{ $product->available_to }}</p>
                <p><strong>Rental Availability:</strong> {{ $product->rental_available ? 'Yes' : 'No' }}</p>
            @endif
            <p><strong>Image:</strong></p>
            @if ($product->image)
                <img src="{{ asset($product->image) }}" alt="Product Image" style="max-width: 300px;">
            @else
                <p>No image available</p>
            @endif
        </div>
        <div class="col-md-6">
            <h3>User Information</h3>
            @if ($product->user)
                <p><strong>Name:</strong> {{ $product->user->name }}</p>
                <p><strong>Email:</strong> {{ $product->user->email }}</p>
            @else
                <p>No user associated with this product.</p>
            @endif
        </div>
    </div>

    <form action="{{ route('admin.products.validate', $product) }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-success">Validate Product</button>
    </form>

    <form action="{{ route('admin.products.invalidate', $product) }}" method="POST" style="display: inline;">
        @csrf
        <div class="form-group">
            <label for="reason">Reason for Unvalidation:</label>
            <textarea name="reason" id="reason" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-danger">Unvalidate and Warn User</button>
    </form>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Unvalidated Products</a>
@endsection
<style>
    /* Custom styles for admin show page */

body {
    background-color: #f8f9fa;
    font-family: 'Arial', sans-serif;
}

.container {
    margin-top: 30px;
}

h1 {
    font-size: 2.5rem;
    color: #343a40;
    margin-bottom: 20px;
}

h3 {
    font-size: 1.75rem;
    color: #495057;
    margin-bottom: 15px;
}

p {
    font-size: 1rem;
    color: #212529;
    margin-bottom: 10px;
}

p strong {
    font-weight: bold;
}

img {
    border-radius: 5px;
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    font-weight: 400;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: #007bff;
    border: 1px solid transparent;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    margin-right: 10px;
    margin-bottom: 10px;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.form-group {
    margin-bottom: 15px;
}

textarea.form-control {
    height: 100px;
    resize: none;
}

</style>