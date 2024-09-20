<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Display the user's activity records.
     */
    public function index()
    {
        // Get the matrix number of the logged-in user
        $matrixno = Auth::user()->matrixno;
        
        // Dynamically generate the user's activity table name
        $tableName = 'user_' . $matrixno;

        // Check if the user's activity table exists
        if (DB::getSchemaBuilder()->hasTable($tableName)) {
            // Fetch all activity records from the user's table
            $activities = DB::table($tableName)->get();
        } else {
            // If the table doesn't exist, return an empty collection
            $activities = collect();
        }

        // Pass the activity data to the view
        return view('record', compact('activities'));
    }
}
