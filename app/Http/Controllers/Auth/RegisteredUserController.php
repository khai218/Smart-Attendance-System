<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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

        $this->createUserActivityTable($user->matrixno);
          
        // Redirect to admin dashboard with a success message
        return redirect()->route('admin.dashboard')->with('success', 'User registered successfully with default password.');
    }

    /**
     * Create a table for the user based on their matrix number
     */
    private function createUserActivityTable($matrixno)
    {
        $tableName = 'user_' . $matrixno;

        // Check if the table does not exist, then create it
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('activity');
                $table->string('place');
                $table->timestamps();
            });
        }
    }

    // New staff registration view
    public function staffRegistrationForm(): View
    {
        return view('admin.staff_registration');
    }

    // Handle staff registration
    public function registerStaff(Request $request): RedirectResponse
    {
        // Validate the staff name and email fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        // Create a staff user with default password and role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('staff123'), // Default password for staff
            'role' => 'agent', // Set role as agent
            'email_verified_at' => now(), // Immediately verify the email
        ]);

        event(new Registered($user));

        return redirect()->route('admin.dashboard')->with('success', 'Staff registered successfully.');
    }
}
