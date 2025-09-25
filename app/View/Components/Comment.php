<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Comment extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
   public function render(): View|Closure|string
{
    $sortByComment = request()->input('comment_sort', 'newest');

    return view('components.Comments')->with([  // ← Change to 'components.comment'
        'comments' => \App\Models\Comment::whereNull('parent_id')
            ->with('replies')
            ->sort_comment('created_at', 'desc', 'comment_sort')
            ->get(),
        'commentsCount' => \App\Models\Comment::count(),
        'replyCount' => \App\Models\Comment::whereNotNull('parent_id')->count(),
        'commentsTopLevel' => \App\Models\Comment::whereNull('parent_id')->count(),
        'sortByComment' => $sortByComment
    ]);
}
    
}
