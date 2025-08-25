<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Page Title' }}    <meta name="csrf-token" content="{{ csrf_token() }}">
</title>
        @vite(['resources/js/app.js', 'resources/css/app.css'])
        
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
