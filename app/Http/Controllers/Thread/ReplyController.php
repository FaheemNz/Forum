<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use App\Services\ReplyService;
use App\Reply;
use App\Thread;

class ReplyController extends Controller
{
    private ReplyService $replyService;

    public function __construct(ReplyService $replyService)
    {
        $this->replyService = $replyService;
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channel, \App\Thread $thread)
    {
        return $this->replyService->getThreadReplies($thread);
    }

    public function store(ReplyRequest $replyRequest, $channelId, Thread $thread)
    {
        $newReply = $this->replyService->addReplyToThread(
            $replyRequest->validated(),
            $channelId,
            $thread
        );

        return $newReply
            ? $newReply
            : response()->json(['message' => 'Some error occured while adding reply'], 400);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $replyDeleted = $this->replyService->deleteReplyFromThread($reply);

        return $replyDeleted
            ? response()->json(['message' => 'Reply Deleted'], 201)
            : response()->json(['message', 'Cant delete reply'], 400);
    }

    public function update(ReplyRequest $replyRequest, Reply $reply)
    {
        $this->authorize('update', $reply);

        $updatedReply = $this->replyService->updateReply($replyRequest->validated(), $reply);

        return $updatedReply
            ? response()->json([], 204)
            : response()->json(['error' => 'Cant update reply'], 401);
    }
}
