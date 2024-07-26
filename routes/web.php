<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserActivationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User activation routes
Route::get('activate', [UserActivationController::class, 'showActivationForm'])->name('activate.form');
Route::post('activate', [UserActivationController::class, 'sendActivationEmail'])->name('activate.email');
Route::get('/activate/{token}', [UserActivationController::class, 'showSetPasswordForm'])->name('activate.token');
Route::post('/activate/{token}', [UserActivationController::class, 'setPassword'])->name('activate.set_password');

// Result routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('results/select', [ResultController::class, 'select'])->name('results.select');
    Route::get('results/list', [ResultController::class, 'list'])->name('results.list');
    Route::post('/results/storeOrUpdate', [ResultController::class, 'storeOrUpdate'])->name('results.storeOrUpdate');
    Route::delete('results/{id}', [ResultController::class, 'destroy'])->name('results.destroy');   
});

// Route to show the results page for logged-in users
Route::get('/results/view_results', [ResultController::class, 'showStudentGrade'])->name('view_results')->middleware('auth');

use App\Http\Controllers\StudentController;

Route::middleware('auth')->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});

// Admin dashboard route
Route::get('admin/admin_dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);

require __DIR__.'/auth.php';
