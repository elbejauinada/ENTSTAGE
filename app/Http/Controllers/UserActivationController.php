<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ActivationMail;

class UserActivationController extends Controller
{
    public function showActivationForm()
    {
        return view('auth.activate');
    }

    public function sendActivationEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        if ($user->status === 'active') {
            return redirect()->route('login')->with('status', 'Your account is already activated.');
        }
    
        // Generate a token
        $token = Str::random(60);
        $hashedToken = Hash::make($token); // Hash the token for secure storage

        // Store token in database with expiration
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $hashedToken, 
                'created_at' => now(),
            ]
        );

        // Generate activation link using the plain token
       $activationLink = route('activate.token', ['token' => $token, 'email' => $user->email]);


        // Send activation email
        Mail::to($user->email)->send(new ActivationMail($user, $activationLink));

        return redirect()->route('login')->with('status', 'We have emailed your activation link!');
    }

    public function showSetPasswordForm(Request $request,$token)
    {
        $email= $request->query('email');
        return view('auth.set_password', ['email' => $email, 'token' => $token]);
    }

    public function setPassword(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);
        $email= $request->query('email');
    
        // Retrieve the reset token from the database using hashed token for comparison
        $reset = DB::table('password_reset_tokens')->where('email', $email)->first();
    
        if (!$reset || !Hash::check($token,$reset->token)) {
            return redirect()->route('activate.form')->withErrors(['email' => 'Invalid or expired token']);
        }
    
        // Find the user associated with the email
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('activate.form')->withErrors(['email' => 'User not found']);
        }
    
        // Update the user's password and status
        $user->password = Hash::make($request->password);
        $user->status = 'active';
        $user->save();
    
        // Delete the used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    
        return redirect()->route('login')->with('status', 'Your account has been activated! You can now log in.');
    }
    
}
