<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Fusion - @yield('title', 'Home')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome for star ratings -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Star Rating Styles */
        .star-rating .star-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            font-size: 1.5rem;
            padding: 0 0.1rem;
            color: #ddd;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #ffb700;
        }
    </style>
    <style>
        body {
            padding-top: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
        
        /* Nav Link Hover Effects */
        .navbar-nav .nav-link {
            position: relative;
            transition: color 0.3s ease;
            padding-bottom: 0.5rem;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #0d6efd;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .navbar-nav .nav-link:hover {
            color: #0d6efd !important;
        }
        
        .navbar-nav .nav-link:hover::after {
            width: 80%;
        }
        
        /* Dropdown Toggle Hover */
        .navbar-nav .dropdown-toggle:hover {
            color: #0d6efd !important;
        }
        
        /* Footer Links Hover */
        footer a:hover {
            color: #0d6efd !important;
            transform: translateX(3px);
            transition: all 0.3s ease;
        }
        
        footer .fs-5:hover {
            transform: scale(1.2);
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Food Fusion</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('foods.collection') }}">Recipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('foods.community_cookbook') }}">Community Cookbook</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about.index') }}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.index') }}">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('resources.index') }}">Resources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('educational_resources.index') }}">Educational</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    <footer class="bg-light mt-5 py-4 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-3">Food Fusion</h5>
                    <p class="text-muted mb-0">Discover and share delicious recipes from around the world. Your ultimate destination for culinary inspiration.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-secondary">Home</a></li>
                        <li class="mb-2"><a href="{{ route('foods.collection') }}" class="text-decoration-none text-secondary">Recipes</a></li>
                        <li class="mb-2"><a href="{{ route('foods.community_cookbook') }}" class="text-decoration-none text-secondary">Community Cookbook</a></li>
                        <li class="mb-2"><a href="{{ route('about.index') }}" class="text-decoration-none text-secondary">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('contact.index') }}" class="text-decoration-none text-secondary">Contact Us</a></li>
                        <li class="mb-2"><a href="{{ route('resources.index') }}" class="text-decoration-none text-secondary">Resources</a></li>
                        <li class="mb-2"><a href="{{ route('educational_resources.index') }}" class="text-decoration-none text-secondary">Educational</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase mb-3">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="https://facebook.com" target="_blank" class="text-decoration-none text-secondary fs-5" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="text-decoration-none text-secondary fs-5" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="text-decoration-none text-secondary fs-5" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="text-decoration-none text-secondary fs-5" title="Twitter">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="text-decoration-none text-secondary fs-5" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col text-center">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} Food Fusion. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
