<?php

namespace App\Http\Controllers\Thread;

use App\Thread;
use App\Http\Controllers\Controller;

class ThreadSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        if ($thread->subscribe()) {
            return response()->json(['message' => 'Subscribed'], 201);
        }
    }

    public function destroy($channelId, Thread $thread)
    {
        if ($thread->unSubscribe()) {
            return response()->json(['message' => 'UnSubscribed'], 202);
        }
    }
}
