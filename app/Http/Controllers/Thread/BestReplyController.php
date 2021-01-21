<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Reply;

class BestReplyController extends Controller
{
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);
        $reply->thread->setBestReply($reply->id);
        return response('Reply marked as best', 204);
    }

    public function destroy(Reply $reply)
    {
        $reply->thread->unsetBestReply();
    }
}
