<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Public Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/auth/google', [AuthController::class, 'googleLogin'])->name('auth.google');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Main Feed Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/feed', [HomeController::class, 'feed'])->name('home.feed');
    
    // Notes System
    Route::resource('notes', App\Http\Controllers\NoteController::class);
    
    Route::get('/settings/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/settings/profile', [App\Http\Controllers\ProfileController::class, 'update']);
    Route::post('/users/{user}/follow', [App\Http\Controllers\FollowController::class, 'toggle'])->name('users.follow');
    Route::get('/users/{user}/followers', [App\Http\Controllers\ProfileController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/following', [App\Http\Controllers\ProfileController::class, 'following'])->name('users.following');
    Route::get('/explore', [App\Http\Controllers\ExploreController::class, 'index'])->name('explore');
    Route::get('/check-username', [App\Http\Controllers\AuthController::class, 'checkUsername'])->name('username.check');
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
    Route::post('/notifications/read-all', [App\Http\Controllers\HomeController::class, 'markNotificationsRead'])->name('notifications.readAll');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    });

    // Profile Routes (Catch-all patterns should be last)
    Route::get('/@{username}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/user/{username}', [App\Http\Controllers\ProfileController::class, 'show']);
});

// Fallback Route for 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
