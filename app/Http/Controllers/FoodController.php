<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // Apply auth middleware to all methods except index and show
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the foods.
     */
    public function index()
    {
        $foods = Food::with('user')->latest()->get();
        return view('foods.index', compact('foods'));
    }

    /**
     * Display the recipe collection page with pagination.
     */
    public function collection(Request $request)
    {
        $query = Food::with('user')->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $foods = $query->paginate(9);
        return view('foods.collection', compact('foods'));
    }

    /**
     * Display the specified food.
     */
    public function show(Food $food)
    {
        $food->load(['user', 'ingredients', 'ratings.user']);
        return view('foods.show', compact('food'));
    }

    /**
     * Show the form for creating a new food.
     */
    public function create()
    {
        return view('foods.create');
    }

    /**
     * Store a newly created food in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'recipe' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'required',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            $food = new Food();
            $food->user_id = Auth::id();
            $food->name = $request->title;
            $food->description = $request->description;
            $food->recipe = $request->recipe;

            // Handle image upload
            if ($request->hasFile('thumbnail')) {
                $imagePath = $request->file('thumbnail')->store('foods', 'public');
                $food->thumbnail = $imagePath;
            }

            $food->save();

            // Save ingredients
            if ($request->has('ingredients')) {
                foreach ($request->ingredients as $ingredientData) {
                    $ingredient = new Ingredient();
                    $ingredient->food_id = $food->id;
                    $ingredient->name = $ingredientData['name'];
                    $ingredient->quantity = $ingredientData['quantity'];
                    $ingredient->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create recipe: ' . $e->getMessage()]);
        }

        return redirect()->route('foods.show', $food)
            ->with('success', 'Recipe created successfully!');
    }

    /**
     * Show the form for editing the specified food.
     */
    public function edit(Food $food)
    {
        // Check if user is authorized to edit this food
        if (Auth::id() !== $food->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('foods.index')
                ->with('error', 'You are not authorized to edit this recipe.');
        }

        $food->load('ingredients');
        return view('foods.edit', compact('food'));
    }

    /**
     * Update the specified food in storage.
     */
    public function update(Request $request, Food $food)
    {
        // Check if user is authorized to update this food
        if (Auth::id() !== $food->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('foods.index')
                ->with('error', 'You are not authorized to update this recipe.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'recipe' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'required',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            $food->name = $request->title;
            $food->description = $request->description;
            $food->recipe = $request->recipe;

            // Handle image upload
            if ($request->hasFile('thumbnail')) {
                // Delete old image if exists
                if ($food->thumbnail && Storage::disk('public')->exists($food->thumbnail)) {
                    Storage::disk('public')->delete($food->thumbnail);
                }

                $imagePath = $request->file('thumbnail')->store('foods', 'public');
                $food->thumbnail = $imagePath;
            }

            $food->save();

            // Delete existing ingredients
            Ingredient::where('food_id', $food->id)->delete();

            // Save new ingredients
            if ($request->has('ingredients')) {
                foreach ($request->ingredients as $ingredientData) {
                    $ingredient = new Ingredient();
                    $ingredient->food_id = $food->id;
                    $ingredient->name = $ingredientData['name'];
                    $ingredient->quantity = $ingredientData['quantity'];
                    $ingredient->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update recipe: ' . $e->getMessage()]);
        }

        return redirect()->route('foods.show', $food)
            ->with('success', 'Recipe updated successfully!');
    }

    /**
     * Remove the specified food from storage.
     */
    public function destroy(Food $food)
    {
        // Check if user is authorized to delete this food
        if (Auth::id() !== $food->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('foods.index')
                ->with('error', 'You are not authorized to delete this recipe.');
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Delete ingredients first
            Ingredient::where('food_id', $food->id)->delete();

            // Delete image if exists
            if ($food->thumbnail && Storage::disk('public')->exists($food->thumbnail)) {
                Storage::disk('public')->delete($food->thumbnail);
            }

            $food->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('foods.index')
                ->with('error', 'Failed to delete recipe: ' . $e->getMessage());
        }

        return redirect()->route('foods.index')
            ->with('success', 'Recipe deleted successfully!');
    }
}
