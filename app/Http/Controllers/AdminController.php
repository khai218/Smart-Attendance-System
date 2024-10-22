<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Event_History;
use App\Models\Add_Event;
use App\Models\User_Event;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_userCount = User::count(); // Assuming you have a User model
        $eventCount = Event::count(); // Assuming you have an Event model
        $event_historyCount = Event_History::count(); // Assuming you have an Event mode'

        $userCount = max(0, $total_userCount - 5);

        return view('admin.dashboard',compact('userCount', 'eventCount','event_historyCount'));
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

        return redirect()->route('registration')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $matrixno = $user->matrixno;

        $user->delete();

        Add_Event::where('matrixno', $matrixno)->delete();
        User_Event::where('matrixno', $matrixno)->delete();

        $this->user_renumberIds();
        $this->add_event_renumberIds();
        $this->user_event_renumberIds();

        return redirect()->route('registration')->with('success', 'User deleted successfully.');
    }

    private function user_event_renumberIds()
    {
    // Get all users ordered by their current ID
    $user_event = User_Event::orderBy('id')->get();
    
    // Loop through users and update IDs
    foreach ($user_event as $index => $user) {
        // Update the ID to the new position (1-based index)
        $user->id = $index + 1;
        $user->save(); // Save the updated user
        }
    }

    private function add_event_renumberIds()
    {
    // Get all users ordered by their current ID
    $add_event = Add_Event::orderBy('id')->get();
    
    // Loop through users and update IDs
    foreach ($add_event as $index => $user) {
        // Update the ID to the new position (1-based index)
        $user->id = $index + 1;
        $user->save(); // Save the updated user
        }
    }

    private function user_renumberIds()
    {
    // Get all users ordered by their current ID
    $users = User::orderBy('id')->get();
    
    // Loop through users and update IDs
    foreach ($users as $index => $user) {
        // Update the ID to the new position (1-based index)
        $user->id = $index + 1;
        $user->save(); // Save the updated user
        }
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
            'time_start' => 'required|date',
            'time_end' => 'required|date|after_or_equal:time_start', // Ensure end time is after start time
        ]);
    
        // Check for existing events with overlapping time ranges
        $existingEvent = Event::where(function ($query) use ($validatedData) {
            $query->where(function ($subQuery) use ($validatedData) {
                // Check if the new event overlaps with any existing event's time
                $subQuery->where('time_start', '<', $validatedData['time_end'])
                         ->where('time_end', '>', $validatedData['time_start']);
            })
            ->where(function ($subQuery) use ($validatedData) {
                // Ensure events with the same location and time range are not allowed regardless of name
                $subQuery->where('location', strtoupper($validatedData['location']));
            })
            ->orWhere(function ($subQuery) use ($validatedData) {
                // Ensure events with the same name, location, date, and time range are not allowed
                $subQuery->where('name', strtoupper($validatedData['event']))
                         ->where('location', strtoupper($validatedData['location']))
                         ->where('time_start', $validatedData['time_start'])
                         ->where('time_end', $validatedData['time_end']);
            });
        })->exists();
    
        if ($existingEvent) {
            return back()->withErrors(['event' => 'The event conflicts with an existing event.']);
        }
    
        // Create a new event record
        Event::create([
            'name' => strtoupper($validatedData['event']),
            'location' => strtoupper($validatedData['location']),
            'time_start' => $validatedData['time_start'], // No need to use strtoupper for date
            'time_end' => $validatedData['time_end'], // No need to use strtoupper for date
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
            'time_start' => $event->time_start,
            'time_end' => $event->time_end,
            'event_id' => $event->event_id,
        ]);

        // Delete participants with the same event_id in the add_event table
        Add_Event::where('event_id', $event->event_id)->delete();

        // Delete the event from the 'events' table
        $event->delete();

        $this->event_renumberIds();

        return redirect()->back()->with('success', 'Event has been successfully ended and moved.');
    }

    // Terminate event: simply delete from 'events' table
    public function event_terminate($id)
    {
        // Find the event by ID
        $event = Event::findOrFail($id);
    
        // Delete participants with the same event_id in the add_event table
        Add_Event::where('event_id', $event->event_id)->delete();
    
        // Delete the event
        $event->delete();
    
        // Optional: Call a method to renumber event IDs if needed
        $this->event_renumberIds();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Event has been successfully terminated along with its participants.');
    }
    

    private function event_renumberIds()
    {
    // Get all event ordered by their current ID
    $event = Event::orderBy('id')->get();
    
    // Loop through event and update IDs
    foreach ($event as $index => $user) {
        // Update the ID to the new position (1-based index)
        $user->id = $index + 1;
        $user->save(); // Save the updated user
        }
    }

    public function viewParticipants($event_id)
    {
        // Retrieve the participants by joining user_event, event_history, and users tables
        $participants = DB::table('user_event')
            ->join('event_history', 'user_event.event_id', '=', 'event_history.event_id') // Match event_id
            ->join('users', 'user_event.matrixno', '=', 'users.matrixno') // Assuming users table has matrixno
            ->where('user_event.event_id', $event_id) // Filter by event_id from event_history
            ->select('users.name', 'users.matrixno')
            ->get();

        // Pass the participants data to the view
        return view('admin.view_participant', ['participants' => $participants]);
    }

    public function showAddParticipantForm($id)
    {
        // Retrieve the current event by its ID
        $event = Event::findOrFail($id);
    
        // Retrieve participants from the add_event table for this event
        $participants = DB::table('add_event')
            ->select('id', 'name', 'matrixno', 'event_id')
            ->where('event_id', $event->event_id) // Match event_id in add_event with the event's event_id
            ->get();
    
        // Retrieve all users with role 'user'
        $allUsers = User::select('name', 'matrixno')
            ->where('role', 'user') // Filter by role
            ->get();
    
        // Retrieve conflicting participants who are in events that overlap with the current event time
        $conflictingUsers = DB::table('add_event')
            ->join('event', 'add_event.event_id', '=', 'event.event_id') // Join with the 'event' table
            ->where(function ($query) use ($event) {
                $query->where('event.time_start', '<', $event->time_end)
                      ->where('event.time_end', '>', $event->time_start);
            })
            ->pluck('add_event.matrixno'); // Get matrixno of conflicting participants
    
        // Filter out the users who are already in conflicting events
        $availableUsers = $allUsers->filter(function ($user) use ($conflictingUsers) {
            return !$conflictingUsers->contains($user->matrixno);
        });
    
        // Retrieve matrixnos of participants who are marked as present in user_event table
        $attendingMatrixNos = DB::table('user_event')
            ->where('event_id', $event->event_id)
            ->pluck('matrixno');
    
        // Pass the event, available users, and participants to the view, along with attendance information
        return view('admin.add-participant', compact('event', 'availableUsers', 'participants', 'attendingMatrixNos'));
    }
    
    
      
    public function storeParticipant(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'users' => 'required|string|max:255', // Change 'name' to 'users' since we're using it in the dropdown
        ]);
    
        // Get the matrix number from the selected user
        $matrixNo = $request->input('users');
    
        // Retrieve the user based on the matrix number
        $user = User::where('matrixno', $matrixNo)->firstOrFail(); // This will fetch the user's name
    
        // Insert the participant into the add_event table
        DB::table('add_event')->insert([
            'name' => $user->name, // Use the user's name
            'matrixno' => $user->matrixno, // Use the matrix number
            'event_name' => Event::findOrFail($id)->name, // Get the event name using the event ID
            'event_id' => Event::findOrFail($id)->event_id,
        ]);
    
        return redirect()->route('admin.add-participant', $id)->with('success', 'Participant added successfully');
    }
    


}
