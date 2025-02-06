<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DeliveryPincode; // Import your model

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
        ];

        // if ($this->input('same_billing') == false) { // If different shipping address is provided
            $rules += [
                'shipping_address' => 'required|string',
                's_name' => 'required|string',
                's_email' => 'required|email',
                's_phone' => 'required|string',
                's_address' => 'required|string',
                's_locality' => 'required|string',
                's_landmark' => 'nullable|string',
                's_postal' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        // Fetch the DeliveryPincode record
                        $record = DeliveryPincode::where('pincode', $value)->first();
                        if (!$record) {
                            return $fail('Sorry, we are unable to deliver to this pincode at the moment.');
                        }
                        // Check if the provided state matches the one in the database
                        if ($record->state !== $this->input('s_state')) {
                            return $fail('The provided state does not match the postal code.');
                        }
                    },
                ],
                's_house_name' => 'nullable',
                's_house_no' => 'nullable',
                's_state' => 'required|string',
            ];
        // }

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
