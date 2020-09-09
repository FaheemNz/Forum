<?php

namespace App\Traits;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favoritable');
    }
    
    public function isFavorited()
    {
        return $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
