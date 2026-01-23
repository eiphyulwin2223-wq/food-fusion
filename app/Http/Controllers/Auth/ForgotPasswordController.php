<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'We cannot find a user with that email address.',
            ]);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = route('password.reset', $token) . '?email=' . urlencode($request->email);
        info($resetUrl);

        try {
            Mail::send('emails.password-reset', ['url' => $resetUrl], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Password Reset Request');
            });
        } catch (Exception $e) {
            Log::error("Password reset email error: " . $e->getMessage());
        }

        return back()->with('status', 'We have emailed your password reset link!');
    }
}
