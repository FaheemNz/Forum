<?php

namespace Tests\Feature;

use Tests\TestCase;

class FavoritesTest extends TestCase
{
    public function test_guest_can_not_favorite_any_reply()
    {
        $this->post("replies/1/favorites")->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = factory('App\Reply')->create();

        $response = $this->post("/replies/{$reply->id}/favorites");

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_can_favorite_the_reply_only_one_time()
    {
        $this->signIn();

        $reply = factory('App\Reply')->create();

        try {
            $this->post("replies/{$reply->id}/favorites");
            $this->post("replies/{$reply->id}/favorites");
        } catch (\Exception $e) {
        }

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();

        $reply = factory('App\Reply')->create();

        $this->post("replies/{$reply->id}/favorites");
        $this->assertCount(1, $reply->favorites);

        $this->delete("/replies/{$reply->id}/favorites");
        $this->assertCount(0, $reply->fresh()->favorites);
        $this->assertDatabaseMissing('favorites', ['id' => $reply->id]);
    }
}
