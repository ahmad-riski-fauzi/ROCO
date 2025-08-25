<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchBar extends Component
{
    public $action;

    public function __construct($action = '/posts/search')
    {
        $this->action = $action;
    }

    public function render()
    {
        return view('components.search-bar');
    }
}
