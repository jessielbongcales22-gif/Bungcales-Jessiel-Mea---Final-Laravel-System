<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        try {
            // Validation with custom error messages
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'address' => ['required', 'string', 'max:500'],
            ]);

            // Saving to MySQL Database
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($request->password), 
                'address' => $validated['address'],
                'role' => 'customer',
            ]);

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Account created successfully! Welcome to Water Market.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // Let Laravel handle validation errors
        } catch (\Exception $e) {
            // Handle unexpected database or system errors
            return back()->withInput()->with('error', 'An unexpected error occurred during registration. Please try again later.');
        }
    }
}
