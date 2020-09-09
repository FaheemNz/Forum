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

    public function test_guess_may_not_create_threads()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads', [])->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_delete_his_threads()
    {
        $this->signIn();

        $user = factory('App\User')->create();

        $threadByMe = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $threadNotByMe = factory('App\Thread')->create(['user_id' => $user->id]);
        
        $reply = factory('App\Reply')->create(['thread_id' => $threadByMe->id]);

        $this->delete($threadByMe->path());
        $this->delete($threadNotByMe->path());

        $this->assertDatabaseMissing('threads', ['id' => $threadByMe->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseHas('threads', ['id' => $threadNotByMe->id]);

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

    public function test_guest_can_not_delete_thread()
    {
        $thread = factory('App\Thread')->create();

        $this->delete($thread->path())
            ->assertRedirect('/login');
    }
}
