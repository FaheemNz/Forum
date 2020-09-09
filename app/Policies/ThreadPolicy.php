<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    // Mocking Admin
    public function before(User $user)
    {
        if( $user->name == 'Faheem Nawaz' ){
            return true;
        }
    }

    public function delete(User $user, $thread)
    {
        return $user->id == $thread->user_id;
    }
}
