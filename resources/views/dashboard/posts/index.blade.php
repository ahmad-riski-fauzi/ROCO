@extends('layout')

@section('content')
    <div class="container min-h-screen prose">
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

            @error('admin')
                <div class="mt-2 text-sm text-red-600 bg-red-50 border border-red-300 rounded-md px-4 py-2">
                    {{ $message }}
                </div>
            @enderror


        
        @if(Auth::user()->role === 'admin')
        <div class="container flex m-auto">
            <div class="flex rounded-xl shadow-md">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900 rounded-xl overflow-hidden">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Username</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Created</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Updated</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($users as $u)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">{{ $u->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">{{ $u->username }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">{{ $u->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">{{ $u->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">{{ $u->updated_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('users.preview', $u->username) }}" class="text-blue-400">Preview</a>
                            <form action="{{ route('admin.users.destroy', $u->username) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        </div>
        @endif



        <div class="container m-5">
            @if(Auth::user()->role === 'user')
                <h3>Your Posts</h3>
                @if($myPosts)
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($myPosts as $post)
                        <a href="/posts/preview/{{ $post->slug }}">
                            <img class="object-center rounded-xl object-cover" src="/storage/{{ $post->image }}" alt="">
                        </a>
                        @endforeach
                    </div>
                @else
                    <p>Empty</p>
                @endif
            @endif
        </div>


        {{-- <img src="{{ asset('storage/'  . $path) }}" alt="Uploaded image"> --}}
    </div>
@endsection
