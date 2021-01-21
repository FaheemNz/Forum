<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
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
        
        $response = $this->post($this->thread->path() . '/replies', [
            'body' => 'Hello World this is a reply!'
        ]);
        
        dd( $response->decodeResponseJson() );
        
        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();
        $this->signIn()->thread->subscribe()->addReply([
            'body' => 'Hello',
            'user_id' => 1
        ]);
        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function test_a_thread_can_a_path()
    {
        $thread = factory('App\Thread')->create();
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->slug}",
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

    public function test_a_unique_slug_is_generated_if_two_users_create_a_thread_with_same_title()
    {
        $this->signIn();
        $threadByUser1 = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $this->signIn();
        $threadByUser2 = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $this->assertNotEquals($threadByUser1->slug, $threadByUser2->slug);
    }

    // public function test_an_error_is_thrown_if_the_same_user_creates_two_threads_with_same_title()
    // {
    //     $this->signIn();

    //     $thread1 = factory('App\Thread')->raw(['title' => 'Hello World']);
    //     $thread2 = factory('App\Thread')->raw(['title' => 'Hello World']);

    //     $this->post('/threads', $thread1)->assertSessionHasNoErrors();
    //     $this->post('/threads', $thread2);
    //     $this->get('/threads/create')->assertSee('You already have a thread with the same title.');
    // }
    
    public function test_a_thread_can_be_locked()
    {
        $this->assertFalse($this->thread->is_locked);
        $this->thread->lock();
        $this->assertTrue($this->thread->is_locked);
    }
}
