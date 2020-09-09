<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function store(Reply $reply)
    {
        $replyFavorited = $this->favoriteService->favoriteTheReply($reply);

        return $replyFavorited
            ? redirect()->back()->with('success', 'Reply Favorited!')
            : null;
    }
}
