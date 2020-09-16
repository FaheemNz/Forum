<?php

namespace Tests\Feature;

use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    public function test_an_authenticated_user_can_mention_other_users_in_a_reply()
    {
        $userA = factory('App\User')->create(['name' => 'UserA']);
        $this->signIn($userA);
        $userB = factory('App\User')->create(['name' => 'UserB']);
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create(['body' => '@UserB is mentioned']);
        $response = $this->json('POST', $thread->path() . '/replies', $reply->toArray());
        
        $this->assertCount(1, $userB->notifications);
    }
}
