@extends('layouts.app')

@section('title', 'Food Fusion - Discover Delicious Recipes')

@section('content')
<!-- Hero Section -->
<div class="container-fluid px-0">
    <div class="bg-dark text-white py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80') no-repeat center center; background-size: cover;">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Welcome to Food Fusion</h1>
                    <p class="lead mb-4">Discover, create, and share delicious recipes from around the world</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('foods.index') }}" class="btn btn-primary btn-lg px-4 gap-3">Browse Recipes</a>
                        @auth
                            <a href="{{ route('foods.create') }}" class="btn btn-outline-light btn-lg px-4">Share Your Recipe</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Join Our Community</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Recipes Section -->
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="display-5 fw-bold">Featured Recipes</h2>
            <p class="lead">Explore our most popular culinary creations</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($featuredRecipes as $recipe)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($recipe->thumbnail)
                        <img src="{{ asset('storage/' . $recipe->thumbnail) }}" class="card-img-top" alt="{{ $recipe->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <p class="text-muted">No image available</p>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text text-muted small">By {{ $recipe->user->name }}</p>
                        <p class="card-text">{{ Str::limit($recipe->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('foods.show', $recipe) }}" class="btn btn-sm btn-primary">View Recipe</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No featured recipes available yet.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('foods.index') }}" class="btn btn-outline-primary">View All Recipes</a>
    </div>
</div>

<!-- About Food Fusion Section -->
<div class="container-fluid bg-light py-5">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="display-5 fw-bold">About Food Fusion</h2>
                <p class="lead">A community of food lovers sharing their passion</p>
                <p>Food Fusion is a platform where culinary enthusiasts can discover new recipes, share their own creations, and connect with other food lovers from around the world. Whether you're a professional chef or a home cook, Food Fusion provides the perfect space to explore and celebrate the art of cooking.</p>
                <a href="{{ route('about.index') }}" class="btn btn-outline-dark mt-3">Learn More</a>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="img-fluid rounded shadow" alt="People cooking together">
            </div>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="card-title">Share Your Recipe</h3>
                        <p class="card-text">Have a delicious recipe you want to share with the world? Join our community and contribute to our growing collection of culinary delights.</p>
                    </div>
                    @auth
                        <a href="{{ route('foods.create') }}" class="btn btn-light mt-3">Add Recipe</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light mt-3">Sign Up Now</a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="card-title">Contact Us</h3>
                        <p class="card-text">Have questions, suggestions, or feedback? We'd love to hear from you! Reach out to our team and let us know how we can improve your Food Fusion experience.</p>
                    </div>
                    <a href="{{ route('contact.index') }}" class="btn btn-light mt-3">Get in Touch</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
