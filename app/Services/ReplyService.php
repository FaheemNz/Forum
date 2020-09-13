<?php

namespace App\Services;

use App\Events\OnThreadRecievesNewReply;
use App\Reply;

class ReplyService
{
    public function getThreadReplies(\App\Thread $thread)
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
    public function addReplyToThread($replyRequest, $channelId, \App\Thread $thread): Reply
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
     * 
     * @param Reply $reply
     * 
     * @return Boolean
     */
    public function deleteReplyFromThread(Reply $reply)
    {
        return $reply->delete();
    }

    /**
     * Update a reply from a Thread
     * 
     * @param ReplyRequest->validated $replyRequest
     * @param Reply $reply
     * 
     * @return Boolean
     */
    public function updateReply($replyRequest, Reply $reply)
    {
        return $reply->update($replyRequest);
    }
}
