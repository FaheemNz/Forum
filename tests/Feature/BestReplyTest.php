<?php

namespace Tests\Feature;

use Tests\TestCase;

class BestReplyTest extends TestCase
{
    public function test_a_auth_user_can_mark_any_reply_as_best_reply()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $replies = factory('App\Reply', 2)->create(['thread_id' => $thread->id]);
        $this->postJson(route('best-reply.store', $replies[1]->id));
        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    public function test_only_the_thread_create_may_mark_the_reply_as_best()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $replies = factory('App\Reply', 2)->create(['thread_id' => $thread->id]);

        $this->signIn();

        $this->postJson(route('best-reply.store', $replies[1]->id))->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());
    }
}
