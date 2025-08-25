<div class="flex gap-3 mb-4">
    {{-- Avatar Foto atau Inisial, dengan Link ke Profil --}}
    <a href="{{ route('users.preview', $comment->user->username) }}" class="shrink-0">
        @if ($comment->user->profile_picture)
            <div class=" w-10 h-10 rounded-full overflow-hidden">
                <img 
                    src="{{ asset('storage/' . $comment->user->profile_picture) }}" 
                    alt="Profile Picture" 
                    class="w-10 h-10 object-cover object-center" 
                />
            </div>
        @else
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold">
                {{ strtoupper(substr($comment->user->username, 0, 1)) }}
            </div>
        @endif
    </a>

    {{-- Isi komentar dan form balasan --}}
    <div class="flex-1">
        <p class="text-gray-300 text-[0.7em]">{{ $comment->created_at->diffForHumans() }}</p>
        <a href="{{ route('users.preview', $comment->user->username) }}" class="font-semibold text-gray-200 hover:underline">
            {{ $comment->user->username }}
        </a>
        <p class="text-gray-300">{{ $comment->body }}</p>

        {{-- Tombol "Balas" yang memunculkan form --}}
        <details class="mt-2">
            <summary class="cursor-pointer text-sm text-gray-400 hover:underline">Balas</summary>
            <form action="{{ route('comments.store') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea  
                    name="body" 
                    rows="1" 
                    class="w-full border border-gray-600 bg-gray-800 text-gray-100 rounded p-2 text-sm placeholder-gray-500 focus:outline-none focus:border-blue-500" 
                    placeholder="Balas komentar ini..."
                    autofocus>{{ '@'.$comment->user->username. ' ' }}
                    </textarea>
                <button class="btn btn-neutral text-sm mt-2" type="submit">Balas</button>
            </form>
        </details>

        {{-- Balasan komentar secara rekursif --}}
        <div class="mt-4 pl-6 border-l border-gray-700">
            @foreach ($comment->replies as $reply)
                <x-comment :comment="$reply" />
            @endforeach
        </div>
    </div>
</div>
