<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Filament Styles -->
    @filamentStyles
    
    @vite('resources/css/app.css')

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="h-full antialiased">
    
    <!-- Main Content -->
    <div class="min-h-screen">
        @yield('content')
    </div>

    <!-- Filament Scripts -->
    @filamentScripts

    @vite('resources/js/app.js')

</body>
</html>
