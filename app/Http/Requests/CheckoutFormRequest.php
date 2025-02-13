<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DeliveryPincode; // Import the DeliveryPincode model

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
     */
    public function rules(): array
    {
        $rules = [
            'billing_address' => 'required|string',
            'payment_method' => 'required|in:cod,online',
            's_name' => 'required|string',
            's_email' => 'required|email',
            's_phone' => 'required|string',
            's_address' => 'required|string',
            's_locality' => 'required|string',
            's_landmark' => 'nullable|string',
            's_house_name' => 'nullable|string',
            's_house_no' => 'nullable|string',
            's_state' => 'required|string',
            's_postal' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $normalizedPincode = strtoupper($value); // Convert input to uppercase
                    $record = DeliveryPincode::whereRaw('BINARY pincode = ?', [$normalizedPincode])->first();

                    if (!$record) {
                        return $fail('Sorry, we are unable to deliver to this pincode at the moment.');
                    }

                    if (strtoupper($record->state) !== strtoupper($this->input('s_state'))) {
                        return $fail('The provided state does not match the postal code.');
                    }
                },
            ],
        ];

        // COD-Specific Validation (Check if COD is allowed for this pincode)
        if ($this->input('payment_method') == 'cod') {
            $rules['payment_method'] = [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $pincode = strtoupper($this->input('s_postal')); // Convert input to uppercase
                    $record2 = DeliveryPincode::whereRaw('BINARY pincode = ?', [$pincode])->first();
                    
                    if (!$record2) {
                        return $fail('Sorry, we are unable to deliver to this pincode at the moment.');
                    }

                    if (strtoupper($record2->cod) !== 'YES') {
                        return $fail('Cash on Delivery (COD) is not available for this pincode.');
                    }
                },
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
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in' => 'Invalid payment method selected.',
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
