<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUsers() {
        // Fetch users data
        $users = User::all();
        
        // Pass the $users data to the 'admin.registration' view
        return view('admin.registration', ['users' => $users]);
    }

    public function showStaff() {
        // Fetch users data
        $users = User::all();
        
        // Pass the $users data to the 'admin.staff_registration' view
        return view('admin.staff_registration', ['users' => $users]);
    }
}  


