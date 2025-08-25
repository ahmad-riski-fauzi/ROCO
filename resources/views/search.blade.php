@extends('layout')

@section('content')

    <div class="flex flex-col items-center">
        <h1 class="text-xl font-bold mb-4">{{ $title }}</h1>
        <x-search-bar :action="route('search')" />
    </div>

        @forelse ($posts as $post)
            <div class="flex flex-col sm:flex-row p-4 mb-4 gap-4">
                <div class="sm:w-1/3 w-full">
                    <img 
                        src="{{ asset('storage/' . $post->image) }}" 
                        alt="Gambar untuk {{ $post->title }}" 
                        class="rounded object-cover w-full h-48 sm:h-full"
                        loading="lazy"
                    >
                </div>
                <div class="sm:w-2/3 w-full">
                    <a href="/posts/{{ $post->slug }}" class="underline">
                        <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
                    </a>
                    <p class="text-sm text-gray-500">Oleh {{ $post->user->username }}</p>
                    <p class="mt-2">{{ Str::limit($post->description, 100) }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center italic">Tidak ada hasil ditemukan.</p>
        @endforelse
@endsection
