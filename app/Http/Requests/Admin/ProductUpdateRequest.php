<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:255', 'unique:products,code,'.$this->route('product')->id],
            'model' => ['nullable', 'string', 'max:255'],
            'stock_amount' => ['required', 'integer', 'min:0'],
            'regular_amount' => ['required', 'numeric', 'min:0'],
            'selling_amount' => ['required', 'numeric', 'min:0', 'lt:regular_amount'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'long_description' => ['nullable', 'string'],
            'featured_image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:5'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'remove_gallery_images' => ['nullable', 'array'],
            'remove_gallery_images.*' => [
                'integer',
                Rule::exists('product_images', 'id')->where('product_id', $this->route('product')->id),
            ],
            'featured_status' => ['sometimes', 'in:featured,not_featured'],
            'status' => ['sometimes', 'in:published,unpublished'],
        ];
    }
}
