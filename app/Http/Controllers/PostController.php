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
        ->with(['comments' => function($q) {
            $q->whereNull('parent_id')
              ->with(['user'])
              ->latest(); // urutkan dari komentar terbaru
        }])->firstOrFail();


        $title = $post->title;
        $user = $post->user->name ?? $post->user->username;

        return view('pages.post', [
            'title' => "$title | ".$user,
            'post' => $post,
        ]);
    }
}
