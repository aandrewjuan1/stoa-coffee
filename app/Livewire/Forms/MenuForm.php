<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class MenuForm extends Form
{
    #[Validate('required|in:hot,iced')]
    public ?string $temperature;

    #[Validate('required|in:16oz,22oz')]
    public ?string $size;

    #[Validate('required|in:not sweet,less sweet,regular sweetness')]
    public ?string $sweetness;

    #[Validate('required|in:whole milk,non-fat milk,sub soymilk,sub coconutmilk')]
    public ?string $milk;

    #[Validate([
        'espresso' => 'nullable|array',
        'espresso.*' => 'in:decaf,add shot'])]
    public ?array $espresso = [];

    #[Validate([
        'syrup' => 'nullable|array',
        'syrup.*' => 'in:add vanilla syrup,add caramel syrup,add hazelnut syrup,add salted caramel syrup'])]
    public ?array $syrup = [];

    #[Validate('nullable|string|max:255')]
    public ?string $special_instructions;
}
