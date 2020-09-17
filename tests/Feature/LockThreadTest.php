<?php

namespace Tests\Feature;

use Tests\TestCase;

class LockThreadTest extends TestCase
{
    public function test_non_admin_can_not_lock_threads()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);

        $this->put(route('thread.lock', $thread->slug), [
            'is_locked' => true
        ])->assertStatus(302);

        $this->assertFalse(!!$thread->fresh()->is_locked);
    }

    public function test_admin_can_lock_and_unlock_threads()
    {
        $this->withoutExceptionHandling();
        $this->signIn(['role' => 1]);

        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);

        $this->put(route('thread.lock', $thread->slug), [
            'is_locked' => true
        ])->assertStatus(204);
        
        $this->assertTrue(!!$thread->fresh()->is_locked);
       
        $this->put(route('thread.lock', $thread->slug), [
            'is_locked' => false
        ])->assertStatus(204);
        
        $this->assertFalse(!!$thread->fresh()->is_locked);
    }

    public function test_once_locked_a_thread_may_not_recieve_new_reply()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();
        $thread->lock();

        $response = $this->post($thread->path() . '/replies', [
            'body' => 'Hello World',
            'user_id' => factory('App\User')->create()->id
        ]);

        $response->assertStatus(422);
    }
}
