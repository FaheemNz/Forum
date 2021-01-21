<?php

namespace App\Listeners;

use App\Events\OnThreadRecievesNewReply;
use App\Notifications\UserWasMentioned;
use App\User;

class OnThreadRecievesNewReplyMentionUsersListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OnThreadRecievesNewReply $event)
    {
        $mentionedNames = $event->reply->getMentionedUsersInReply($event->validatedReplyText);

        if (!$mentionedNames) return;

        User::whereIn('name', $mentionedNames)
            ->get()
            ->each(fn ($user) => $user->notify(new UserWasMentioned($event->reply)));
    }
}
