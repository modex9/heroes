<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Button extends Component
{

    public $text;

    public $buttonClass;

    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text = 'Save', $buttonClass = 'btn btn-primary', $type = 'submit')
    {
        $this->text = $text;
        $this->buttonClass = $buttonClass;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input.button');
    }
}
