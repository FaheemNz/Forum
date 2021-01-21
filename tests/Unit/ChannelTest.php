<?php

namespace Tests\Unit;

use Tests\TestCase;

class ChannelTest extends TestCase
{
    public function test_a_channel_consists_of_threads()
    {
        $this->signIn();
        $channel = factory('App\Channel')->create();
        $thread = factory('App\Thread')->create(['channel_id' => $channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
    }
}
