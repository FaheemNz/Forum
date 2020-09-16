<?php

namespace App\Services;

use App\Thread;

class ThreadService
{
    public function getThreads($channel, $filters)
    {
        $threads = Thread::customSelect(['id', 'user_id', 'title', 'slug', 'created_at', 'channel_id', 'replies_count'])
            ->latest()
            ->filter($filters);

        // If filtering thread by channels
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate();
    }

    public function getThread(Thread $thread): Thread
    {
        return $thread->append('isSubscribedTo');
    }

    public function createThread($createThreadRequest): Thread
    {
        $title = $createThreadRequest['title'];
        return Thread::create(
            [
                'user_id' => auth()->user()->id,
                'title' => $title,
                'body' => $createThreadRequest['body'],
                'channel_id' => $createThreadRequest['channel_id'],
                'slug' => $createThreadRequest['title']
            ]
        );
    }

    public function deleteThread($thread)
    {
        // Replies associated with the thread will also be deleted via onDelete Cascade constraint
        return $thread->delete();
    }
}
