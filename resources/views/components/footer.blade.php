<footer>
    <div class="footer-container">
        <div class="footer-links">
            <a href="{{ route('home') }}"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;">Home</a>
            <a href="{{ route('overons') }}"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;">Over ons</a>
            <a href="{{ route('community') }}"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;">Community</a>
            <a href="{{ route('login') }}"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;">Login</a>
            <a href="{{ route('terms') }}"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;">Voorwaarden</a>
            <a href="{{ route('contact') }}"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;">Contact</a>
        </div>
        <div class="copyright">
            <a href="{{ route('home') }}">
                <img src="{{ asset('piternelimages/piternel.logo.png') }}" alt="Logo Piternel"
                    style="max-width: 80px; margin-right: 10px;">
            </a>
            <p>&copy; 2024 Piternel. Alle rechten voorbehouden.</p>
        </div>
        <div class="social-media">
            <a href="#" target="_blank"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;"><img
                    src="{{ asset('piternelimages/facebook-icon.png') }}" alt="Facebook"
                    style="margin-right: 5px; width: 20px; height: 20px; vertical-align: middle;">Facebook</a>
            <a href="#" target="_blank"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;"><img
                    src="{{ asset('piternelimages/twitter-icon.png') }}" alt="Twitter"
                    style="margin-right: 5px; width: 20px; height: 20px; vertical-align: middle;">Twitter</a>
            <a href="#" target="_blank"
                style="color: #fff; text-decoration: none; margin: 0 10px; transition: color 0.3s ease;"><img
                    src="{{ asset('piternelimages/instagram-icon.png') }}" alt="Instagram"
                    style="margin-right: 5px; width: 20px; height: 20px; vertical-align: middle;">Instagram</a>
        </div>
    </div>
</footer>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

    footer {
        background-color: #333;
        color: #fff;
        padding: 20px 0;
        text-align: center;
        font-family: "Open Sans", sans-serif;
        font-optical-sizing: auto;
        font-weight: 300;
        font-style: normal;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .footer-links {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .footer-links a {
        color: #fff;
        text-decoration: none;
        margin: 0 10px;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: #7aaff5;
        font-style: italic;
    }

    .copyright {
        text-align: center;
    }

    .social-media {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .social-media a {
        padding: 10px;
        color: #fff;
        text-decoration: none;
        margin: 0 10px;
        transition: color 0.3s ease;
        display: flex;
        align-items: center;
    }

    .social-media a img {
        margin-right: 5px;
        width: 20px;
        height: 20px;
    }

    .social-media a:hover {
        color: #7aaff5;
        font-style: italic;
    }
</style>
