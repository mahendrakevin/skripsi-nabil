<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $method;
    public $action;
    public $class;
    public $icon;
    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $method = '',
        string $action = '',
        string $class = '',
        string $icon = '',
        string $title = '',
    )
    {
        $this->method = $method;
        $this->action = $action;
        $this->class = $class;
        $this->icon = $icon;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
