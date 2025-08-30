@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 text-gray-200">
    <div class="rounded-xl overflow-hidden shadow-lg bg-gray-800">
        <!-- Gambar post tampil penuh -->
        <img src="/storage/{{ $post->image }}" alt="Post Image" class="w-full object-cover h-72 sm:h-96">
    </div>
    <div class="flex justify-end gap-3 mt-3">
        <form action="{{ route('posts.edit', $post->slug) }}">
            <button type="submit" class="link text-blue-500">Edit</button>
        </form>
        <form action="{{ route('posts.delete', $post->slug) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="link text-red-500">Delete</button>
        </form>
    </div>
</div>
@endsection
