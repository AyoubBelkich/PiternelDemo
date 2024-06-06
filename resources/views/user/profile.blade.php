@extends('layouts.app')

@section('content')
    <h1>User Profile</h1>

    <div class="card">
        <div class="card-header">
            Profile Information
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ Auth::User()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::User()->email }}</p>
            <a href="{{ route('user.products.manage') }}" class="btn btn-primary">Manage your products</a>
            <a href="{{ route('user.orders.index') }}" class="btn btn-primary">View Your Orders</a>
            <p><strong>Warnings:</strong></p>
            <ul>
                @foreach (Auth::User()->warnings as $warning)
                    <li>{{ $warning->reason }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
