<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    public function test_a_reply_has_an_owner()
    {
        $this->signIn();
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User', $reply->user);
    }

    public function test_a_reply_knows_it_was_just_published()
    {
        $reply = factory('App\Reply')->create();
        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());
    }

    public function test_it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new \App\Reply(['body' => 'Hello @UserA']);

        $this->assertEquals(
            'Hello <a href="/profiles/UserA">@UserA</a>',
            $reply->body
        );
    }

    public function test_it_knows_if_it_is_the_best_reply()
    {
        $this->withoutExceptionHandling();
        $reply = factory('App\Reply')->create();
        $reply->thread->update(['best_reply_id' => $reply->id]);
        $this->assertTrue($reply->isBest());
    }
}
