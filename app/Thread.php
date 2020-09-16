<?php

namespace App;

use App\Events\OnThreadRecievesNewReply;
use App\Filters\ThreadFilters;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $perPage = 25;

    protected $with = ['user:id,name,avatar_path', 'channel:id,name,slug'];

    protected static $defaultCols = ['id', 'title', 'body', 'user_id', 'channel_id', 'created_at', 'slug', 'replies_count'];
    
    // Boot the Model
    public static function boot()
    {
        parent::boot();
        // Removed global scope of repliesCount
        static::deleting(fn ($thread) => $thread->replies->each->delete());
    }

    // Business Logic
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id()
        ]);

        return $this;
    }

    public function unSubscribe($userId = null)
    {
        return $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function setBestReply($replyId)
    {
        $this->update(['best_reply_id' => $replyId]);
    }

    // For Testing
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);
        event(new OnThreadRecievesNewReply($reply));
        return $reply;
    }

    // Helpers
    public function path(): string
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    /**
     * 
     * Relationships
     * 
     */
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

    public function subscriptions()
    {
        return $this->hasMany('App\ThreadSubscription');
    }

    /**
     * 
     * Query Scopes
     * 
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function scopeCustomSelect($query, $customCols = null)
    {
        return $query->select($customCols ?? static::$defaultCols);
    }

    /**
     * 
     * Accessors
     * 
     */
    public function getCreatedAtAttribute(string $time): string
    {
        return \Carbon\Carbon::parse($time)->diffForHumans();
    }

    public function getIsSubscribedToAttribute(): bool
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * 
     * Mutators
     * 
     */

    public function setSlugAttribute(string $title)
    {
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($title) . '-' . $this->user->id;
    }
    
    /*
    *   Core
    * 
    */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
