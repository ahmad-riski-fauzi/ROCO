@props(['comment'])

<!-- Komentar -->
<div id="comment-{{ $comment->id }}" class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-4 shadow-sm my-3 scroll-mt-20">
    <div class="flex items-start space-x-3">
        <!-- Avatar -->
        <a href="{{ route('users.preview', $comment->user->username) }}">
            <div class="mx-auto flex items-center justify-center">
    @if ($comment->user->profile_picture)
        <img src="{{ asset('storage/' . $comment->user->profile_picture) }}"
             alt="Profile Picture"
             class="w-10 h-10 rounded-full object-cover object-center" />
    @else
        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
            <span class="text-sm font-bold text-gray-900">
                {{ strtoupper(substr($comment->user->username, 0, 1)) }}
            </span>
        </div>
    @endif
</div>
        </a>

        <!-- Konten Komentar -->
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <h4 class="font-semibold text-gray-800 dark:text-white text-sm">
                    {{ $comment->user->username }}
                </h4>
                <span class="text-xs text-gray-400 dark:text-gray-400">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Preview komentar yang dibalas -->
            @if($comment->parent)
                <a href="#comment-{{ $comment->parent->id }}" class="block text-xs italic text-gray-500 dark:text-gray-400 mb-2 border-l-4 border-blue-300 dark:border-blue-600 pl-3 hover:bg-blue-50 dark:hover:bg-gray-700 transition rounded-sm">
                    {{ $comment->parent->user->username }}: "{{ Str::limit($comment->parent->body, 100) }}"
                </a>
            @endif

            <!-- Isi komentar -->
            <p class="text-gray-700 dark:text-gray-200 text-sm mt-1">
                {{ $comment->body }}
            </p>

            <!-- Tombol Balas -->
            <div class="mt-2 flex gap-3">
                <button onclick="toggleReplyForm({{ $comment->id }})"
                    class="text-blue-500 dark:text-blue-400 text-xs hover:underline hover:text-blue-600 dark:hover:text-blue-300">
                    Balas

                </button>
                @if(auth()->user()->role === 'admin')
                <form action="{{ route('comments.delete', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-500">Delete</button>
                </form>
                @endif

                @if(auth()->user()->role === 'user' && auth()->id() === $comment->user_id)
                <form action="{{ route('comments.delete', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:underline">Delete</button>
                </form>
                @endif
            </div>

            <!-- Form Balasan -->
            <div id="reply-form-{{ $comment->id }}" class="hidden mt-3">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                    <!-- Kutipan -->
                    <div class="text-xs italic text-gray-500 dark:text-gray-400 mb-1 border-l-4 border-blue-300 dark:border-blue-600 pl-3">
                        {{ $comment->user->name }}: "{{ Str::limit($comment->body, 100) }}"
                    </div>

                    <textarea name="body" rows="2"
                        class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Tulis balasan..." autofocus>{{ old('body') }}</textarea>
                    
                    <button type="submit"
                        class="mt-2 inline-block bg-blue-600 dark:bg-blue-500 text-white text-xs px-4 py-1.5 rounded hover:bg-blue-700 dark:hover:bg-blue-400 transition">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Balasan -->
@if($comment->replies->isNotEmpty())
    @foreach($comment->replies as $reply)
        <x-comment :comment="$reply" />
    @endforeach
@endif

<!-- JavaScript -->
@once
    <style>
        html {
            scroll-behavior: smooth;
        }

        .highlight-comment {
            animation: highlightFade 2s ease-in-out;
        }

        @keyframes highlightFade {
            0% { background-color: rgba(147, 197, 253, 0.5); } /* light blue */
            100% { background-color: transparent; }
        }
    </style>

    <script>
        function toggleReplyForm(id) {
            const form = document.getElementById('reply-form-' + id);
            if (form) {
                form.classList.toggle('hidden');
            }
        }
    </script>
@endonce
