{{-- @extends('layouts.app') --}}
{{-- @section('comments', 'This is wher comments must be shown') --}}
{{-- <x-app-layout> --}}
{{-- @php
    // Use variables if already passed from controller, otherwise get them
    $comments = $comments ?? \App\Models\Comment::whereNull('parent_id')->with('replies')->get();
    $commentsCount = $commentsCount ?? \App\Models\Comment::count();
    $replyCount = $replyCount ?? \App\Models\Comment::whereNotNull('parent_id')->count();
    $commentsTopLevel = $commentsTopLevel ?? \App\Models\Comment::whereNull('parent_id')->count();
    $sortByComment = $sortByComment ?? request()->input('comment_sort', 'newest');
@endphp --}}


{{-- @php
    if ($sortByComment === 'oldest') {
        $comments = $comments->sortBy('created_at');
    } elseif ($sortByComment === 'most_liked') {
        $comments = $comments->sortByDesc('likes');
    } elseif ($sortByComment === 'most_replied') {
        $comments = $comments->sortByDesc(fn($c) => count($c->replies));
    } else {
        $comments = $comments->sortByDesc('created_at');
    }
@endphp --}}
@props([
    'comments' => [],
    'commentsCount' => 0,
    'replyCount' => 0,
    'commentsTopLevel' => 0,
    'currentSort' => 'newest'
])

