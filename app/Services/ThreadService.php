<?php 

namespace App\Services;

use App\Thread;
use App\Reply;

class ThreadService
{
    public function getThreads()
    {
        return Thread::all(['id', 'title', 'body']);
    }

    public function getThread(int $id)
    {
        return Thread::findOrFail($id);
    }
}