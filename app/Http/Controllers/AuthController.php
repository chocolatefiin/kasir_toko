<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; // Importing the Auth facade

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validating the request data
        $cred = $request->validate([
            'username' => ['required', 'exists:users'], // Username must exist in the users table
            'password' => ['required'] // Password is required
        ]);

        // Attempting to log in with the provided credentials
        if (Auth::attempt($cred, $request->remember)) {
            // Redirecting to the homepage if login is successful
            return redirect('/');
        }

        // Redirecting back to login with an error message if login fails
        return back()->withErrors([
            'username' => 'Username atau Password yang diberikan salah.', // Error message
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // Logging out the user
        Auth::logout();
        
        // Invalidating the session
        $request->session()->invalidate();
        
        // Regenerating the CSRF token
        $request->session()->regenerateToken();
        
        // Redirecting to the login page
        return redirect('/login');
    }
}
