<!DOCTYPE html>
<html lang="{{ str_replace("_", '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CarSellWebsite') || {{ config("app.name", "My CarWebsite") }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    {{-- Navigation --}}
    {{-- @include('layouts.header') --}}
    @include('layouts.navigation')
    @include('layouts.themmode')
   {{-- <x-darkthem
    title="This is title"
    footer="This is footer"
> --}}
    {{-- <p>This is the main content inside the slot.</p>
</x-darkthem>
<hr> --}}
{{-- @props(['name' => '', 'textme' => '']) --}}
{{--
<x-search-form textme="GGG" name="sdfsdfsdfsdfsdf"> --}}


{{-- </x-search-form> --}}
<!-- above test component codes is the same as below codes  -->

{{-- <x-darkthem>
    <p class="">Main Content for slot </p>
    <x-slot:footer>This is another way of showing footer</x-slot:footer>
    <x-slot:title>This is anothe way of showing title</x-slot:title>
</x-darkthem> --}}
    {{-- Header --}}


    {{-- Main Content --}}
    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>

    {{-- Cooments --}}
   {{-- @include('Comments', [
        'comments' => $comments ?? [],
        'sortByComment' => $sortByComment ?? 'newest',
        'replyCount' => $replyCount ?? 0,
        'commentsTopLevel' => $commentsTopLevel ?? 0,
        'commentsCount' => $commentsCount ?? 0
    ]) --}}
{{-- @isset($comments) --}}
<x-comments
    :comments="$comments"
    :comments-count="$commentsCount"
    :reply-count="$replyCount"
    :current-sort="$sortByComment"
    :comments-top-level="$commentsTopLevel"
/>


{{-- @endisset --}}
    {{-- Footer --}}
    @include('layouts.footer')
</body>
</html>
