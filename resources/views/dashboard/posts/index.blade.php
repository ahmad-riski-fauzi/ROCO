@extends('layout')

@section('content')
    <div class="flex container flex-col min-h-screen m-auto">
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
            <div class="overflow-x-auto w-full">
              <table class="table">
                <!-- head -->
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- row 1 -->
                  @foreach($users as $u)
                  <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $u->name ?? $u->username }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <a href="{{ route('users.preview', $u->username) }}" class="link text-blue-500">Preview</a>

                        <form action="{{ route('admin.users.destroy', $u->username) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link text-red-500">
                                Hapus
                            </button>
                        </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        @endif



        <div class="container ">
            @if(Auth::user()->role === 'user')
                <h3 class="text-xl font-bold">Your Posts</h3>
                 @if (Auth::user()->posts->isEmpty())
                    <div class="text-center py-10 col-span-full">
                        <h1 class="text-xl text-gray-600">Belum ada postingan.</h1>
                    </div>
                @else
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(Auth::user()->posts as $p)
                            <section class="card bg-base-200 shadow-sm">
                              <a href="{{ route('posts.preview', $p->slug) }}">
                                <img
                                  src="{{ asset('storage/'.$p->image) }}"
                                  class="w-full h-full rounded object-cover object-center" 
                                  alt="Shoes" />
                              </a>
                              <div class="card-body">
                                <a class="card-title" href="{{ route('posts.slug', $p->slug) }}">{{ $p->title }}</a>
                              </div>
                            </section>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
