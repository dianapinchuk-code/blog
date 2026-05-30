<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RestTestController;
use App\Http\Controllers\DiggingDeeperController;


Route::apiResource('rest', RestTestController::class)->names('restTest');
Route::get('/', [BlogController::class, 'index']);
Route::get('/post/{slug}', [BlogController::class, 'show']);
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::group(['prefix' => 'digging_deeper'], function () {
    Route::get('collections', [DiggingDeeperController::class, 'collections'])
        ->name('digging_deeper.collections');
});
