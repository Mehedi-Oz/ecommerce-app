<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['required', Rule::exists('sub_categories', 'id')->where('category_id', $this->input('category_id'))],
            'brand_id' => ['required', 'exists:brands,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:products,code'],
            'model' => ['nullable', 'string', 'max:255'],
            'stock_amount' => ['required', 'integer', 'min:0'],
            'regular_amount' => ['required', 'numeric', 'min:0'],
            'selling_amount' => ['required', 'numeric', 'min:0', 'lt:regular_amount'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'long_description' => ['nullable', 'string'],
            'featured_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:5'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'featured_status' => ['sometimes', 'in:featured,not_featured'],
            'status' => ['sometimes', 'in:published,unpublished'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'in:special_offer,top_rated'],
        ];
    }
}
