<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function update(User $user, $reply)
    {
        return $user->id == $reply->user_id;
    }
}
