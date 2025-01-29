<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutFormRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'billing_address' => 'required|string',
        ];

        if ($this->input('same_billing') == false) { // When different shipping address is provided
            $rules += [
                'shipping_address' => 'required|string',
                's_name' => 'required|string',
                's_email' => 'required|email',
                's_phone' => 'required|string',
                's_address' => 'required|string',
                's_locality' => 'required|string',
                's_landmark' => 'nullable|string',
                's_postal' => 'required|string',
                's_house_name' => 'nullable|string',
                's_house_no' => 'nullable|string',
                's_state' => 'required|string',
            ];
        }

        return $rules;
    }

    /**
     * Get the custom validation messages.
     */
    public function messages(): array
    {
        return [
            'billing_address.required' => 'The billing address is required.',
            'shipping_address.required' => 'The shipping address is required.',
            's_name.required' => 'The recipient’s name is required.',
            's_email.required' => 'The recipient’s email is required.',
            's_email.email' => 'Please enter a valid email address.',
            's_phone.required' => 'The recipient’s phone number is required.',
            's_address.required' => 'The recipient’s address is required.',
            's_locality.required' => 'The locality is required.',
            's_postal.required' => 'The postal code is required.',
            's_state.required' => 'The state is required.',
        ];
    }
}
