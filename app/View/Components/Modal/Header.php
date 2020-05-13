<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class Header extends Component
{
    public $id;

    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title = '')
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal.header');
    }
}
