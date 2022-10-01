<?php

use App\Events\ChatEvent;
use App\Http\Controllers\backend\Dashboard;
use App\Http\Controllers\frontend\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [Home::class,'index']);

Route::prefix('administrator')->group(function () {
    Route::get('dashboard', [Dashboard::class,'index']);
});
Route::post('send', function(Request $request){
    // $request->validate([
    //     'name'    => 'required',
    //     'message' => 'required'
    // ]);

    $message = [
        'name'    => $request->name,
        'message' => $request->message,
    ];

    ChatEvent::dispatch($message);
});