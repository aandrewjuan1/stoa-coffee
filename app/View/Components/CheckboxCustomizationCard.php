<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxCustomizationCard extends Component
{
    public $label;
    public $name;
    public $options;
    public $required;

    public function __construct($label, $name, $options, $required = false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.checkbox-customization-card');
    }
}

