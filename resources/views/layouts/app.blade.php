<!DOCTYPE html>
<html lang="{{ str_replace("_", '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="@csrf" content="{{ csrf_token() }}">
    <title>@yield('title', 'CarSellWebsite')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    {{-- Navigation --}}
    @include('layouts.navigation')
    @include('layouts.themmode')
    {{-- Header --}}
    @include('layouts.header')

    {{-- Main Content --}}
    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')
</body>
</html>
