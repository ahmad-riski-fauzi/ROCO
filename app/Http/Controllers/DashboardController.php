<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {

        if (auth()->user()->role === 'admin') {
            $users = User::get();

            return view('dashboard.posts.index', [
                'title' => 'Admin Dashboard',
                'users' => $users,
            ]);
        }

        $myPosts = Post::where('user_id', auth()->id())->get();

        return view('dashboard.posts.index', [
            'title' => 'Dashboard',
            'myPosts' => $myPosts,
        ]);
    }

    public function profile()
    {
        $user = auth()->user();

        return view('pages.profile', [
            'title' => "Profile | $user->username",
            'user' => $user,
        ]);
    }

    public function editProfile()
    {
        $user = auth()->user();

        return view('pages.edit-profile', [
            'title' => "Edit Profile $user->username",
            'user' => $user,
        ]);
    }

    public function update(Request $req)
    {
        $user = auth()->user();

        $validated = $req->validate([
            'nama' => 'nullable|string|max:255',
            'username' => 'nullable|min:5|unique:users,username,'.$user->id,
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika ada field yang diubah, update sesuai input
        if ($req->filled('nama')) {
            $user->name = $req->input('nama');
        }

        if ($req->filled('username')) {
            $user->username = $req->input('username');
        }

        if ($req->filled('email')) {
            $user->email = $req->input('email');
        }

        if ($req->filled('password')) {
            $user->password = bcrypt($req->input('password'));
        }

        if ($req->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Simpan foto baru
            $path = $req->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return to_route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
