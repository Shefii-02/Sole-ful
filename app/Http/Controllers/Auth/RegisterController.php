<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Myaddress;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo =  '/account';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10,12}$/', 'unique:users,mobile'],
            'password' => ['required', 'string', 'min:8'],
            'address' => ['required', 'string', 'max:255'],
            'postalcode' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
        ], $this->messages());
    }

    /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'This email address is already registered.',
            'mobile.required' => 'The mobile number field is required.',
            'mobile.regex' => 'The mobile number must be between 10 and 12 digits.',
            'mobile.unique' => 'This mobile number is already registered.',
            'password.required' => 'The password field is required.',
            'address.required' => 'The address field is required.',
            'postalcode.required' => 'The postal code field is required.',
            'city.required' => 'The city field is required.',
            'state.required' => 'The state field is required.',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
        // Save user address
        Myaddress::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'name' => $data['email'],
            'mobile' => $data['mobile'],
            'address' => $data['address'],
            'pincode' => $data['postalcode'],
            'locality' => $data['city'],
            'state' => $data['state'],
            'country' => 'India',
            'base' => 1,
        ]);

        // Force login the user after registration
        // Auth::login($user);

        // Check for redirection URL
        if (!empty($data['redirection_url']) && filter_var($data['redirection_url'], FILTER_VALIDATE_URL)) {
            $this->redirectTo = $data['redirection_url'];
        }

        return $user;
    }
}
