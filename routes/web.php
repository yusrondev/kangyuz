<?php

use App\Http\Controllers\backend\Dashboard;
use App\Http\Controllers\backend\TaskController;
use App\Http\Controllers\backend\FlagController;
use App\Http\Controllers\frontend\Home;
use App\Http\Controllers\frontend\TaskController as AppTaskController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [Home::class, 'index']);
Route::view('/', 'index');
Route::get('/task/{flag}', [AppTaskController::class, 'index']);

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('administrator')->group(function () {

        Route::get('dashboard', [Dashboard::class, 'index']);
    
        // task
        Route::get('task', [TaskController::class, 'index']);
        Route::post('store-task', [TaskController::class, 'store']);
        Route::get('update-task/{id}', [TaskController::class, 'update_status']);
        Route::get('get-task/{id}', [TaskController::class, 'get_task']);
        Route::delete('delete-task/{task}', [TaskController::class, 'destroy']);
    
        // flag
        Route::get('flag', [FlagController::class, 'index']);
        Route::post('store-flag', [FlagController::class, 'store']);
        Route::post('data-flag', [FlagController::class, 'show']);
        Route::post('update-flag', [FlagController::class, 'update']);

    });
    
});
