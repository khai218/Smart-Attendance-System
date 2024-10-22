<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\FingerprintController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public routes
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Authenticated and verified user routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Common routes for all authenticated and verified users
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/about-us', function () {
        return view('about-us');
    })->name('about-us');
    
    Route::get('/test', function () {
        return view('about-us');
    })->name('test');

    Route::get('/record', [ActivityController::class, 'index'])->name('record');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin dashboard and registration
    Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
    Route::get('/registration', [UserController::class, 'showUsers'])->name('registration');
    Route::get('/profile/admin-edit', [ProfileController::class, 'adminEdit'])->name('profile.admin-edit');

    // Fingerprint management
    Route::post('/register-fingerprint', [FingerprintController::class, 'register'])->name('register-fingerprint');
    Route::post('/verify-fingerprint', [FingerprintController::class, 'verify'])->name('verify-fingerprint');

    // Image upload for admin
    Route::post('/admin/upload-image/{user}', [RegisteredUserController::class, 'uploadImage'])->name('admin.uploadImage');

    // Admin user management
    Route::get('/admin/users/{id}', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    // Staff management
    Route::get('/admin/staff/{id}', [AdminController::class, 'staff_edit'])->name('admin.staff.edit');
    Route::get('/staff_registration', [RegisteredUserController::class, 'staffRegistrationForm'])->name('admin.staff_registration');
    Route::post('/staff_registration', [RegisteredUserController::class, 'registerStaff'])->name('staff.register');
    Route::get('/staff_registration', [UserController::class, 'showStaff'])->name('staff_registration');

    // Controller view for admin
    Route::get('/controller', function () {
        return view('admin.controller');
    })->name('controller');

    // Participant management in events
    Route::get('/admin/event/{id}/add-participant', [AdminController::class, 'showAddParticipantForm'])->name('admin.add-participant');
    Route::post('/admin/event/{id}/add-participant', [AdminController::class, 'storeParticipant'])->name('admin.store-participant');
   
    Route::get('/image-viewer', function () {
        $imageUrl = request('imageUrl');
        return view('admin.image-viewer', compact('imageUrl'));
    });

    // Event management
    Route::get('/event-management', [AdminController::class, 'event_view'])->name('event-management');
    Route::post('/event-management', [AdminController::class, 'event_store'])->name('admin.event-register');
    Route::put('/event-management/{id}/end', [AdminController::class, 'event_end'])->name('admin.event-end');
    Route::delete('/event-management/{id}/terminate', [AdminController::class, 'event_terminate'])->name('admin.event-terminate');

    Route::get('/admin/event/{id}/participants', [AdminController::class, 'viewParticipants'])->name('admin.event-participants');
});

// Agent-only routes
Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
});

// Testing routes
Route::get('/test-fingerprint', [RegisteredUserController::class, 'test']);

// Admin registration routes
Route::get('admin/register', [RegisteredUserController::class, 'create'])->name('admin.register');
Route::post('admin/register', [RegisteredUserController::class, 'store']);

// Include authentication routes
require __DIR__.'/auth.php';
