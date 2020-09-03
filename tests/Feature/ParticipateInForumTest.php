<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    public function test_unauthenticated_users_cant_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $response = $this->post('/threads/1/replies', []);
        $response->decodeResponseJson();
    }
}
