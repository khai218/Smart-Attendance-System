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
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function test(): View
    {
        $fingerprintIds = DB::table('fingerprint_id')->pluck('fingerprint_id');
        return view('simple', compact('fingerprintIds')); // Test with a simple view
    }

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
        // Validate the name, matrix number, email, fingerprint ID, and image fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'matrixno' => ['required', 'string', 'max:255','unique:users,matrixno'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'fingerprint_id' => 'required|exists:fingerprint_id,fingerprint_id', // Validate against the fingerprint table
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);

        // Set a default password
        $defaultPassword = 'password123'; // Consider making this more secure

        // Handle the image upload and store it in the 'public/images' folder
        $imagePath = null; // Initialize the variable
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public'); // Store the image and get the path
        }

        // Create the user with the default password and fingerprint_id
        $user = User::create([
            'name' => $request->name,
            'matrixno' => $request->matrixno,
            'email' => $request->email,
            'fingerprint_id' => $request->fingerprint_id, // Include fingerprint_id
            'password' => Hash::make($defaultPassword), // Hash the default password
            'image' => $imagePath // Store the image path in the database
        ]);

        // Trigger the registered event
        event(new Registered($user));

        // Optional: create a related user activity table or any custom behavior
        $this->createUserActivityTable($user->matrixno);

        // Redirect to the admin dashboard with a success message
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

    // Handle image upload
    public function uploadImage(Request $request, $userId): RedirectResponse
    {
        // Validate the uploaded image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure it's an image
        ]);

        $user = User::findOrFail($userId);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->get(); // Get the binary data
            $user->image = $image; // Save the binary data in the 'image' column
            $user->save();
        }

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }
}
