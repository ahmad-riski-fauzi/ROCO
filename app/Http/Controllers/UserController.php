<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class UserController extends Controller
{
    public function preview($username)
    {
        // Ambil user berdasarkan username + relasi posts (eager loaded)
        $user = User::with(['posts' => function ($query) {
            $query->latest(); // Urutkan postingan terbaru
        }])->where('username', $username)->firstOrFail();

        $name = $user->name ?? $user->username;

        $title = "Posts | $name";

        return view('users.preview', compact('user', 'title'));
    }

    public function all(User $user)
    {
        // Ambil posts milik user + relasi yang diperlukan (user & image)
        $user->load(['posts' => function ($query) {
            $query->latest();
        }]);

        $title = 'Posts |'.$user->name ?? $user->username;

        return view('users.show', compact('user', 'title'));
    }

    public function show(User $user, Post $post)
    {
        // Validasi bahwa post memang milik user
        if ($post->user_id !== $user->id) {
            abort(404);
        }

        // Load relasi jika perlu
        $post->loadMissing([
            'user',
            'comments.user', // jika ada komentar dan setiap komentar punya user
        ]);

        return view('pages.post', [
            'post' => $post,
            'title' => $post->title.' | '.($post->user->name ?? $post->user->username),
        ]);
    }
}
