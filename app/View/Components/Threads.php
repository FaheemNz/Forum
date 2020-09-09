<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Threads extends Component
{
    public $threads;
    public $title;

    public function __construct($threads, $title = null)
    {
        $this->threads = $threads;
        $this->title = $title;
    }

    public function render()
    {
        return view('components.threads');
    }
}
