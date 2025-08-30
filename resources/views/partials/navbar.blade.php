@php
    function isActive(string $name)
    {
        if (Route::currentRouteName() === $name) {
            return 'underline';
        }
        return '';
    }
@endphp

<nav class="navbar bg-base-100 shadow-sm">
    <div class="flex-1">
        <a class="btn btn-ghost text-xl" href="{{ route('posts') }}">
            <b><u>ROCO</u></b>
        </a>
    </div>
    <div class="flex-none">
        @guest
            <a wire:navigate class="{{ isActive('login') }}" aria-current="page" href="{{ route('login') }}">Login</a>
        @endguest
        @auth
            <div class="drawer">
                <input id="my-drawer" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                    <!-- Page content here -->
                    <label for="my-drawer" class="btn btn-ghost drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block h-5 w-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                            </path>
                        </svg>
                    </label>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                    <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                        <!-- Sidebar content here -->
                        <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a wire:navigate href="{{ route('show.post') }}">Upload</a></li>
                        <li><a wire:navigate href="{{ route('profile') }}">Profile</a></li>
                        <div class="divider"></div>
                        <li><a wire:navigate href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        @endauth
    </div>
</nav>
