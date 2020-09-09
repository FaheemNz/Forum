<?php

namespace App\Services;

class FavoriteService
{
    public function favoriteTheReply($reply)
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$reply->exists || $reply->favorites()->where($attributes)->exists()) return false;

        return $reply->favorites()->create($attributes);
    }
}
