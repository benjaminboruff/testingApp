<?php

namespace App;

use App\Like;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
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
}
