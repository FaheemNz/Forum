<?php

namespace App\Services;

use App\Thread;

class ThreadService
{
    public function getThreads($channel, $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate();
    }

    public function getThread(int $id): Thread
    {
        return Thread::customSelect()->findOrFail($id);
    }

    public function createThread($createThreadRequest): Thread
    {
        return Thread::create(
            [
                'user_id' => auth()->user()->id,
                'title' => $createThreadRequest['title'],
                'body' => $createThreadRequest['body'],
                'channel_id' => $createThreadRequest['channel_id']
            ]
        );
    }

    public function deleteThread($thread)
    {
        // Replies associated with the thread will also be deleted via onDelete Cascade constraint
        return $thread->delete();
    }
}
