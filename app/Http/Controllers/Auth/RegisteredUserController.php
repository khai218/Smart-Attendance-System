<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('admin.registration');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the name, matrix number, and email fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'matrixno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);

        // Set a default password
        $defaultPassword = 'password123'; // Change this to a more secure default or generate dynamically if needed

        // Create the user with the default password
        $user = User::create([
            'name' => $request->name,
            'matrixno' => $request->matrixno,
            'email' => $request->email,
            'password' => Hash::make($defaultPassword), // Hash the default password
        ]);

        // Trigger the registered event
        event(new Registered($user));

        // Optionally, do not log in the user if it's admin registration
        // Auth::login($user);

        // Redirect to admin dashboard with a success message
        return redirect()->route('admin.dashboard')->with('success', 'User registered successfully with default password.');
    }
}

