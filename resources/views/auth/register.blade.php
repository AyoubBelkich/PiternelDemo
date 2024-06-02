@extends('layouts.app')

@section('content')
    <main class="main" style="background-image: url('{{ asset('piternelimages/login.background.jpg') }}');">
        <div class="background-blur"></div>
        <div class="container-wrapper">
            <div class="content-container">
                <div class="image-container">
                    <a href="{{ route('home') }}">
                        <img class="registrate-piternel-logo" src="{{ asset('piternelimages/piternel.logo.horizontaal.png') }}"
                            alt="Piternel Logo">
                    </a>
                </div>

                <div class="register-container">
                    <h2>Join Us Today</h2>
                    <div class="register-form">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" name="name" placeholder="Enter Your Name"
                                    value="{{ old('name') }}" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" name="email" placeholder="Enter Your Email Address"
                                    value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" placeholder="Enter Your Password"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    placeholder="Confirm Your Password" required>
                            </div>

                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input id="phone_number" type="text" name="phone_number"
                                    placeholder="Enter Your Phone Number" value="{{ old('phone_number') }}" required>
                            </div>
                            <div class="form-group">
                                <div class="input-label-container">
                                    <input type="checkbox" name="terms" id="terms" required>
                                    <label for="terms">I accept the <a href="{{ route('terms') }}">terms of
                                            use</a></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit">Register</button>
                            </div>
                            <div class="already-account">
                                <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
                            </div>
                        </form>
                        <div class="googlea2f">
                            <a href="{{ route('google.redirect') }}" class="btn btn-primary"> Login with Google </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-size: cover;
            font-family: "Open Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            position: relative;
            overflow: hidden;
        }

        .background-blur {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('piternelimages/login.background.jpg') }}');
            background-size: cover;
            filter: blur(10px);
            z-index: 1;
        }

        .container-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            overflow: hidden;
            position: relative;
            z-index: 2;
            box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.2);
        }

        .content-container {
            display: flex;
            align-items: stretch;
        }

        .image-container {
            flex: 1;
            background-image: url('{{ asset('piternelimages/registrate.child.avif') }}');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .registrate-piternel-logo {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 100px;
            height: auto;
            z-index: 2;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .registrate-piternel-logo:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .register-container {
            flex: 1;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        h2 {
            text-align: center;
            font-family: "Poetsen One", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .register-form {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input::placeholder {
            color: #aaa;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type=text],
        input[type=email],
        input[type=password],
        button {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #7aaff5;
            color: white;
            border: none;
            cursor: pointer;
        }

        button[type=submit]:hover {
            background-color: #6a98c7;
            transition: transform 1s ease;
            transform: scale(1.02);
        }

        .error-message {
            color: red;
            font-size: 0.8em;
        }

        .already-account {
            text-align: center;
            position: relative;
            margin-top: 50px;
            margin-bottom: -40px;
        }

        .already-account a {
            color: #7aaff5;
            text-decoration: underline;
        }

        .already-account a:hover {
            color: #4a90e2;
            transition: color 0.3s ease;
        }

        .input-label-container {
            display: flex;
            align-items: center;
        }

        .input-label-container label {
            padding: 5px;
            margin: 5px;
        }

        .input-label-container input[type="checkbox"] {
            margin-right: 5px;
        }

        .input-label-container a {
            color: #7aaff5;
            text-decoration: underline;
        }

        .input-label-container a:hover {
            color: #4a90e2;
            transition: color 0.3s ease;
        }
    </style>
@endpush
