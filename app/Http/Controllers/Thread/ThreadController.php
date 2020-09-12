<?php

namespace App\Http\Controllers\Thread;

use App\Filters\ThreadFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateThreadRequest;
use App\Services\ThreadService;
use App\Thread;

class ThreadController extends Controller
{
    private ThreadService $threadService;

    public function __construct(ThreadService $threadService)
    {
        $this->threadService = $threadService;
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(\App\Channel $channel, ThreadFilters $threadFilters)
    {
        $threads = $this->threadService->getThreads($channel, $threadFilters);

        return request()->expectsJson()
            ? $threads
            : view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(CreateThreadRequest $createThreadRequest)
    {
        $threadCreated = $this->threadService->createThread($createThreadRequest->validated());

        return $threadCreated
            ? redirect($threadCreated->path())->with('flash', 'New Thread has been created')
            : redirect()->back()->withErrors(__('messages.alerts.error'));
    }

    public function show($channelId, int $id)
    {
        $thread = $this->threadService->getThread($id);
        return view('threads.show', compact('thread'));
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $isThreadDeleted = $this->threadService->deleteThread($thread);

        if (request()->wantsJson()) {
            return $isThreadDeleted
                ? response([], 204)
                : response(['error' => 'Thread was not deleted. Some error occured.'], 401);
        }

        return $isThreadDeleted
            ? redirect('/threads')->with('flash', 'Thread Deleted!')
            : redirect()->back()->with('flash', 'Cant delete thread!');
    }
}
