<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SuperVisionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('proposals', ProposalController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::get('/supervisions/request', [SuperVisionController::class, 'request'])->name('supervisions.request');
    Route::get('/supervisions/dosen/{dosen}', [SuperVisionController::class, 'showDosen'])->name('supervisions.showDosen');
    Route::get('/supervisions/mahasiswa/{mahasiswa}', [SuperVisionController::class, 'showMahasiswa'])->name('supervisions.showMahasiswa');
    Route::patch('/supervisions/{supervision}/approve', [SuperVisionController::class, 'approve'])->name('supervisions.approve');
    Route::patch('/supervisions/{supervision}/reject', [SuperVisionController::class, 'reject'])->name('supervisions.reject');
    Route::resource('supervisions', SuperVisionController::class);
    Route::resource('appointments', AppointmentController::class);
});

require __DIR__ . '/auth.php';
