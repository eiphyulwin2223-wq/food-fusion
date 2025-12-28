<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get 3 featured recipes (most recent ones)
        $featuredRecipes = Food::with('user')
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('featuredRecipes'));
    }
}
