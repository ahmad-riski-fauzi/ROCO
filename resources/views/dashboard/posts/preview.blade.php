@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 text-gray-200">
    <div class="rounded-xl overflow-hidden shadow-lg bg-gray-800">
        <!-- Gambar post tampil penuh -->
        <img src="/storage/{{ $post->image }}" alt="Post Image" class="w-full object-cover h-72 sm:h-96">

        <div class="p-6 space-y-6">
            <!-- Tombol aksi -->
            <div class="flex justify-end gap-4">
                <form action="/posts/edit/{{ $post->slug }}" method="GET">
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition text-white text-sm font-semibold shadow">
                        ✏️ Edit
                    </button>
                </form>

                <form action="/posts/delete/{{ $post->slug }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 transition text-white text-sm font-semibold shadow">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
