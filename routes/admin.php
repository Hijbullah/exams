<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExamTypeController;
use App\Http\Controllers\Admin\SubjectController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group & default prefix is "admin". Now create something great!
|
*/

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');

Route::name('admin.')->group(function() {
    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');

    // Route::resource('/batches', BatchController::class);

    Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
    Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
    Route::get('/batches/{batch:slug}', [BatchController::class, 'show'])->name('batches.show');
    Route::get('/batches/{batch:slug}/edit', [BatchController::class, 'edit'])->name('batches.edit');
    Route::put('/batches/{batch:slug}', [BatchController::class, 'update'])->name('batches.update');
    Route::delete('/batches/{batch:slug}', [BatchController::class, 'destroy'])->name('batches.destroy');

    Route::resource('/exam-types', ExamTypeController::class);
    Route::resource('/subjects', SubjectController::class);
    Route::resource('/exams', ExamController::class);



});


// batch
// Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
// Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
// Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
// Route::get('/batches/{batch:batch_id}', [BatchController::class, 'show'])->name('batches.show');
// Route::get('/batches/{batch:batch_id}/edit', [BatchController::class, 'edit'])->name('batches.edit');
// Route::put('/batches/{batch:batch_id}', [BatchController::class, 'update'])->name('batches.update');
// Route::delete('/batches/{batch:batch_id}', [BatchController::class, 'destroy'])->name('batches.destroy');
