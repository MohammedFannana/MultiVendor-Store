<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Nav extends Component
{
    public $items;
    public $active;   //if not public if protected use in render revierse the construct

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items = config('nav');
        //This function get the current route name
        $this->active = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }
}
