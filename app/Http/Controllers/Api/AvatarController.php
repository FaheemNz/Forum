<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;

class AvatarController extends Controller
{
    public function store(AvatarRequest $avatarRequest)
    {
        auth()->user()->update([
            'avatar_path' => $avatarRequest->file('avatar')->store('avatars', 'public')
        ]);

        return response('', 204);
    }
}
