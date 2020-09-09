<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();

        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        $this->get($thread->path() . '/replies')
            ->assertSee($reply->body);
    }

    public function test_unauthenticated_users_cant_add_replies()
    {
        $this->withExceptionHandling();
        factory('App\User')->create();
        $this->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }
}
