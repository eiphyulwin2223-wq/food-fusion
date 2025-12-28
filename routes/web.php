<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Food Routes
Route::get('/recipes', [FoodController::class, 'collection'])->name('foods.collection');
Route::get('/recipes/all', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/create', [FoodController::class, 'create'])->name('foods.create');
Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');
Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('foods.edit');
Route::put('/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
Route::delete('/foods/{food}', [FoodController::class, 'destroy'])->name('foods.destroy');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Home Route (Protected by auth middleware)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rating Routes (Protected by auth middleware in controller)
Route::post('/foods/{food}/ratings', [RatingController::class, 'store'])->name('ratings.store');
Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');

// About Us Route
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

// Contact Us Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
