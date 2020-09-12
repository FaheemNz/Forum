<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    /**
     * @group Thread 
     */
    public function test_an_authenticated_user_can_create_new_thread()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $response = $this->post('/threads', $thread->toArray());

        // if we just do $threads->path(), we don't get the primary key as we are calling make instead of create
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

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