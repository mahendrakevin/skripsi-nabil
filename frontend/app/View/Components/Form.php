<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $method;
    public $action;
    public $enctype;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $method = '',
        string $action = '',
        string $enctype = ''
    )
    {
        $this->method = $method;
        $this->action = $action;
        $this->enctype = $enctype;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form');
    }
}
