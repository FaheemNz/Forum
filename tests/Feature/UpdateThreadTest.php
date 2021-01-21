<?php

namespace Tests\Feature;

use Tests\TestCase;

class UpdateThreadTest extends TestCase
{
    public function test_a_thread_can_be_updated_by_the_user_who_created_it()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        
        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $newData = ['title' => 'New Title', 'body' => 'New Body', 'channel_id' => 1];
        $this->put($thread->path(), $newData)->assertStatus(204);
        $this->get($thread->path())->assertSee($newData['title'])->assertSee($newData['body']);
    }
    
    public function test_un_authorized_user_can_not_update_thread()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create(['user_id' => factory('App\User')->create()->id]); 
        $this->put($thread->path())->assertStatus(403);
    }
}
