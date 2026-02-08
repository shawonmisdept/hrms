<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class File extends Component
{
    public $name;
    public $label;
    public $required;
    public $accept;

    public function __construct($name, $label = '', $required = false, $accept = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->accept = $accept;
    }

    public function render()
    {
        return view('components.input.file');
    }
}