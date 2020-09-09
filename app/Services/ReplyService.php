<?php

namespace App\Services;

use App\Thread;

class ReplyService
{
    public function addReplyToThread($replyRequest, $channelId, int $threadId)
    {
        return Thread::findOrFail($threadId)
            ->replies()
            ->create([
                'body' => $replyRequest['body'],
                'user_id' => auth()->user()->id,
            ]);
    }
}
