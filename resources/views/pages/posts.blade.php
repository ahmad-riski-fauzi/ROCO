@extends('layout')

@section('content')
    <div class="flex flex-col items-center mt-5">
        @if(Route::is('posts'))
            <x-search-bar/>
        @endif
    </div>

    @if ($posts->isEmpty())
        <div class="text-center py-10 col-span-full">
            <h1 class="text-xl text-gray-600">Belum ada postingan.</h1>
        </div>
    @else
        <div class="grid grid-cols-3 gap-4 container mx-auto px-4 py-6">
            @foreach($posts as $p)
                <a href="{{ url('/posts/' . $p->slug) }}" class="block overflow-hidden rounded-xl shadow hover:shadow-lg transition duration-300">
                    <img 
                        class="w-full h-full object-cover object-center" 
                        src="{{ asset('storage/' . $p->image) }}" 
                        alt="Gambar untuk {{ $p->title }}" 
                        loading="lazy"
                    >
                </a>
            @endforeach
        </div>
    @endif
@endsection
