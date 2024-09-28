<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showUsers() {
        // Fetch users data
        $users = User::all();
        $fingerprintIds = DB::table('fingerprint_id')->pluck('fingerprint_id');
        
        // Pass the $users data to the 'admin.registration' view
        return view('admin.registration', ['users' => $users],['fingerprintIds' => $fingerprintIds]);
    }

    public function showStaff() {
        // Fetch users data
        $users = User::all();
        
        // Pass the $users data to the 'admin.staff_registration' view
        return view('admin.staff_registration', ['users' => $users]);
    }
}  


