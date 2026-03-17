<?php

// This controller handles the registration, login, and deletion of users
// Currently, not in use as this functionality is being handled in the LiveWire component, 
// but it can be used for reference or future use.

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    // This method handles the registration of a new user
    public function register(Request $request) {
        $incomingFields = $request->validate([
            'name' => ['required', 'min: 3', 'max:255', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        auth()->login($user);

        return redirect('/');
    }

    // This method handles the login of a user
    public function login(Request $request) {
        $incomingFields = $request->validate([
            'login-name' => ['required', 'min: 3', 'max:255'],
            'login-password' => ['required']
        ]);

        if (auth()->attempt(['name' => $incomingFields['login-name'], 'password' => $incomingFields['login-password']])) {
            $request->session()->regenerate();
            return redirect('/');
        }

        // If we get here, the login failed redirect back with a custom error message for the 'login-name' field.
        return back()->withErrors([
            'login-name' => 'The provided credentials do not match our records.',
        ])->onlyInput('login-name'); // This keeps the username in the input box for the user
    }

    // This method handles the logout of a user
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
