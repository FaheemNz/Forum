<?php
namespace Tests\Feature;

use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    /*
    *   Thread => User subscribes => for each reply or update => User is notified via a notifier
    *   @group ThreadSubscription
    */
    public function test_an_authenicated_user_can_subscribe_to_a_thread()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->subscriptions);
    }
    public function test_an_authenicated_user_can_unsubscribe_from_a_thread()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();
        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0, $thread->subscriptions);
    }
}