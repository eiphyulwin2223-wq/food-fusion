@extends('layouts.app')

@section('title', 'Add New Recipe - Food Fusion')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Recipe</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Recipe Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="recipe" class="form-label">Recipe Instructions</label>
                            <textarea class="form-control @error('recipe') is-invalid @enderror" id="recipe" name="recipe" rows="6" required>{{ old('recipe') }}</textarea>
                            <small class="form-text text-muted">Provide step-by-step instructions for preparing this recipe.</small>
                            @error('recipe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="thumbnail" class="form-label">Recipe Image</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
                            <small class="form-text text-muted">Upload an image of your prepared dish (optional). Accepted formats: JPEG, PNG, GIF.</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ingredients</label>
                            <div id="ingredients-container">
                                <div class="row mb-2 ingredient-row">
                                    <div class="col-md-6">
                                        <input type="text" name="ingredients[0][name]" class="form-control" placeholder="Ingredient name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="ingredients[0][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-ingredient" disabled>Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" id="add-ingredient">Add Ingredient</button>
                            @error('ingredients')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('ingredients.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('foods.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Recipe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('ingredients-container');
        const addButton = document.getElementById('add-ingredient');
        let ingredientIndex = 0;

        // Function to add new ingredient row
        addButton.addEventListener('click', function() {
            ingredientIndex++;
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 ingredient-row';
            newRow.innerHTML = `
                <div class="col-md-6">
                    <input type="text" name="ingredients[${ingredientIndex}][name]" class="form-control" placeholder="Ingredient name" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="ingredients[${ingredientIndex}][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-ingredient">Remove</button>
                </div>
            `;
            container.appendChild(newRow);

            // Enable all remove buttons if we have more than one ingredient
            if (container.querySelectorAll('.ingredient-row').length > 1) {
                container.querySelectorAll('.remove-ingredient').forEach(button => {
                    button.disabled = false;
                });
            }
        });

        // Event delegation for remove buttons
        container.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-ingredient')) {
                e.target.closest('.ingredient-row').remove();

                // If only one ingredient remains, disable its remove button
                if (container.querySelectorAll('.ingredient-row').length === 1) {
                    container.querySelector('.remove-ingredient').disabled = true;
                }
            }
        });
    });
</script>
@endsection
@endsection
