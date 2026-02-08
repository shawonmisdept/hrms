<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public $name;
    public $label;
    public $type;
    public $required;

    public function __construct($name, $label = '', $type = 'text', $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.input.text');
    }
}
