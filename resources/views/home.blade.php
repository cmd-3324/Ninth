@extends('layouts.app')

@section('title', 'Home Page')
@section('header-title', 'Welcome Home')
@section('header-subtitle', 'Discover amazing content')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-4">Latest Content</h2>
        <p class="text-gray-700">This is your home page content. You can add sections, cards, or any other components here.</p>

        @auth
            <div class="mt-6 p-4 bg-blue-50 rounded">
                <p class="text-blue-800">Hello, {{ auth()->user()->UserName }}! You are logged in.</p>
            </div>
        @else

            <div class="mt-6 p-4 bg-gray-100 rounded">
                <p>Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to access more features.</p>
            </div>
        @endauth
        @auth

@endauth
    </div>
</div>
@endsection
