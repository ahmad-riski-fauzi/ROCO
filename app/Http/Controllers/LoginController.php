<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('pages.login', [
            'title' => 'ROCO | Login',
        ]);
    }

    public function authenticate(Request $req)
    {
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();

            return to_route('dashboard')->with('success', 'You have been successfully logged in');
        } else {
            return back()->withErrors([
                'message' => 'Username Atau Password Salah',
            ]);
        }
    }

    public function logout(Request $request)
    {
        // Get the current user's information
        $user = Auth::user();

        // Log the user out
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Optionally, you can perform a redirect after logging out
        return to_route('login')->with('status', 'You have been successfully logged out');
    }
}
