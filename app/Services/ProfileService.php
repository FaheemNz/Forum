<?php

namespace App\Services;

class ProfileService
{
    public function getUserActivities($user)
    {
        return $user->activity()->latest()->with('subject')->paginate();
    }
}
