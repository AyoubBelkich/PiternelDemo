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
            <p><strong>Warnings:</strong></p>
            <ul>
                @foreach (Auth::User()->warnings as $warning)
                    <li>{{ $warning->reason }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
