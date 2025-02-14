<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }
    public function authorize(): bool
    {
        return auth()->check(); // Ensures only logged-in users can update their address
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    // public function rules(): array
    // {
    //      return [
    //         'firstname' => 'bail|required|string|max:255',
    //         'lastname'  => 'bail|required|string|max:255',
    //         'address'   => 'bail|required',
    //         'postalcode'=> 'bail|required|max:7|min:5',
    //         'city'      => 'bail|required',
    //         'province'  => 'bail|required'
    //     ];
    // }

    //  public function messages()
    // {
    //      return [
    //         'firstname.required'    => 'The first name is required.',
    //         'lastname.required'     => 'The last name is required.',
    //         'city.required'         => 'The city is required.',
    //         'postalcode.required'   => 'The postal code is required.',
    //         'address.required'      => 'The Address is required.',
    //         'province.required'     => 'The province is required.',
    //     ];
    // }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'mobile'     => ['required', 'regex:/^(?:\+?\d{1,3})?[6789]\d{9}$/'], // Validates Indian mobile numbers
            'address'    => 'required|string|max:500',
            'locality'   => 'required|string|max:255',
            'pincode'    => 'required|string|regex:/^\d{6}$/', // Ensures a valid 6-digit postal code
            'state'      => 'required|string|max:255',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required'       => 'The name field is required.',
            'email.required'      => 'The email field is required.',
            'email.email'         => 'Please enter a valid email address.',
            'mobile.required'     => 'The mobile number is required.',
            'mobile.regex'        => 'Enter a valid mobile number',
            'address.required'    => 'The address field is required.',
            'locality.required'   => 'The locality field is required.',
            'pincode.required'    => 'The pincode field is required.',
            'pincode.regex'       => 'Enter a valid 6-digit pincode.',
            'state.required'      => 'The state field is required.',
        ];
    }
}
