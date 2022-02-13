<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubmitButton extends Component
{
    public $method;
    public $action;
    public $theme;
    public $icon;
    public $label;
    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $method = '',
        string $action = '',
        string $theme = '',
        string $icon = '',
        string $label = '',
        string $type = ''
    )
    {
        $this->method = $method;
        $this->action = $action;
        $this->theme = $theme;
        $this->icon = $icon;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.submit-button');
    }
}
