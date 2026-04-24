<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\ParentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canResetPassword' => Route::has('password.request'),
        'status' => session('status'),
    ]);
});

Route::post('/student/create', [StudentController::class, 'store'])->middleware(['auth', 'verified'])->name('student.store');

Route::get('/student/create', [StudentController::class, 'create'])->middleware(['auth', 'verified'])->name('student.create');

Route::get('/student', [StudentController::class, 'index'])->middleware(['auth', 'verified'])->name('student.index');

Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->middleware(['auth', 'verified'])->name('student.edit');

Route::put('/student/update/{id}', [StudentController::class, 'update'])->middleware(['auth', 'verified'])->name('student.update');

Route::delete('/student/delete/{id}', [StudentController::class, 'destroy'])->middleware(['auth', 'verified'])->name('student.destroy');

Route::get('/class', [ClassController::class, 'index'])->middleware(['auth', 'verified'])->name('class.index');

Route::get('/class/create', [ClassController::class, 'create'])->middleware(['auth', 'verified'])->name('class.create');

Route::post('/class/create', [ClassController::class, 'store'])->middleware(['auth', 'verified'])->name('class.store');

Route::get('/class/edit/{id}', [ClassController::class, 'edit'])->middleware(['auth', 'verified'])->name('class.edit');

Route::put('/class/update/{id}', [ClassController::class, 'update'])->middleware(['auth', 'verified'])->name('class.update');

Route::delete('/class/delete/{id}', [ClassController::class, 'destroy'])->middleware(['auth', 'verified'])->name('class.destroy');

Route::post('/teacher/create', [TeachersController::class, 'store'])->middleware(['auth', 'verified'])->name('teacher.store');

Route::get('/teacher/create', [TeachersController::class, 'create'])->middleware(['auth', 'verified'])->name('teacher.create');

Route::get('/teacher', [TeachersController::class, 'index'])->middleware(['auth', 'verified'])->name('teacher.index');

Route::get('/teacher/edit/{id}', [TeachersController::class, 'edit'])->middleware(['auth', 'verified'])->name('teacher.edit');

Route::put('/teacher/update/{id}', [TeachersController::class, 'update'])->middleware(['auth', 'verified'])->name('teacher.update');

Route::delete('/teacher/delete/{id}', [TeachersController::class, 'destroy'])->middleware(['auth', 'verified'])->name('teacher.destroy');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/parent/create', [ParentController::class, 'store'])->middleware(['auth', 'verified'])->name('parent.store');

Route::get('/parent/create', [ParentController::class, 'create'])->middleware(['auth', 'verified'])->name('parent.create');

Route::get('/parent', [ParentController::class, 'index'])->middleware(['auth', 'verified'])->name('parent.index');

Route::get('/parent/edit/{id}', [ParentController::class, 'edit'])->middleware(['auth', 'verified'])->name('parent.edit');

Route::put('/parent/update/{id}', [ParentController::class, 'update'])->middleware(['auth', 'verified'])->name('parent.update');

Route::delete('/parent/delete/{id}', [ParentController::class, 'destroy'])->middleware(['auth', 'verified'])->name('parent.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
