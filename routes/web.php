<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;

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

Route::middleware(['auth', 'role:school'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('school-classes', SchoolClassController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('grades', GradeController::class);
});

Route::middleware(['auth', 'role:teacher,school'])->group(function () {
    Route::resource('grades', GradeController::class);
});



require __DIR__ . '/auth.php';
