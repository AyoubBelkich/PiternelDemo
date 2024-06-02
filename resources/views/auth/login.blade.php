@extends('layouts.app')

@section('content')
    <main class="main" style="background-image: url('{{ asset('piternelimages/login.background.jpg') }}');">
        <div class="background-blur"></div>
        <div class="container-wrapper">
            <div class="content-container">
                <div class="image-container">
                    <img class="login-baby" src="{{ asset('piternelimages/login.baby.jpg') }}" alt="Image">
                    <a href="{{ route('home') }}">
                        <img class="login-piternel-logo" src="{{ asset('piternelimages/piternel.logo.horizontaal.png') }}"
                            alt="Piternel Logo">
                    </a>
                </div>
                <div class="login-container">
                    <h2>Welcome Back</h2>
                    <div class="login-form">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" name="email" placeholder="Enter Your Email Address"
                                    value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" required
                                    placeholder="Enter Your Password">
                            </div>

                            <div class="form-group" id="terms-of-use-check">
                                <div class="input-label-container">
                                    <input type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">Remember Me</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit">Login</button>
                                @error('login_error')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="googlea2f">
                                <a href="{{ route('google.redirect') }}" class="btn btn-primary"> Login with Google </a>
                            </div>
                        </form>
                    </div>
                    <div class="register-container">
                        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
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
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

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
        }

        .login-container,
        .image-container {
            flex: 1;
        }

        .image-container {
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .image-container .login-baby {
            width: 100%;
            height: auto;
            display: block;
        }

        .login-piternel-logo {
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

        .login-piternel-logo:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .login-container {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        h2 {
            text-align: center;
            font-family: "Poetsen One", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .login-form {
            padding: 20px 40px 20px 40px; /* Adjust the top and bottom padding */
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


        .input-label-container {
            display: flex;
            flex-direction: row;
        }

        .input-label-container label {
            padding: 5px;
            margin: 5px;
        }

        .error-message {
            color: red;
            font-size: 0.8em;
        }

        .register-container {
            margin-top: 20px;
            text-align: center;
        }

        .register-container a {
            color: #7aaff5;
        }

        .register-container a:hover {
            color: #4a90e2;
            transition: color 0.3s ease;
        }

        .googlea2f {
            text-align: center;
            margin-top: 20px;
            transition: background-color .3s, box-shadow .3s;
            padding: 12px 16px 12px 42px;
            border: none;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
            color: #757575;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Roboto', arial, sans-serif;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 12px 11px;
        }

        .googlea2f a{
            text-decoration: none;
        }

        .googlea2f:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
        }

        .googlea2f:active {
            background-color: #eeeeee;
            color: #1f1f1f;
        }

        .googlea2f:focus {
            outline: none;
            box-shadow:
                0 -1px 0 rgba(0, 0, 0, .04),
                0 2px 4px rgba(0, 0, 0, .25),
                0 0 0 3px #c8dafc;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .content-container {
                flex-direction: column;
            }

            .image-container,
            .login-container {
                flex: none;
                width: 100%;
            }

            .image-container,
            .login-container {
                margin-bottom: 20px;
            }

            .googlea2f .btn-google {
                padding: 10px 20px;
            }
        }
    </style>
@endpush
