@extends('layout')

@section('content')
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content flex-col">
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST" class="fieldset">
                        @csrf
                        <label class="label">Username</label>
                        <input value="{{ old('username') }}" name="username" type="text" class="input" placeholder="Username"
                            autofocus required />
                        @error('username')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror

                        <label class="label">Email</label>
                        <input value="{{ old('email') }}" name="email" type="email" class="input" placeholder="Email"
                            required />
                        @error('email')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror

                        <label class="label">Password</label>
                        <input value="{{ old('password') }}" name="password" type="password" class="input"
                            placeholder="Password" required />
                        @error('password')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror


                        <button class="btn btn-neutral mt-4">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
