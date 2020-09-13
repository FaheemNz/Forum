<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    public function test_a_notification_is_added_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = factory('App\Thread')->create()->subscribe();
        $this->assertCount(0, auth()->user()->notifications);
        
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Hello World'
        ]);

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => factory('App\User')->create()->id,
            'body' => 'Hello World'
        ]);
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function test_an_authenticated_user_can_mark_a_notification_as_read()
    {
        factory(DatabaseNotification::class)->create();

        tap(auth()->user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);
            $this->delete("/profiles/{$user->name}/notifications/{$user->unreadNotifications->first()->id}");
            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }

    public function test_a_user_can_fetch_their_unread_notifications()
    {
        factory(DatabaseNotification::class)->create();
        $this->assertCount(1, $this->getJson("/profiles/auth()->user()->name}/notifications")->json());
    }
}
