<?php

use App\Http\Controllers\MessageController;
use App\Http\Middleware\TrackUrlUsage;
use Illuminate\Support\Facades\Route;

Route::get('/', [MessageController::class, 'index'])->name('messages.create');
Route::post('/messages', [MessageController::class, 'store']);
Route::get('/messages/{payload}/{token}', [MessageController::class, 'show'])
    ->name('messages.show')
    ->middleware(TrackUrlUsage::class);