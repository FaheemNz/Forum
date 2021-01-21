<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnThreadRecievesNewReply
{
    use Dispatchable, SerializesModels;

    public $reply;
    public $validatedReplyText;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Reply $reply, string $replyText = null)
    {
        $this->reply = $reply;
        $this->validatedReplyText = $replyText;
    }
}
