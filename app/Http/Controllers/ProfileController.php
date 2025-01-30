<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function index()
    {
        return view('admin.profile.index');
    }



    public function updateProfile(Request $request)
    {
    
        // Validate incoming data
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(), // Ignore current user's email
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::where('id', auth()->id())->first() ?? abort(404); // Fetch the authenticated user

        // Update fields
  
        $user->email = $request->input('email');
        $user->name = $request->input('name');

        // Handle avatar upload
        // if ($request->hasFile('avatar')) {
        //     deleteFilefromMedia($user->avatar_id);
        //     $result = uploadFiletoMedia($request->file('avatar'), 'users');
        //     $user->avatar_id = isset($result['media_id']) ? $result['media_id'] : null;
        // }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'new_password' => 'required|min:8|confirmed', // 'confirmed' automatically checks 'new_password_confirmation'
        ]);
    
        // Check if the user is authenticated
        $user = Auth::user();
    
        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // Return a success message
        return back()->with('status', 'Password changed successfully!');
    }
    
}
