<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_view_a_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_filter_threads_by_channel()
    {
        $channel = factory('App\Channel')->create(['name' => 'channel 1', 'slug' => 'channel 1']);

        $threadInChannel = factory('App\Thread')->create(['channel_id' => $channel->id]);
        $threadNotInChannel = factory('App\Thread')->create();

        $response = $this->get("/threads/{$channel->slug}");

        $response->assertSee($threadInChannel->title);
        $response->assertDontSee($threadNotInChannel->title);
    }

    public function test_an_authenticated_user_can_filter_by_any_username()
    {
        $this->actingAs(factory('App\User')->create(['name' => 'Faheem']));

        $threadByFaheem = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $threadNotByFaheem = factory('App\Thread')->create();

        $this->get('/threads?by=Faheem')
            ->assertSee($threadByFaheem->title)
            ->assertDontSee($threadNotByFaheem->title);
    }

    public function test_a_user_can_filter_threads_by_popularity()
    {
        $thread2Replies = factory('App\Thread')->create();
        factory('App\Reply', 2)->create(['thread_id' => $thread2Replies->id]);

        $thread3Replies = factory('App\Thread')->create();
        factory('App\Reply', 3)->create(['thread_id' => $thread3Replies->id]);

        $thread0Replies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = factory('App\Thread')->create();
        $total = 2;

        $reply = factory('App\Reply', $total)->create(['thread_id' => $thread]);

        $response = $this->get($thread->path() .'/replies')->decodeResponseJson();

        $this->assertEquals($total, $response['total']);
    }

    public function test_a_user_can_filter_threads_which_are_unanswered()
    {
        $thread = factory('App\Thread')->create();
        factory('App\Reply')->create(['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }
}
