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

    /**
     * @param $id $threadId
     */
    public function store(ReplyRequest $replyRequest, int $id)
    {
        if($this->replyService->addReplyToThread($replyRequest->validated(), $id)){
            return redirect()->back()->with('success', __('messages.alert.success'));
        }

        return redirect()->back()->with('error', __('messages.alert.error'));
    }
}
