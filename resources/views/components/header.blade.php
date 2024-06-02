<!-- resources/views/components/header.blade.php -->
<header>
    <div class="wrapper">
        <h1><a href="{{ route('home') }}"><img src="{{ URL('piternelimages/piternel.logo.horizontaal.png') }}"
                    alt="Logo Piternel" style="max-width: 200px; display: inline-block; vertical-align: middle;"></a></h1>
        <div class="navigation">
            <nav aria-label="Primary Navigation">
                <ul class="nav1">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('overons') }}">Over ons</a></li>
                    <li><a href="{{ route('community') }}">Community</a></li>
                    <li><a href="{{ route('baby') }}">Baby</a></li>
                    <li><a href="{{ route('mama') }}">Mama</a></li>
                    <li><a href="{{ route('kind') }}">Kind</a></li>
                    <li><a href="{{ route('cart.index') }}">Cart
                            ({{ session()->has('cart') ? count(session('cart')) : 0 }})</a></li>
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                        <li><a href="{{ route('profile') }}">Profile</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </nav>
        </div>
    </div>
</header>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

    header {
        background-color: #fff;
        padding: 20px 0;
        border-bottom: 1px solid #ddd;
        font-family: "Open Sans", sans-serif;
        font-optical-sizing: auto;
        font-weight: 300;
        font-style: normal;
        box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }

    .wrapper {
        font-size: 20px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    h1 {
        margin-right: 30px;
    }

    .navigation {
        text-align: center;
        margin-left: auto;
    }

    .nav1 {
        display: inline-block;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav1 li {
        margin-right: 20px;
        display: inline-block;
    }

    .nav1 li a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .nav1 li a:hover {
        color: #7aaff5;
    }
</style>
