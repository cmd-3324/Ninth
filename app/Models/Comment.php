<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $fillable = [
        'message',
        'name',
        'email',
        'parent_id',
        'likes',
        'reply_num'
    ];

    // Relationship to get all replies for this comment
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    // Check if current user liked this comment
    public function getIsLikedAttribute(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return DB::table('comment_likes')
            ->where('comment_id', $this->id)
            ->where('user_id', Auth::user()->UserID)
            ->exists();
    }
}
