<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('pages.posts', [
            'title' => 'All Posts',
            'posts' => Post::with('user')->latest()->get(), // ambil semua post + penulisnya
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->with([
                'comments.user',           // komentar utama dan user-nya
                'comments.replies.user',   // balasan komentar dan user-nya
                'comments.replies.replies.user', // jika perlu nested lebih dalam
            ])
            ->firstOrFail();

        $title = $post->title;
        $user = $post->user->name ?? $post->user->username;

        return view('pages.post', [
            'title' => "$title | ".$user,
            'post' => $post,
        ]);
    }
}
