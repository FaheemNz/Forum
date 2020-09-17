<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Thread;

class LockThreadController extends Controller
{
    public function update(Thread $thread)
    {
        if (!$lockData = request()->validate(['is_locked' => 'boolean'])) {
            return response()->json(['error' => ['message' => 'Invalid Request Parameters']], 422);
        }
        
        $thread->update(['is_locked' => $lockData['is_locked']]);
        return response('', 204);
    }
}
