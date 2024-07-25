<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserActivationController;
use App\Http\Controllers\HomeController;

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


use App\Http\Controllers\ResultController;

// Route for displaying the add results form
// Show the form for adding results
Route::get('/results/add_results', [ResultController::class, 'create'])->name('add_results')->middleware(['auth','admin']);

// Handle the form submission to add results
Route::post('/results/store', [ResultController::class, 'store'])->name('store_results');

// Filter students and subjects based on the selected major
Route::post('/results/filter', [ResultController::class, 'filterByMajor'])->name('filter_by_major');
// Route to show the results page for logged-in users
Route::get('/results/view_results', [ResultController::class, 'showResults'])->name('view_results')->middleware('auth');


require __DIR__.'/auth.php';
route::get('admin/admin_dashboard',[HomeController::class,'index'])->middleware(['auth','admin']);