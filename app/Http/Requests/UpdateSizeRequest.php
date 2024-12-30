<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSizeRequest extends FormRequest
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
            'size_value' => ['required', 'string', 'max:255'],
            'size_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sizes')->ignore($this->route('size')), // Adjust 'size' based on your route parameter name
            ],
            'display_order' => ['required', 'integer'],
        ];
    }
}
