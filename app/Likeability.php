<?php

namespace App;

use Auth;

trait Likeability
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        $like = new Like(['user_id' => Auth::id()]);
        $this->likes()->save($like);
    }

    public function isLiked()
    {
        return $this->likes()
                    ->where('user_id', Auth::id())
                    ->count() > 0;
    }

    public function unlike()
    {
        $this->likes()
              ->where('user_id', Auth::id())
              ->delete();
    }

    public function toggle()
    {
        return $this->isLiked() ? $this->unlike() : $this->like();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
