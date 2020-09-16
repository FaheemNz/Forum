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

    // Logic

    public function path()
    {
        return $this->thread->path();
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function getMentionedUsersInReply($text)
    {
        preg_match_all('/@([\w]+)/', $text, $matches);
        return $matches[1];
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
    // public function getCreatedAtAttribute(string $time): string
    // {
    //     return Carbon::parse($time)->diffForHumans();
    // }

    // Mutators
    public function setBodyAttribute($body)
    {
        $name = preg_replace('/@([\w]+)/', '<a href="/profiles/$1">$0</a>', $body);
        $this->attributes['body'] =$name;
    }
}
