<?php

namespace App\Traits;

trait Favoritable
{
    /**
     * Boot the Model
     */
    protected static function bootFavoritable()
    {
        static::deleting(fn ($model) => $model->favorites->each->delete());
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favoritable');
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    // To check whether the user favorited the reply in Vue Favorite component
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
