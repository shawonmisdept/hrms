<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Date extends Component
{
    public $name;
    public $label;
    public $required;

    public function __construct($name, $label = '', $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.input.date');
    }
}