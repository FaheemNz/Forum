<?php

namespace App\Http\Controllers\Thread;

use App\Filters\ThreadFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateThreadRequest;
use App\Services\ThreadService;
use App\Utils\RedisTrending;

class ThreadController extends Controller
{
    protected ThreadService $threadService;

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
        try {
            $newThread = $this->threadService->createThread($createThreadRequest->validated());
            return redirect($newThread->path())->with('flash', 'New thread has been created.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('You already have a thread with the same title.');
        }
    }

    public function show($channelId, \App\Thread $thread, RedisTrending $redisTrending)
    {
        $thread = $this->threadService->getThread($thread);
        $redisTrending->push($thread);
        return view('threads.show', compact('thread'));
    }

    public function destroy($channel, \App\Thread $thread, RedisTrending $redisTrending)
    {
        $this->authorize('delete', $thread);

        $redisTrending->remove($thread);
        $this->threadService->deleteThread($thread);

        return redirect('/threads')->with('flash', 'Thread Deleted!');
    }
}
