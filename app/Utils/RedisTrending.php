<?php

namespace App\Utils;

use Illuminate\Support\Facades\Redis;

class RedisTrending
{
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 4));
    }

    /**
     * updateTrendingThreads
     *
     * @param  mixed $thread
     * @return void
     */
    public function push($thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));
    }
    
    public function cacheKey()
    {
        return 'trending_threads';
    }
}
