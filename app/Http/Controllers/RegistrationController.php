<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // importing Models

class RegistrationController extends Controller
{

    function register()
    {
        return view('register');
    }

    function postRegistrationData(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'telephone' => 'required',
            'email' => 'required | unique:users',
            'password' => 'required',
            'cpassword' => 'required',
            'image' => 'required'
        ]);
        $user = new User(); // model name
        $user->username = $request->username;
        $user->phone_number = $request->telephone;
        $user->email = $request->email;
        $user->is_email_verified = 'yes';
        $user->password = $request->password;
        $user->confirm_password = $request->cpassword;
        // image start
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('user_images/', $filename);
            $user->avatar = $filename;
        }
        // image end
        $req = $user->save();
        if ($req) {
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('fail', 'Something Wrong');
        }
    }
}
