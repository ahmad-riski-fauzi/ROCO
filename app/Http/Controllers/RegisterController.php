<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('pages.register', [
            'title' => 'ROCO | Register',
        ]);
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'username' => 'required|min:5|unique:users,username',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:5',
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return to_route('login')->with('status', 'Registrasi Berhasil');

    }
}
