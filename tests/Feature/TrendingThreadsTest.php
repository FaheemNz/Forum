<?php

namespace Tests\Feature;

use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    protected $key = 'trending_threads';

    public function resetRedis()
    {
        $factory           = new \M6Web\Component\RedisMock\RedisMockFactory();
        $redisTrendingMock = $factory->getAdapter('Redis');
        $redisTrendingMock->del($this->key);
        return $redisTrendingMock;
    }
    
    // A Comment
    public function test_it_increments_a_thread_score_every_time_it_is_read()
    {
        $redisMock = $this->resetRedis();
        $this->assertEmpty($redisMock->zrevrange($this->key, 0, -1));
        $thread = factory('App\Thread')->create();
        $this->get($thread->path());
        $this->assertCount(1, $trending = $redisMock->zrevrange($this->key, 0, -1));
        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }

    public function test_it_doesnt_adds_duplicate_thread_score_every_time_it_is_read()
    {
        var_dump('Detect duplicate views!!');
    }
}
