@extends('layouts.app')

@section('title', 'About Us - Food Fusion')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">About Food Fusion</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Our Story</h2>
                    <p class="card-text">
                        Food Fusion was founded in 2023 with a simple mission: to bring food lovers together and share
                        the joy of cooking across cultures. What started as a small community of passionate home chefs
                        has grown into a vibrant platform where culinary enthusiasts from around the world can share
                        their favorite recipes, cooking tips, and food stories.
                    </p>
                    <p class="card-text">
                        We believe that food is more than just sustenance—it's a universal language that connects people
                        across different backgrounds and traditions. Through Food Fusion, we aim to celebrate this diversity
                        and create a space where everyone can explore new flavors and cooking techniques.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Our Mission</h2>
                    <p class="card-text">
                        At Food Fusion, our mission is to:
                    </p>
                    <ul>
                        <li>Promote culinary diversity and cultural exchange through food</li>
                        <li>Create a supportive community for both amateur and experienced cooks</li>
                        <li>Make cooking accessible and enjoyable for everyone</li>
                        <li>Preserve traditional recipes while encouraging culinary innovation</li>
                        <li>Inspire people to explore new ingredients and cooking methods</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Join Our Community</h2>
                    <p class="card-text">
                        Whether you're a seasoned chef or just starting your culinary journey, Food Fusion welcomes you.
                        Join our community today to share your recipes, discover new dishes, and connect with fellow food enthusiasts.
                    </p>
                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign Up Today</a>
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary ms-2">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
