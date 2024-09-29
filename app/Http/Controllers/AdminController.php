<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'matrixno' => 'required|string|max:255',
            'fingerprint_id' => 'required|exists:fingerprint_id,fingerprint_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->matrixno = $request->matrixno;
        $user->fingerprint_id = $request->fingerprint_id;

        if ($request->hasFile('image')) {
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Fetch all available fingerprint IDs
        $allFingerprintIds = DB::table('fingerprint_id')->pluck('fingerprint_id');
    
        // Get the used fingerprint IDs from the 'users' table
        $usedFingerprintIds = User::pluck('fingerprint_id')->toArray();
    
        // Filter out the used fingerprint IDs
        $availableFingerprintIds = $allFingerprintIds->diff($usedFingerprintIds);

        return view('admin.edit', compact('user'),['fingerprintIds' => $availableFingerprintIds]);
    }

    public function staff_edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.staff_edit', compact('user'));
    }

    public function updatedata(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'matrixno' => 'required|string|max:255',
            // Add other validations as needed
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->matrixno = $request->input('matrixno');

        if ($request->hasFile('image')) {
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }
}
