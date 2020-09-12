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
            ? response()->json(['message' => 'Favorited!'], 201)
            : response()->json(['error' => 'Cant favorite!', 400]);
    }

    public function destroy(Reply $reply)
    {
        $replyUnFavorited = $this->favoriteService->unFavoriteTheReply($reply);

        return $replyUnFavorited
            ? response()->json(['message' => 'UnFavorited!'], 201)
            : response()->json(['error' => 'Cant Unfavorite!', 400]);
    }
}
