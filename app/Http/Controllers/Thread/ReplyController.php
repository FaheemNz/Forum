<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use App\Services\ReplyService;

class ReplyController extends Controller
{
    private ReplyService $replyService;

    public function __construct(ReplyService $replyService)
    {
        $this->replyService = $replyService;
    }

    public function store(ReplyRequest $replyRequest, $channelId, int $threadId)
    {
        $replyAddedToThread = $this->replyService->addReplyToThread(
            $replyRequest->validated(),
            $channelId,
            $threadId
        );

        return $replyAddedToThread
            ? redirect()->back()->with('success', 'Reply added to the Thread')
            : redirect()->back()->withErrors(__('messages.alerts.error'));
    }
}
