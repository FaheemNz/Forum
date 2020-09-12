<?php

namespace App\Services;

class FavoriteService
{
    public function favoriteTheReply($reply)
    {
        $attributes = static::getAttributes();

        // A User can favorite a reply only once
        if (!$reply->exists || $reply->favorites()->where($attributes)->exists()) return false;

        return $reply->favorites()->create($attributes);
    }

    public function unFavoriteTheReply($reply)
    {
        if (!$reply->exists) return;

        $unFavorited = $reply->favorites()->where(
            static::getAttributes()
        )->get()->each->delete();

        return $unFavorited;
    }

    protected static function getAttributes()
    {
        return ['user_id' => auth()->id()];
    }
}
