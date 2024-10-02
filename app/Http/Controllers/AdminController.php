<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Event_History;


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
            'fingerprint_id' => 'nullable|required|exists:fingerprint_id,fingerprint_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);

        // Update user data
        $user->name = strtoupper($request->name);
        $user->email = $request->email;
        $user->matrixno = strtoupper($request->matrixno);
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
        $usedFingerprintIds = User::where('id', '!=', $id)->pluck('fingerprint_id')->toArray(); // Exclude current user's ID
    
        // Filter out the used fingerprint IDs
        $availableFingerprintIds = $allFingerprintIds->diff($usedFingerprintIds);
    
        // Ensure the current user's fingerprint ID is included in the available IDs
        if ($user->fingerprint_id && !$availableFingerprintIds->contains($user->fingerprint_id)) {
            $availableFingerprintIds->push($user->fingerprint_id);
        }
    
        return view('admin.edit', compact('user'), ['fingerprintIds' => $availableFingerprintIds]);
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
        $user->name = strtoupper($request->input('name'));
        $user->email = $request->input('email');
        $user->name = strtoupper($request->input('matrixno'));;

        if ($request->hasFile('image')) {
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    public function event_view()
    {
        // Retrieve all current events, ordered by the latest time held
        $events = Event::all();
        $event_historys = Event_History::all();
        return view('admin.event',['events' => $events,'event_historys'=>$event_historys]); // Adjust to match your actual view path
    }

    public function event_store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'event' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'time_held' => 'required|date', // Ensures a valid date-time is entered
        ]);

        // Create a new event record
        Event::create([
            'name' => strtoupper($validatedData['event']),
            'location' => strtoupper($validatedData['location']),
            'time_held' => strtoupper($validatedData['time_held']),
        ]);

        // Redirect to a success page or back to the form
        return redirect()->route('event-management')->with('success', 'Event created successfully.');
    }

    // End event: move to 'event_history' table and remove from 'events' table
    public function event_end($id)
    {
        // Find the event by ID
        $event = Event::findOrFail($id);

        // Move the event to 'Event_History' table
        Event_History::create([
            'name' => $event->name,
            'location' => $event->location,
            'time_held' => $event->time_held,
        ]);

        // Delete the event from the 'events' table
        $event->delete();

        return redirect()->back()->with('success', 'Event has been successfully ended and moved.');
    }

    // Terminate event: simply delete from 'events' table
    public function event_terminate($id)
    {
        // Find the event by ID
        $event = Event::findOrFail($id);
    
        // Delete the event
        $event->delete();
    
        return redirect()->back()->with('success', 'Event has been successfully terminated.');
    }

}
