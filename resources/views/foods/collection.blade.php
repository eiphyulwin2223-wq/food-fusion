@extends('layouts.app')

@section('title', 'Food Fusion - Recipe Collection')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center">Recipe Collection</h1>
            <p class="text-center lead">Discover delicious recipes shared by our community</p>
            @auth
                <div class="text-center mt-3">
                    <a href="{{ route('foods.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Add New Recipe
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('foods.collection') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search recipes..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($foods as $food)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($food->thumbnail)
                        <img src="{{ asset('storage/' . $food->thumbnail) }}" class="card-img-top" alt="{{ $food->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <p class="text-muted">No image available</p>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $food->name }}</h5>
                        <p class="card-text text-muted small">
                            By {{ $food->user->name }}
                        </p>
                        <p class="card-text">{{ Str::limit($food->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('foods.show', $food) }}" class="btn btn-primary">View Recipe</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $foods->links() }}
    </div>

    @if($foods->isEmpty())
        <div class="text-center my-5">
            <h3>No recipes found</h3>
            <p>Be the first to share a delicious recipe!</p>
        </div>
    @endif
</div>
@endsection
