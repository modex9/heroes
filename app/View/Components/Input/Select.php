<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;

    public $label;

    public $required;

    public $options;

    public $optionValue;

    public $optionKey;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $options, $optionValue, $optionKey = 'id', $required = true)
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionKey = $optionKey;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input.select');
    }
}
