<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User_Event;

class ActivityController extends Controller
{
    /**
     * Display the user's activity records.
     */
    public function index()
    {
        // Get the matrix number of the logged-in user
        $matrixno = Auth::user()->matrixno;

        // Fetch all activity records for the user based on the matrix number
        $events = User_Event::where('matrixno', $matrixno)->get();

        // Pass the activity data to the view
        return view('record', compact('events'));
    }
}
