<?php

namespace App\Http\Controllers;

use App\Thread;

class SearchController extends Controller
{
    public function index()
    {
        $threads = Thread::search(request('q'))->paginate();
        return view('threads.index', compact('threads'));
    }
}
