<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BlandLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Add any initialization code here if necessary
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Return the view for this component
        return view('layouts.bland-layout');
    }
}
