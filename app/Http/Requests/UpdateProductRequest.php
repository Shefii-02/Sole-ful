<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        // Get the current product ID (if editing)
        $productId = $this->route('product') ? $this->route('product') : null;

        $rules = [
            'product_name' => ['required', 'string', 'max:255'],
            'art_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId),
            ],
            'product_no' => [
                'required',
                'string',
                Rule::unique('products')->ignore($productId),
            ],
        ];

        if ($this->has('has_variants') && $this->has_variants === 'active') {
            // Validation for variants
            $rules['variants_sku'] = ['required', 'array'];
            $rules['variants_sku.*'] = [
                'required',
                'string',
                'distinct',
                Rule::unique('product_variants', 'sku')->ignore($productId, 'product_id'),
            ];
            $rules['variants_price'] = ['required', 'array'];
            $rules['variants_price.*'] = ['required', 'string', 'min:0'];
            $rules['variants_stock'] = ['required', 'array'];
            $rules['variants_stock.*'] = ['required', 'integer', 'min:0'];
        } else {
            // Validation for single product
            $rules['product_sku_single'] = [
                'required',
                'string',
                Rule::unique('product_variants', 'sku')->ignore($productId, 'product_id'),
            ];
            $rules['product_price_single'] = ['required', 'string', 'min:0'];
            $rules['product_stock_single'] = ['required', 'integer', 'min:0'];
        }

        return $rules;
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'product_name.required' => 'The product name is required.',
            'art_code.required' => 'The art code is required.',
            'art_code.unique' => 'This art code already exists in the database.',
            'product_no.required' => 'The product number is required.',
            'product_no.unique' => 'This product number already exists.',
            'variants_sku.*.distinct' => 'Duplicate variant SKUs are not allowed.',
            'variants_sku.*.unique' => 'This variant SKU already exists.',
            'variants_price.*.required' => 'Each variant must have a price.',
            'variants_price.*.integer' => 'Variant prices must be integers.',
            'variants_stock.*.required' => 'Each variant must have a stock quantity.',
        ];
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'product_name' => trim($this->product_name),
            'art_code' => trim($this->art_code),
            'product_no' => trim($this->product_no),
        ]);
    }
}
