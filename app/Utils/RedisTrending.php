<?php

namespace App\Utils;

use Illuminate\Support\Facades\Redis;

class  RedisTrending
{
    protected const CACHE_KEY = 'trending_threads';

    /**
     * Get top 5 comments from Redis Set
     * 
     * @return array
     */
    public function get(): array
    {
        return array_map('json_decode', Redis::zrevrange(self::CACHE_KEY, 0, 4));
    }

    /**
     * Update Trending Threads
     *
     * @param  Thread $thread
     * @return void
     */
    public function push($thread): void
    {
        Redis::zincrby(self::CACHE_KEY, 1, $this->generateKey($thread));
    }

    /**
     *  Remove a value from Redis Sorted Set
     *
     *  @param Thread $thread
     */
    public function remove($thread): void
    {
        Redis::zrem(self::CACHE_KEY, $this->generateKey($thread));
    }
    
    /**
     * Encrypt and Decrypt key to be inserted and deleted in Redis set
     * 
     * @return string
     */
    protected function generateKey($thread): string
    {
        return json_encode(['title' => $thread->title, 'path' => $thread->path()]);
    }
}
