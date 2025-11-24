<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard com redirecionamento baseado na role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user && $user->role === 'teacher') {
            return redirect()->route('grades.index');
        }

        return view('dashboard');
    })->name('dashboard');

    // ========== ROTAS PARA SCHOOL ==========
    
    // ========== ROTAS PARA TEACHER ==========
    Route::middleware(['role:teacher'])->group(function () {
        Route::resource('grades', GradeController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    });
    
    Route::middleware(['role:school'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('school-classes', SchoolClassController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('grades', GradeController::class);
    });

});

require __DIR__ . '/auth.php';