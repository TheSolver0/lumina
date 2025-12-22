<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::resource('post', App\Http\Controllers\PostController::class);