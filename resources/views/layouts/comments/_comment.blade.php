<div class="bg-white rounded-lg shadow p-4 mb-4">
    <div class="flex justify-between items-start">
        <div>
            <h4 class="font-semibold text-gray-800">{{ $comment->user->name }}</h4>
            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
        </div>
        @if(auth()->id() === $comment->UserID)
            <div class="space-x-2">
                <button class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                <button class="text-red-600 hover:text-red-800 text-sm">Delete</button>
            </div>
        @endif
    </div>
    <p class="text-gray-700 mt-2">{{ $comment->content }}</p>
</div>