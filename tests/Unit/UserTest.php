<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_a_user_can_fetch_their_most_recent_reply()
    {
        $user = factory('App\User')->create();
        $reply = factory('App\Reply')->create(['user_id' => $user->id]);
        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    public function test_a_user_can_has_a_default_image()
    {
        $user = factory('App\User')->create();
        $this->assertEquals($user->avatar_path, asset('avatars/Default.png'));
    }
    
    public function test_a_user_can_update_their_image()
    {
        $user = factory('App\User')->create();
        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals($user->avatar_path, asset('avatars/me.jpg'));
    }
}
