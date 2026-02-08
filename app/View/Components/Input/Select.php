<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $label;
    public $options;
    public $required;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label = '', $options = [], $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.input.select');
    }
}
