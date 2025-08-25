<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (! $query) {
            return redirect()->route('posts');
        }

        $posts = Post::with('user')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->latest()
            ->get();

        return view('search', [
            'title' => "Hasil pencarian: $query",
            'query' => $query,
            'posts' => $posts,
        ]);
    }
}
