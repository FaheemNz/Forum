<?php

namespace App\Services;

use App\Events\OnThreadRecievesNewReply;
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
     * @param Thread $thread
     */
    public function addReplyToThread($replyRequest, $channelId, $thread): Reply
    {
        $reply = $thread->replies()->create([
            'body' => $replyRequest['body'],
            'user_id' => auth()->user()->id
        ]);

        event(new OnThreadRecievesNewReply($reply));

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
