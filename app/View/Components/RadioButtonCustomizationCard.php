<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RadioButtonCustomizationCard extends Component
{
    public $label;
    public $name;
    public $options;
    public $selected;
    public $required;

    public function __construct($label, $name, $options, $selected = null, $required = false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.radio-button-customization-card');
    }
}
