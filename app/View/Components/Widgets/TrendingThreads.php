<?php

namespace App\View\Components\Widgets;

use App\Utils\RedisTrending;
use Illuminate\View\Component;

class TrendingThreads extends Component
{
    public string $customClass;

    public function __construct(string $class)
    {
        $this->customClass = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $trendingThreads = (new RedisTrending())->get();
        return view('components.widgets.trending-threads', compact('trendingThreads'),);
    }
}
