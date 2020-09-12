<?php

namespace App\Services;

use App\Notifications\ThreadWasUpdated;
use App\Reply;
use App\Thread;

class ReplyService
{
    public function getThreadReplies(Thread $thread)
    {
        return $thread->replies()->paginate();
    }

    /**
     * Add a Reply to a Thread
     * 
     * @param ReplyRequest $replyRequest
     * @param Channel $channelId
     * @param Integer $threadId
     */
    public function addReplyToThread($replyRequest, $channelId, int $threadId): Reply
    {
        $reply = Thread::findOrFail($threadId)
            ->replies()
            ->create([
                'body' => $replyRequest['body'],
                'user_id' => auth()->user()->id,
            ]);

        return $reply->load('user:id,name');
    }

    /**
     * Delete a reply from a Thread
     * @param Reply $reply
     * @return Boolean
     */
    public function deleteReplyFromThread($reply)
    {
        return $reply->delete();
    }

    /**
     * Update a reply from a Thread
     * @param Reply $reply
     * @return Boolean
     */
    public function updateReply($replyRequest, $reply)
    {
        return $reply->update($replyRequest);
    }
}
