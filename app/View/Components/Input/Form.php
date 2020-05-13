<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Form extends Component
{
    public $method;

    public $id;

    public $action;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $action = '', $method = 'post')
    {
        $this->id = $id;
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input.form');
    }
}
