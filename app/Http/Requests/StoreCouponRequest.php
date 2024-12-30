<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
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
       
            'code' => ['required', 'string', 'max:255', 'unique:coupons'],
            'value' => ['required', 'string'],
            'value_type' => ['required', 'string'],
            'max_count' => ['required', 'integer'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'min_sales' => ['required'],
            'status' => ['nullable'],
        ];
    }
}
