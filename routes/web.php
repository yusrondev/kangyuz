<?php

use App\Http\Controllers\backend\Dashboard;
use App\Http\Controllers\backend\TaskController;
use App\Http\Controllers\backend\FlagController;
use App\Http\Controllers\frontend\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', [Home::class,'index']);

Route::prefix('administrator')->group(function () {
    
    Route::get('dashboard', [Dashboard::class,'index']);
    
    // task
    Route::get('task', [TaskController::class,'index']);
    Route::post('store-task', [TaskController::class,'store']);
    Route::get('update-task/{id}', [TaskController::class,'update_status']);
    Route::get('get-task/{id}', [TaskController::class,'get_task']);
    
    // flag
    Route::get('flag', [FlagController::class,'index']);
    Route::post('store-flag', [FlagController::class,'store']);
});
