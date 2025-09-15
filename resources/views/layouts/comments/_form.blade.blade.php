<form action="{{ $action }}" method="POST" class="mb-6">
    @csrf
    @if(isset($comment))
        @method('PUT')
    @endif
    
    <div class="mb-4">
        <textarea 
            name="content" 
            rows="3" 
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Write your comment here..."
            required
        >{{ $comment->content ?? old('content') }}</textarea>
        @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
        {{ isset($comment) ? 'Update Comment' : 'Post Comment' }}
    </button>
</form>