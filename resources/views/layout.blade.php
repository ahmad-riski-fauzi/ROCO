<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ $title }}
    </title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <meta name="turbo-refresh-method" content="morph">
    <meta name="turbo-refresh-scroll" content="preserve">
</head>
<body>
    @include('partials.navbar')
    <main class="flex flex-col min-h-screen bg-base-100">
        @yield('content')
    </main>
</body>
</html>