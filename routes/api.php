<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PracticumController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
/*
Route::prefix('department')->name('department.')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('index');     // GET /department
    Route::post('/', [DepartmentController::class, 'store'])->name('store'); // POST /department
    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy'); // DELETE /department
});
*/
Route::prefix('practicum')->name('practicum.')->group(function () {
    Route::middleware('auth:sanctum')->get('/', [PracticumController::class, 'index'])->name('index');     // GET /practicum
    Route::middleware('auth:sanctum')->get('/{practicum}', [PracticumController::class, 'show'])->name('show'); // GET /practicum/{id}
    //Route::post('/', [PracticumController::class, 'store'])->name('store'); // POST /practicum
    //Route::patch('/{id}', [PracticumController::class, 'update'])->name('update'); // PATCH /practicum
    //Route::delete('/{id}', [PracticumController::class, 'destroy'])->name('destroy'); // DELETE /practicum
});

Route::prefix('activity')->name('activity.')->group(function () {
    //Route::middleware('auth:sanctum')->get('/', [ActivityController::class, 'index'])->name('index');     // GET /activity
    Route::middleware('auth:sanctum')->get('/{activity}', [ActivityController::class, 'show'])->name('show');  // GET /activity/{id}
    Route::middleware(['auth:sanctum', 'role:assistant'])->get('/{activity}/submissions', [ActivityController::class, 'index'])->name('index'); // GET /activity/{id}/submissions (assistant)
    //Route::post('/', [ActivityController::class, 'store'])->name('store'); // POST /activity
    //Route::patch('/{id}', [ActivityController::class, 'update'])->name('update'); // PATCH /activity
    //Route::delete('/{id}', [ActivityController::class, 'destroy'])->name('destroy'); // DELETE /activity
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum', 'role:coordinator'])->get('/admin', function () {
    return response()->json(['message' => 'Hello Coordinator']);
});

Route::prefix('submission')->name('submission.')->group(function () {
    Route::middleware('auth:sanctum')->get('/file/{attachment_id}', [SubmissionController::class, 'download'])->name('download');
    Route::middleware('auth:sanctum')->delete('/file/{attachment_id}', [SubmissionController::class, 'deleteAttachment'])->name('deleteAttachment');
    Route::middleware('auth:sanctum')->post('/{activity_id}/file', [SubmissionController::class, 'addFile'])->name('addFile');
    Route::middleware(['auth:sanctum', 'role:assistant'])->patch('/{submission}/grade', [SubmissionController::class, 'gradeSubmission'])->name('gradeSubmission');
    Route::middleware('auth:sanctum')->patch('/{submission}', [SubmissionController::class, 'update'])->name('update');
    Route::middleware('auth:sanctum')->delete('/{submission}', [SubmissionController::class, 'destroy'])->name('destroy');
    Route::middleware('auth:sanctum')->get('/{activity_id}', [SubmissionController::class, 'show'])->name('show');
     Route::middleware('auth:sanctum')->post('/{activity_id}', [SubmissionController::class, 'store'])->name('store');
});
