@extends('layout')

@section('content')
<div class="bg-gray-900 text-gray-100 min-h-screen px-4 py-6">
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Gambar Post --}}
        <div class="overflow-hidden rounded-xl shadow-lg">
            <img 
                class="w-full h-auto object-cover object-center" 
                src="/storage/{{ $post->image }}" 
                alt="{{ $post->title }}"
            >
        </div>

        {{-- Informasi Post --}}
        <div class="space-y-2">
            <p class="text-sm">{{ $post->created_at->diffForHumans() }}</p>
            <h1 class="text-3xl font-bold">{{ $post->title }}
                @if($post->category)
                    <a href="{{ route('categories.show', $post->category->slug) }}" class="badge badge-soft badge-primary">{{ $post->category->name }}</a>
                @endif
            </h1>
            <p class="text-gray-300">{{ $post->description }}</p>
        </div>

        {{-- Meta --}}
        <div class="text-sm grid justify-end text-gray-300 pt-4 space-y-1">
            <a href="{{ route('users.preview', $post->user->username) }}" class="font-semibold flex text-gray-300">
                 <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g
                      stroke-linejoin="round"
                      stroke-linecap="round"
                      stroke-width="2.5"
                      fill="none"
                      stroke="currentColor"
                    >
                      <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </g>
                  </svg>
            <span class="hover:underline font-medium">{{ $post->user->username }}</span>
        </a>
            {{-- <p><span class="font-semibold">Uploaded By:</span> {{ $post->user->username }}</p> --}}
        </div>

        {{-- Divider --}}
        <hr class="border-gray-700 my-6">

        {{-- Form Komentar --}}
        <form action="{{ route('comments.store') }}" method="POST" class="space-y-3">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea 
                name="body" 
                rows="3" 
                class="w-full p-3 bg-gray-800 text-white border border-gray-700 rounded-lg focus:outline-none focus:ring focus:ring-blue-500"
                placeholder="Tulis komentar..."
            ></textarea>
            <button 
                type="submit" 
                class="btn btn-neutral"
            >Kirim Komentar</button>
        </form>

        {{-- Daftar Komentar --}}
        <div class="space-y-4">
            @foreach ($post->comments as $comment)
                <x-comment :comment="$comment"/>
            @endforeach
        </div>
    </div>
</div>
@endsection
