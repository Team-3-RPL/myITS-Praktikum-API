<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PracticumController;
use App\Http\Controllers\ActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('department')->name('department.')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('index');     // GET /department
    Route::post('/', [DepartmentController::class, 'store'])->name('store'); // POST /department
    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy'); // DELETE /department
});

Route::prefix('practicum')->name('practicum.')->group(function () {
    Route::get('/', [PracticumController::class, 'index'])->name('index');     // GET /practicum
    Route::get('/{practicum}', [PracticumController::class, 'show'])->name('show'); // GET /practicum/{id}
    Route::post('/', [PracticumController::class, 'store'])->name('store'); // POST /practicum
    Route::patch('/{id}', [PracticumController::class, 'update'])->name('update'); // PATCH /practicum
    Route::delete('/{id}', [PracticumController::class, 'destroy'])->name('destroy'); // DELETE /practicum
});

Route::prefix('activity')->name('activity.')->group(function () {
    Route::get('/', [ActivityController::class, 'index'])->name('index');     // GET /activity
    Route::post('/', [ActivityController::class, 'store'])->name('store'); // POST /activity
    Route::patch('/{id}', [ActivityController::class, 'update'])->name('update'); // PATCH /activity
    Route::delete('/{id}', [ActivityController::class, 'destroy'])->name('destroy'); // DELETE /activity
});