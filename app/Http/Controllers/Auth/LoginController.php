<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user exists
        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->except('password'));
        }

        // Check if user is locked out
        if ($user->locked_until && now()->lt($user->locked_until)) {
            $timeRemaining = now()->diffInSeconds($user->locked_until);
            $minutes = floor($timeRemaining / 60);
            $seconds = $timeRemaining % 60;

            return back()->withErrors([
                'email' => "Your account is locked. Please try again in {$minutes} minutes and {$seconds} seconds.",
            ])->withInput($request->except('password'));
        }

        // Attempt to authenticate
        if (Auth::attempt($request->only('email', 'password'))) {
            // Reset login attempts on successful login
            $user->login_attempts = 0;
            $user->locked_until = null;
            $user->save();

            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Failed login attempt
        $user->login_attempts += 1;

        info($user->login_attempts);

        // Lock the account after 3 failed attempts
        if ($user->login_attempts >= 3) {
            $user->locked_until = now()->addMinutes(3);
            $user->login_attempts = 0;
        }

        $user->save();

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
