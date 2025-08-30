<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardPostController extends Controller
{
    public function show()
    {
        return view('dashboard.posts.create', [
            'title' => 'ROCO | Upload',
            'categories' => Category::all(),
        ]);
    }

    public function preview(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('dashboard.posts.preview', [
            'title' => "Preview {$post->title}",
            'post' => $post,
        ]);
    }

    public function edit(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('dashboard.posts.edit', [
            'title' => 'ROCO | Edit Post',
            'post' => $post,
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'required|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('post-images', 'public');
        }

        Post::create($validated);

        return to_route('dashboard')->with('success', 'Post berhasil dibuat!');
    }

    public function update(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,'.$post->id,
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->title = $validated['title'];
        $post->description = $validated['description'];
        $post->slug = Str::slug($validated['title']);
        $post->category_id = $validated['category_id'];

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('post-images', 'public');
        }

        $post->save();

        return to_route('dashboard')->with('success', 'Post Updated Successfully');
    }

    public function delete(string $slug)
    {
        $post = Post::firstWhere('slug', $slug);

        // Hapus gambar jika ada
        if ($post->image && Storage::exists($post->image)) {
            Storage::delete($post->image);
        }

        $post->delete();

        return to_route('dashboard')->with('success', 'Post Deleted Successfully');
    }
}
