<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FlashDealStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'ends_at' => ['required', 'date', 'after:now'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
