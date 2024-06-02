@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome to Piternel</h1>
                <p>Explore our wide range of products available for sale and rent.</p>
                @auth
                    <a href="{{ route('user.products.manage') }}" class="btn btn-primary">Manage your products</a>
                @endauth
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Products for Sale</h2>
                <div class="row">
                    @foreach ($sellProducts as $product)
                        <div class="col-md-4 mb-4">
                            @include('components.products.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <h2>Products for Rent</h2>
                <div class="row">
                    @foreach ($rentProducts as $product)
                        <div class="col-md-4 mb-4">
                            @include('components.products.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    .card-img-top {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        height: 200px;
        object-fit: cover;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .row>.col-md-4 {
        display: flex;
    }

    .card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-body {
        flex-grow: 1;
    }
</style>
