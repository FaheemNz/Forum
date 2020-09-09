<?php

namespace App;

use App\Filters\ThreadFilters;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $perPage = 25;

    protected $with = ['user:id,name', 'channel:id,name,slug'];

    // Boot the Model
    public static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('replyCount', fn ($builder) => $builder->withCount('replies'));

        static::deleting(fn ($thread) => $thread->replies->each->delete());
    }

    // Helpers
    public function path(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    // Relationships
    public function replies()
    {
        return $this->hasMany('App\Reply')
            ->withCount('favorites')
            ->with('user');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    // Query Scopes
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function scopeCustomSelect($query)
    {
        return $query->select(['id', 'title', 'body', 'user_id', 'channel_id', 'created_at']);
    }

    // Accessors
    public function getCreatedAtAttribute(string $time)
    {
        return Carbon::parse($time)->diffForHumans();
    }
}
