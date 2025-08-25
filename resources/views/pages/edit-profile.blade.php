@extends('layout')

@section('content')
    <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data" class="flex flex-col m-auto max-w-md gap-4">
        @csrf
        @method('PUT') {{-- Supaya request dikenali sebagai PUT oleh Laravel --}}

        {{-- Profile Picture --}}
        <div class="flex flex-col items-center mb-4">
            <div class="w-24 h-24 rounded-full bg-neutral text-white flex items-center justify-center text-3xl font-bold overflow-hidden relative">
                <img id="profilePreview" 
                     src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : '' }}" 
                     alt="Profile" 
                     class="w-24 h-24 object-cover object-center w-full h-full absolute top-0 left-0" 
                     style="{{ auth()->user()->profile_picture ? '' : 'display: none;' }}">
                @if (!auth()->user()->profile_picture)
                    <span class="z-10">
                        {{ old('username') ? strtoupper(substr(old('username'), 0, 1)) : strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    </span>
                @endif
            </div>
            <label class="mt-2 text-sm">Update Profile Picture</label>
            <input type="file" name="profile_picture" class="file-input file-input-bordered file-input-sm mt-1" onchange="previewProfilePicture(event)" />
        </div>

        {{-- Nama --}}
        <label class="label">Nama</label>
        <input type="text" name="nama" placeholder="Nama" value="{{ old('nama', auth()->user()->name) }}" class="input input-bordered" />
        @error('nama')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        {{-- Username --}}
        <label class="label">Username</label>
        <input type="text" name="username" placeholder="Username" value="{{ old('username', auth()->user()->username) }}" class="input input-bordered" />
        @error('username')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        {{-- Email --}}
        <label class="label">Email</label>
        <input type="text" name="email" placeholder="Email" value="{{ old('email', auth()->user()->email) }}" class="input input-bordered" />
        @error('email')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        {{-- Password --}}
        <label class="label">Password</label>
        <input type="password" name="password" placeholder="Password" class="input input-bordered" />
        @error('password')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-neutral mt-4">Submit</button>
    </form>

    {{-- Live Preview Script --}}
    <script>
        function previewProfilePicture(event) {
            const image = document.getElementById('profilePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    image.src = e.target.result;
                    image.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
