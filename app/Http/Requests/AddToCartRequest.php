<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'product_price' => 'required|numeric',
            'temperature' => 'required|in:hot,iced',
            'size' => 'required|in:16oz,22oz',
            'sweetness' => 'required|in:not sweet,less sweet,regular sweetness',
            'milk' => 'required|in:whole milk,non-fat milk,sub soymilk,sub coconutmilk',
            'espresso' => 'nullable|array',
            'espresso.*' => 'in:decaf,add shot',
            'syrup' => 'nullable|array',
            'syrup.*' => 'in:add vanilla syrup,add caramel syrup,add hazelnut syrup,add salted caramel syrup',
            'special_instructions' => 'nullable|string|max:255',
        ];
    }
}
