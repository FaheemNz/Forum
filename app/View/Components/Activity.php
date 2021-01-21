<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Activity extends Component
{
    public $activities;

    public function __construct($activities)
    {
        $this->activities = $activities;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.activity');
    }
}
