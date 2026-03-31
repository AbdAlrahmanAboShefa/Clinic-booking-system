<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country_code' => ['required', 'string', 'max:10'],
            'phone' => ['required', 'string', 'max:20'],
        ], [
            'name.required' => 'Please enter your full name',
            'name.max' => 'Name cannot exceed 255 characters',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Please enter a password',
            'password.confirmed' => 'Password confirmation does not match',
            'password.min' => 'Password must be at least 8 characters',
            'country_code.required' => 'Please select a country code',
            'phone.required' => 'Please enter your phone number',
            'phone.max' => 'Phone number cannot exceed 20 characters',
        ]);

        // Combine country code and phone number (without +)
        $fullPhone = $validated['country_code'] . $validated['phone'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $fullPhone,
        ]);

        $nameParts = explode(' ', $validated['name'], 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $user->patient()->create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $fullPhone,
            'email' => $validated['email'],
            'patient_code' => 'PT-' . strtoupper(uniqid()),
        ]);

        $user->assignRole('patient');

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
