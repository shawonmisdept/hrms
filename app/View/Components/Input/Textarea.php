<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;
    public $label;
    public $required;
    public $rows;

    public function __construct($name, $label = '', $required = false, $rows = 3)
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('components.input.textarea');
    }
}