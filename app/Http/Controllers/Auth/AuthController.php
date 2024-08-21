<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showRegistrationForm()
    {
        $title = "Register";

        return view('auth.register', compact('title'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'unique:users',
                function ($attribute, $value, $fail) use ($request) {
                    $invitation = Invitation::where('email', $value)
                                            ->where('token', $request->invitation_code)
                                            ->first();

                    if (!$invitation) {
                        $fail('The provided invitation code is invalid or does not match the email.');
                    }
                },
            ],
            'password' => 'required|string|min:8|confirmed',
            'invitation_code' => 'required|string',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Client');

        // Marking the invitation token expired
        Invitation::where('token', $request->invitation_code)->where('email', $request->email)->update([ 'expires_at' => now() ]);

        // Log the user in
        auth()->login($user);

        return redirect()->route('client.tasks.index');
    }

    public function loginForm() {
        $title = "Login";

        return view('auth.login', compact('title'));
    }

    public function login(Request $request)
    {

        // Validating the incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'email' => ['The provided credentials are incorrect.']
                ]
            ], 422);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Return the token and user information
        return response()->json([
            'user' => $user,
            'role' => $user->roles->pluck('name')->first(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('loginForm');
    }
}
