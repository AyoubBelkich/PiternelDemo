@extends('layouts.admin')
@push('styles')
    <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/users.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin Dashboard</div>

                    <div class="card-body">
                        Welcome to the admin dashboard!
                    </div>
                    <ul>
                        <li><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
                        <li><a href="{{ route('admin.products.index') }}">Manage Products</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Custom styles for admin pages */

        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        h1,
        .card-header {
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-body {
            font-size: 1rem;
            color: #495057;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
            text-align: center;
            margin-top: 20px;
        }

        ul li {
            display: inline;
            margin-right: 15px;
        }

        ul li a {
            text-decoration: none;
            font-size: 1.1rem;
            color: #007bff;
            transition: color 0.2s ease-in-out;
        }

        ul li a:hover {
            color: #0056b3;
        }
    </style>
@endsection
