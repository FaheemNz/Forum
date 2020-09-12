<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use RecordsActivity, Favoritable;

    protected $guarded = [];
    protected $with = ['user:id,name', 'favorites:id,favoritable_id,user_id'];
    protected $appends = ['favoritesCount', 'isFavorited'];


    public static function boot()
    {
        parent::boot();
        static::created(fn ($reply) => $reply->thread->increment('replies_count'));
        static::deleted(fn ($reply) => $reply->thread->decrement('replies_count'));
    }

    public function path()
    {
        return $this->thread->path();
    }

    // Relationships
    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Accessors
    public function getCreatedAtAttribute(string $time): string
    {
        return Carbon::parse($time)->diffForHumans();
    }
}
