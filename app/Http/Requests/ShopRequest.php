<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rng.method' => ['required', Rule::in(['rand', 'lcg'])],
            'rng.seed' => 'integer|required',
            'price.min' => 'integer|required',
            'price.max' => 'integer|required',
            'num_items' => 'integer|required',
        ];
    }
}
