<?php

namespace App\Listeners;

use App\Events\OnThreadRecievesNewReply;
use App\Notifications\ThreadWasUpdated;

class OnThreadRecievesNewReplySubscribeUsersListener
{
    /**
     * Handle the event.
     *
     * @param  OnThreadRecievesNewReply $event
     * @return void
     */
    public function handle(OnThreadRecievesNewReply $event)
    {
        $subscriptions = $event->reply->thread->subscriptions;

        if (!$subscriptions) return;

        $subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each(fn ($subscription) => $subscription->user->notify(new ThreadWasUpdated($event->reply->thread, $event->reply)));
    }
}
