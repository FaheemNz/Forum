<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_a_user_has_a_profile()
    {
        $this->signIn();
        $user = factory('App\User')->create();
        $response = $this->get("/profiles/{$user->name}");
        $response->assertSee($user->name);
    }

    public function test_a_user_profile_has_threads_created_by_him()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);
        $response = $this->get("/profiles/" . auth()->user()->name);
        $response->assertSee($thread->title);
    }
}
