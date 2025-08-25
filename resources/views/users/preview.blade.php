@extends('layout')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
     @if (session('success'))
            <div role="alert" class="alert justify-center items-center alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
    <div class="flex items-center gap-4 mb-6">
        @if ($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}"
                 class="w-24 h-24 rounded-full object-cover object-center"
                 alt="{{ $user->username }}">
        @else
            <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                {{ strtoupper(substr($user->username, 0, 1)) }}
            </div>
        @endif

        <div>
            <h1 class="text-xl font-bold text-white">{{ $user->name ?? null }}</h1>
            <h1 class="text-sm text-white">{{ '@'.$user->username }}</h1>
            <p class="text-gray-400">{{ $user->posts->count() }} Postingan</p>
        </div>
    </div>

    <div class="divider"></div>

    <div class="space-y-4">
    @forelse ($user->posts as $post)
        <div class="bg-base-200 rounded shadow">
            
            {{-- Tambahkan gambar postingan --}}
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}"
                     alt="{{ $post->title }}"
                     class="w-full max-h-64 object-cover rounded mb-3">
            @endif

            <div class="p-3">
                <a href="{{ route('users.posts.show', ['user' => $post->user->username, 'post' => $post->slug]) }}">
                    <h2 class="text-lg font-semibold text-white">
                        {{ $post->title }}
                    </h2>

                    <p class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                    <p class="mt-4 text-gray-300">{{ Str::limit($post->description, 150) }}</p>
                </a>

                    @if(Auth::user()->role === 'admin')
                    <form action="{{ route('admin.posts.destroy', $post->user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan dari pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold">
                                    Hapus
                                </button>
                            </form>
                    @endif
            </div>
        </div>
    @empty
        <p class="text-gray-400">Belum ada postingan.</p>
    @endforelse
</div>
</div>
@endsection