<section class="comments-section mt-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <i class="fas fa-comments text-blue-500"></i> Comments & Reviews
            <span class="text-sm text-gray-500">
                Total Comments: <span id="comments-count">{{ $commentsCount }}</span>
                <p class="small-text">Total Replies: <span id="reply-count">{{ $replyCount }}</span></p>
                <p class="small-text">Total Top-level Comments: <span id="top-level-count">{{ $commentsTopLevel }}</span></p>
            </span>
        </h3>

        <div class="comment-form mb-8">
            <h4 class="text-lg font-semibold mb-4">Add Your Comment</h4>
            <form action="{{ route('add-comment') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="parent_id" value="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Comment *</label>
                    <textarea id="message" name="message" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    <i class="fas fa-paper-plane"></i> Submit Comment
                </button>
            </form>
        </div>

        <div class="mb-4">
            <label for="comment_sort" class="mr-2 font-medium">Sort by:</label>
            <select name="comment_sort" id="comment_sort" class="border rounded px-2 py-1">
                <option value="newest" {{ $currentSort == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ $currentSort == 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="most_liked" {{ $currentSort == 'most_liked' ? 'selected' : '' }}>Most Liked</option>
                <option value="most_replied" {{ $currentSort == 'most_replied' ? 'selected' : '' }}>Most Replied</option>
            </select>
        </div>

        <div id="comments-loading" class="hidden text-center py-4">Loading comments...</div>
        
        <div id="comments-content">
            <div class="comments-list space-y-6">
                @if(count($comments) > 0)
                    @php
                        function renderThread($comment) {
                            $isLiked = Auth::check() ? DB::table('comment_likes')
                                ->where('comment_id', $comment->id)
                                ->where('user_id', Auth::user()->UserID)
                                ->exists() : false;

                            echo '<div class="comment-node bg-gray-50 p-4 rounded-lg border border-gray-200">';
                            echo '<div class="flex items-start justify-between">';
                            echo '<div class="flex items-center gap-3 mb-2">';
                            echo '<div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">'.e(strtoupper(substr($comment->name,0,1))).'</div>';
                            echo '<div><h5 class="font-semibold text-sm">'.e($comment->name).'</h5><p class="text-xs text-gray-500">'.e($comment->email).'</p></div>';
                            echo '</div>';
                            echo '<span class="text-xs text-gray-400">'.\Carbon\Carbon::parse($comment->created_at)->format('M d, Y').'</span>';
                            echo '</div>';
                            echo '<p class="text-gray-700 text-sm mt-2 comment-message">'.nl2br(e($comment->message)).'</p>';
                            echo '<div class="flex items-center mt-3 gap-3">';
                            echo '<form action="'.route('like-comment').'" method="POST" class="like-form">';
                            echo csrf_field();
                            echo '<input type="hidden" name="comment_id" value="'.$comment->id.'">';
                            echo '<button type="submit" class="like-btn '.($isLiked ? 'liked' : 'not-liked').'"><i class="fas fa-thumbs-up"></i> <span class="ml-1">'.e($comment->likes).'</span></button>';
                            echo '</form>';
                            if(isset($comment->replies) && count($comment->replies) > 0) {
                                echo '<button class="btn-view-replies text-sm text-blue-600" data-target="replies-'.$comment->id.'">View replies ('.count($comment->replies).')</button>';
                            }
                            echo '<button class="btn-toggle-reply-form text-sm text-green-600" data-target="reply-form-'.$comment->id.'">Reply</button>';
                            echo '</div>';

                            echo '<div class="replies-wrapper mt-3 hidden" id="replies-'.$comment->id.'">';
                            if(isset($comment->replies) && count($comment->replies) > 0) {
                                foreach($comment->replies as $r) {
                                    renderThread($r);
                                }
                            }
                            echo '</div>';

                            echo '<div class="reply-form mt-3 hidden" id="reply-form-'.$comment->id.'">';
                            echo '<form action="'.route('add-reply').'" method="POST">';
                            echo csrf_field();
                            echo '<input type="hidden" name="comment_id" value="'.$comment->id.'">';
                            echo '<input type="text" name="name" placeholder="Name" required class="w-full mb-2 px-2 py-1 border rounded text-sm">';
                            echo '<input type="email" name="email" placeholder="Email" required class="w-full mb-2 px-2 py-1 border rounded text-sm">';
                            echo '<textarea name="message" rows="2" placeholder="Reply" required class="w-full mb-2 px-2 py-1 border rounded text-sm"></textarea>';
                            echo '<button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Submit Reply</button>';
                            echo '</form>';
                            echo '</div>';

                            echo '</div>';
                        }
                    @endphp

                    @foreach($comments as $c)
                        @php renderThread($c); @endphp
                    @endforeach
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fas fa-comment-slash text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('comment_sort');
    const commentsContent = document.getElementById('comments-content');
    const commentsLoading = document.getElementById('comments-loading');

    function loadSortedComments() {
        const sortValue = sortSelect.value;
        
        commentsLoading.classList.remove('hidden');
        commentsContent.classList.add('hidden');
        
        fetch(`{{ url()->current() }}?comment_sort=${sortValue}&ajax=1`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newComments = doc.querySelector('.comments-section');
                
                if (newComments) {
                    commentsContent.innerHTML = newComments.querySelector('#comments-content').innerHTML;
                    
                    const newCount = doc.getElementById('comments-count');
                    const newReply = doc.getElementById('reply-count');
                    const newTopLevel = doc.getElementById('top-level-count');
                    
                    if (newCount) document.getElementById('comments-count').textContent = newCount.textContent;
                    if (newReply) document.getElementById('reply-count').textContent = newReply.textContent;
                    if (newTopLevel) document.getElementById('top-level-count').textContent = newTopLevel.textContent;
                }
                
                commentsLoading.classList.add('hidden');
                commentsContent.classList.remove('hidden');
                
                const url = new URL(window.location);
                url.searchParams.set('comment_sort', sortValue);
                window.history.pushState({}, '', url);
            })
            .catch(error => {
                console.error('Error:', error);
                commentsLoading.classList.add('hidden');
                commentsContent.classList.remove('hidden');
            });
    }
    
    sortSelect.addEventListener('change', loadSortedComments);
});

document.addEventListener("click", function(e) {
    if (e.target.closest(".btn-toggle-reply-form")) {
        const btn = e.target.closest(".btn-toggle-reply-form");
        const form = document.getElementById(btn.dataset.target);
        if (form) form.classList.toggle("hidden");
    }

    if (e.target.closest(".btn-view-replies")) {
        const btn = e.target.closest(".btn-view-replies");
        const container = document.getElementById(btn.dataset.target);
        if (!container) return;
        container.classList.toggle("hidden");
        btn.textContent = btn.textContent.includes("View")
            ? btn.textContent.replace("View replies", "Hide replies")
            : btn.textContent.replace("Hide replies", "View replies");
    }

    if (e.target.closest(".like-form button.like-btn")) {
        const btn = e.target.closest(".like-form button.like-btn");
        btn.classList.toggle("liked");
    }
});
</script>
{{-- </x-app-layout> --}}
