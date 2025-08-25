@extends('layout')

@section('content')
    @if(session('success'))
        <div class="max-w-md mx-auto mt-6 p-4 bg-green-100 border border-green-300 rounded text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="m-auto p-6">
        <div class="text-center mb-6">

           <!-- Avatar -->
<div class="mx-auto flex items-center justify-center">
    @if ($user->profile_picture)
        <img src="{{ asset('storage/' . $user->profile_picture) }}"
             alt="Profile Picture"
             class="w-24 h-24 rounded-full object-cover object-center" />
    @else
        <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center">
            <span class="text-6xl font-bold text-white">
                {{ strtoupper(substr($user->username, 0, 1)) }}
            </span>
        </div>
    @endif
</div>









            <!-- Name or Capitalized Username -->
            <h1 class="text-2xl font-semibold text-white">
                {{ $user->name ? $user->name : ucfirst($user->username) }}
            </h1>

            <!-- Username -->
            <p class="text-gray-400">{{ '@' . $user->username }}</p>

            <!-- Email -->
            <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>
        </div>

        <div class="text-center">
            <a href="{{ route('edit-profile') }}" class="btn btn-neutral">
                Edit Profile
            </a>
        </div>
    </div>
@endsection
