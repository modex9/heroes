<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;

    public $label;

    public $required;

    public $value;

    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $type, $value = '', $required = true)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input.input');
    }
}
