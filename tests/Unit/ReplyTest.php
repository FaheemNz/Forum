<?php

namespace Tests\Unit;

use Tests\TestCase;

class ReplyTest extends TestCase
{
    public function test_a_reply_has_an_owner()
    {
        $this->signIn();
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User', $reply->user);
    }
}
