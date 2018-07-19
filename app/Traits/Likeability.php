<?php

namespace App\Traits;


use App\Like;

trait Likeability
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        return $this->likes()->create([
            'user_id' => auth()->user()->id
        ]);
    }

    public function unlike()
    {
        return $this->likes()->where([
            'user_id' => auth()->user()->id
        ])->delete();
    }

    public function toggle()
    {
        if ($this->isLiked()) {
            return $this->unlike();
        }

        return $this->like();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function isLiked(): bool
    {
        return (bool)$this->likes()->where('user_id', auth()->user()->id)->count();
    }
}