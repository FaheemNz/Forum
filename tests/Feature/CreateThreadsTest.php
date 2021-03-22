<?php

namespace Tests\Feature;

use App\Rules\RecaptchaRule;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        app()->singleton(RecaptchaRule::class, function () {
            $m = \Mockery::mock(RecaptchaRule::class);
            $m->shouldReceive('passes')->andReturn(true);
            return $m;
        });
    }

    /**
     * @group Thread 
     */
    public function test_an_authenticated_user_can_create_new_thread()
    {
        $this->signIn();

        $thread = factory('App\Thread')->make();
        
        //$response = $this->post('/threads', $thread->toArray());
        
        $response = $this->post('/threads', [
            'title' => 'Title',
            'body' => 'Body',
            'channel_id' => 1,
        ]);
        
        // if we just do $threads->path(), we don't get the primary key as we are calling make instead of create
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    // public function test_a_thread_requires_a_recaptcha()
    // {
    //     $this->signIn();
    //     unset(app()[RecaptchaRule::class]);
    //     $thread = factory('App\Thread')->raw(['g-recaptcha-response' => 'testing']);
    //     $this->post('/threads', $thread)->assertSessionHasErrors(['g-recaptcha-response']);
    // }

    /**
     * @group Thread
     */
    public function test_guess_may_not_create_threads()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads', [])->assertRedirect('/login');
    }

    /**
     * @group Thread
     */
    public function test_an_authenticated_user_can_delete_his_threads()
    {
        $this->signIn();

        factory('App\User')->create();

        $threadByMe = factory('App\Thread')->create(['user_id' => auth()->id()]);

        $reply = factory('App\Reply')->create(['thread_id' => $threadByMe->id, 'user_id' => auth()->id()]);

        $this->delete($threadByMe->path());

        $response = $this->delete("/replies/{$reply->id}");

        $this->assertDatabaseMissing('threads', ['id' => $threadByMe->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        // Delete activities as well on thread deletion
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $threadByMe->id,
            'subject_type' => get_class($threadByMe)
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);
    }

    /**
     * @group Thread
     */
    public function test_guest_can_not_delete_thread()
    {
        $thread = factory('App\Thread')->create();

        $this->delete($thread->path())
            ->assertRedirect('/login');
    }
}
