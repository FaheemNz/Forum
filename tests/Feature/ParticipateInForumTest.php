<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['id' => $reply->id]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    public function test_unauthenticated_users_cant_add_replies()
    {
        $this->withExceptionHandling();
        factory('App\User')->create();
        $this->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /**
     * @group Reply
     * 
     */
    public function test_an_authenicated_user_can_only_delete_his_replies()
    {
        $this->signIn();

        $replyByMe = factory('App\Reply')->create(['user_id' => auth()->id()]);

        $this->delete("/replies/{$replyByMe->id}");

        $this->assertDatabaseMissing('replies', ['id' => $replyByMe->id]);
        $this->assertEquals(0, $replyByMe->thread->fresh()->replies_count);
    }

    /**
     * @group Reply
     * 
     */
    public function test_un_authorized_users_can_not_delete_reply()
    {
        $this->delete("/replies/1")
            ->assertRedirect('/login');

        $this->signIn();
        $replyNotByMe = factory('App\Reply')->create();
        $this->delete("/replies/{$replyNotByMe->id}");
        $this->assertDatabaseHas('replies', ['id' => $replyNotByMe->id]);
    }

    /**
     * @group Reply
     */
    public function test_an_authorized_user_can_update_reply()
    {
        $this->signIn();
        $reply = factory('App\Reply')->create(['user_id' => auth()->id()]);
        $updatedReply = 'Changed';
        $this->put("/replies/{$reply->id}", ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    public function test_replies_that_contain_spam_are_not_published()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make(['body' => 'aaaaa']);
        $this->json('POST', "{$thread->path()}/replies", $reply->toArray())->assertStatus(422);
    }

    public function test_a_user_may_only_reply_once_in_a_minute()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make(['body' => 'Hello World']);

        $this->json('POST', $thread->path() . '/replies', $reply->toArray())->assertStatus(201);
        $this->json('POST', $thread->path() . '/replies', $reply->toArray())->assertStatus(422);
    }
}
