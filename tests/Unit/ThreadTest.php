<?php

namespace Tests\Unit;

use Tests\TestCase;

class ThreadTest extends TestCase
{
    protected $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_has_an_owner()
    {
        $this->assertInstanceOf('App\User', $this->thread->user);
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->signIn();

        $this->post($this->thread->path() . '/replies', [
            'body' => 'Hello World this is a reply!'
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function test_a_thread_can_make_a_string_path()
    {
        $thread = factory('App\Thread')->create();

        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}",
            $thread->path()
        );
    }

    public function test_a_thread_can_be_subscribed_to()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();

        $thread->subscribe(auth()->id());

        $this->assertEquals(
            1,
            $thread->subscriptions()
                ->where(['user_id' => auth()->id()])
                ->count()
        );
    }

    public function test_a_thread_can_be_unsubscribed_from()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();
        $thread->unSubscribe(auth()->id());
        $this->assertCount(
            0,
            $thread->subscriptions
        );
    }

    public function test_thread_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $thread = factory('App\Thread')->create();
        $this->signIn();
        
        $this->assertFalse($thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }
}
