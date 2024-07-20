<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserActivationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('activate', [UserActivationController::class, 'showActivationForm'])->name('activate.form');
Route::post('activate', [UserActivationController::class, 'sendActivationEmail'])->name('activate.email');

// Route to handle the token and show the set password form
Route::get('/activate/{token}', [UserActivationController::class, 'showSetPasswordForm'])->name('activate.token');

// Route to handle the form submission and set the password
Route::post('/activate/{token}', [UserActivationController::class, 'setPassword'])->name('activate.set_password');

require __DIR__.'/auth.php';
