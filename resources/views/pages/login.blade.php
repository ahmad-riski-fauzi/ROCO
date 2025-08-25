@extends('layout')

@section('content')
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content flex-col">
              @if (session('status'))
                  <div role="alert" class="alert text-center alert-success">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span>{{ session('status') }}</span>
                  </div>
              @endif
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                <div class="card-body">
                    @error('message')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                    <form action="{{ route('login') }}" method="POST" class="fieldset">
                        @csrf
                        <label class="label">Email</label>
                        <input value="{{ old('email') }}" name="email" type="email" class="input"
                            placeholder="Email" />
                        @error('email')
                            <div class="text-red-500">
                                {{ $message }}
                            </div>
                        @enderror

                        <label class="label">Password</label>
                        <input value="{{ old('password') }}" name="password" type="password" class="input"
                            placeholder="Password" />
                        @error('password')
                            <div class="text-red-500">
                                {{ $message }}
                            </div>
                        @enderror


                        <button class="btn btn-neutral mt-4">Login</button>
                        <div class="flex justify-end">
                          Belum register?
                          <a class="text-blue-500 ml-1" href="{{ route('register') }}">Register</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
