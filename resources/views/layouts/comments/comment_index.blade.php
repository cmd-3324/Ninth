@extends('layouts.app')

@section('title', 'Comments')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Comments</h2>
    
    {{-- Comment Form --}}
    @auth
        @include('comments._form', ['action' => route('comments.store')])
    @else
        <p class="mb-6">Please <a href="{{ route('login') }}" class="text-blue-600">login</a> to leave a comment.</p>
    @endauth

    {{-- Comments List --}}
    <div class="space-y-4">
        @forelse($comments as $comment)
            @include('comments._comment', ['comment' => $comment])
        @empty
            <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($comments->hasPages())
        <div class="mt-6">
            {{ $comments->links() }}
        </div>
    @endif
</div>
@endsection