<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserActivationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentResultsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'showMajors']);



// User activation routes
Route::get('activate', [UserActivationController::class, 'showActivationForm'])->name('activate.form');
Route::post('activate', [UserActivationController::class, 'sendActivationEmail'])->name('activate.email');
Route::get('/activate/{token}', [UserActivationController::class, 'showSetPasswordForm'])->name('activate.token');
Route::post('/activate/{token}', [UserActivationController::class, 'setPassword'])->name('activate.set_password');



Route::get('/results/select', [ResultsController::class, 'select'])->name('results.select');

Route::get('/results/{user}/edit', [ResultsController::class, 'edit'])->name('results.edit');
Route::put('/results/{user}', [ResultsController::class, 'update'])->name('results.update');
Route::delete('/results/{user}', [ResultsController::class, 'destroy'])->name('results.destroy');


Route::get('/manage', [MajorController::class, 'manage'])->name('majors.manage');

Route::post('/majors', [MajorController::class, 'store'])->name('majors.store');
Route::put('/majors/{id}', [MajorController::class, 'update'])->name('majors.update');
Route::delete('/majors/{id}', [MajorController::class, 'destroy'])->name('majors.destroy');

Route::post('/subjects', [MajorController::class, 'storeSubject'])->name('subjects.store');
Route::put('/subjects/{id}', [MajorController::class, 'updateSubject'])->name('subjects.update');
Route::delete('/subjects/{id}', [MajorController::class, 'destroySubject'])->name('subjects.destroy');


// Routes for SubjectController
Route::resource('subjects', SubjectController::class);


Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

Route::get('/students/results', [StudentResultsController::class, 'index'])->name('students.results');

Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
Route::get('/students/pdf', [StudentController::class, 'exportPDF'])->name('students.pdf');

// Admin dashboard route
Route::get('admin/admin_dashboard', [HomeController::class, 'index'])->name('admin.admin_dashboard')->middleware(['auth', 'admin']);

require __DIR__.'/auth.php';
