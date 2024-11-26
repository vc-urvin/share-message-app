<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [MessageController::class, 'index'])->name('messages.create');
Route::post('/messages', [MessageController::class, 'store']);
Route::get('/m/{payload}/{hash}', [MessageController::class, 'show'])->name('messages.show');