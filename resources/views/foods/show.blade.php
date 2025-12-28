@extends('layouts.app')

@section('title', $food->name . ' - Food Fusion')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                @if($food->thumbnail)
                    <img src="{{ asset('storage/' . $food->thumbnail) }}" class="card-img-top" alt="{{ $food->name }}" style="max-height: 400px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                        <p class="text-muted">No image available</p>
                    </div>
                @endif

                <div class="card-body">
                    <h1 class="card-title">{{ $food->name }}</h1>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted">By {{ $food->user->name }}</span>
                        </div>
                        <div>
                            @auth
                                @if(Auth::id() === $food->user_id || Auth::user()->role === 'admin')
                                    <a href="{{ route('foods.edit', $food) }}" class="btn btn-primary btn-sm me-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('foods.destroy', $food) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this recipe?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            @endauth
                            <a href="{{ route('foods.index') }}" class="btn btn-outline-secondary btn-sm ms-2">
                                Back to Recipes
                            </a>
                        </div>
                    </div>

                    <hr>

                    <h5>Description</h5>
                    <p class="card-text">{{ $food->description }}</p>

                    @auth
                        <!-- Content for authenticated users -->
                        <h5 class="mt-4">Ingredients</h5>
                        <div class="card-text mb-4">
                            @if(count($food->ingredients) > 0)
                                <ul class="list-group">
                                    @foreach($food->ingredients as $ingredient)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $ingredient->name }}
                                            <span class="badge bg-primary rounded-pill">{{ $ingredient->quantity }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No ingredients listed.</p>
                            @endif
                        </div>

                        <h5 class="mt-4">Recipe Instructions</h5>
                        <div class="card-text mb-4">
                            {!! nl2br(e($food->recipe)) !!}
                        </div>

                        <!-- Ratings Section -->
                        <h5 class="mt-4">Ratings & Reviews</h5>
                        <div class="card-text mb-4">
                            <!-- Add Rating Form -->
                            @php
                                $userRating = $food->ratings->where('user_id', Auth::id())->first();
                            @endphp

                            @if(!$userRating)
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Rate this recipe</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('ratings.store', $food) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Your Rating</label>
                                                <div class="star-rating">
                                                    <div class="star-input">
                                                        <input type="radio" name="rating" id="rating-5" value="5">
                                                        <label for="rating-5" class="fas fa-star"></label>
                                                        <input type="radio" name="rating" id="rating-4" value="4">
                                                        <label for="rating-4" class="fas fa-star"></label>
                                                        <input type="radio" name="rating" id="rating-3" value="3">
                                                        <label for="rating-3" class="fas fa-star"></label>
                                                        <input type="radio" name="rating" id="rating-2" value="2">
                                                        <label for="rating-2" class="fas fa-star"></label>
                                                        <input type="radio" name="rating" id="rating-1" value="1">
                                                        <label for="rating-1" class="fas fa-star"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="comment" class="form-label">Your Review (Optional)</label>
                                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Your Rating</h6>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-primary edit-rating-btn">Edit</button>
                                            <form action="{{ route('ratings.destroy', $userRating) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete your rating?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="current-rating">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="me-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $userRating->rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-muted">{{ $userRating->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if($userRating->comment)
                                                <p class="card-text">{{ $userRating->comment }}</p>
                                            @else
                                                <p class="text-muted">No comment provided.</p>
                                            @endif
                                        </div>
                                        <div class="edit-rating-form" style="display: none;">
                                            <form action="{{ route('ratings.update', $userRating) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label">Your Rating</label>
                                                    <div class="star-rating">
                                                        <div class="star-input">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <input type="radio" name="rating" id="edit-rating-{{ $i }}" value="{{ $i }}" {{ $userRating->rating == $i ? 'checked' : '' }}>
                                                                <label for="edit-rating-{{ $i }}" class="fas fa-star"></label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit-comment" class="form-label">Your Review (Optional)</label>
                                                    <textarea class="form-control" id="edit-comment" name="comment" rows="3">{{ $userRating->comment }}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Rating</button>
                                                <button type="button" class="btn btn-secondary cancel-edit-btn">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Display Other Ratings -->
                            <h6>{{ $food->ratings->count() }} {{ Str::plural('Review', $food->ratings->count()) }}</h6>
                            @if($food->ratings->count() > 0)
                                <div class="list-group">
                                    @foreach($food->ratings->where('user_id', '!=', Auth::id()) as $rating)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $rating->user->name }}</strong>
                                                    <span class="text-muted ms-2">{{ $rating->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $rating->rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            @if($rating->comment)
                                                <p class="mt-2 mb-0">{{ $rating->comment }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No reviews yet. Be the first to review!</p>
                            @endif
                        </div>
                    @else
                        <!-- Content for guests -->
                        <div class="alert alert-info mt-4">
                            <div class="text-center">
                                <h5 class="mb-3">Login to view ingredients and recipe instructions</h5>
                                <p>You need to be logged in to view the complete recipe details.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="bi bi-lock-fill me-2"></i> Login to View Recipe
                                </a>
                                <p class="mt-3 small">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit rating functionality
        const editRatingBtn = document.querySelector('.edit-rating-btn');
        const cancelEditBtn = document.querySelector('.cancel-edit-btn');

        if (editRatingBtn) {
            editRatingBtn.addEventListener('click', function() {
                document.querySelector('.current-rating').style.display = 'none';
                document.querySelector('.edit-rating-form').style.display = 'block';
            });
        }

        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', function() {
                document.querySelector('.edit-rating-form').style.display = 'none';
                document.querySelector('.current-rating').style.display = 'block';
            });
        }
    });
</script>
@endsection

@endsection
