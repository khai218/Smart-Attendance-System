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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about-us', function () {
    return view('about-us');
})->middleware(['auth', 'verified'])->name('about-us');

Route::get('/test', function () {
    return view('about-us');
})->middleware(['auth', 'verified'])->name('test');

Route::get('/record', function () {
    return view('record');
})->middleware(['auth', 'verified'])->name('record');

Route::get('/record', [ActivityController::class, 'index'])->name('record');

Route::get('/registration', [UserController::class, 'showUsers'], function () {
    return view('admin.registration');
})->middleware(['auth', 'verified'])->name('registration');

Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin-dashboard');

Route::post('/admin/upload-image/{user}', [RegisteredUserController::class, 'uploadImage'])->name('admin.uploadImage');

Route::get('/image-viewer', function () {
    $imageUrl = request('imageUrl');
    return view('admin.image-viewer', compact('imageUrl'));
});

Route::get('/admin/users/{id}', [AdminController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/admin/staff/{id}', [AdminController::class, 'staff_edit'])->name('admin.staff.edit');

Route::middleware('auth')->group(function () {
    // Regular user profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin registration routes
    Route::get('admin/register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('admin/register', [RegisteredUserController::class, 'store']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin dashboard route
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin profile edit route
    Route::get('/profile/admin-edit', [ProfileController::class, 'edit'])->name('profile.admin-edit');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    // Agent dashboard route
    Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
});

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

// Route to show the staff registration form
Route::get('/staff_registration', [RegisteredUserController::class, 'staffRegistrationForm'])->middleware(['auth', 'role:admin'])->name('admin.staff_registration');

// Route to handle staff registration form submission
Route::post('/staff_registration', [RegisteredUserController::class, 'registerStaff'])->middleware(['auth', 'role:admin'])->name('staff.register');

Route::get('/staff_registration', [UserController::class, 'showStaff'])->middleware(['auth', 'role:admin'])->name('staff_registration');

// Include authentication routes
require __DIR__.'/auth.php';
