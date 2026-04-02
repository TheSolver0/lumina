<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;

Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::resource('post', App\Http\Controllers\PostController::class);

Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/',                              [ForumController::class, 'index'])->name('index');
    Route::get('/{thread}',                      [ForumController::class, 'show'])->name('show');
 
    Route::middleware('auth')->group(function () {
        Route::post('/',                              [ForumController::class, 'store'])->name('store');
        Route::delete('/{thread}',                    [ForumController::class, 'destroy'])->name('destroy');
        Route::post('/{thread}/reply',                [ForumController::class, 'reply'])->name('reply');
        Route::post('/{thread}/like',                 [ForumController::class, 'like'])->name('like');
        Route::post('/reply/{reply}/like',            [ForumController::class, 'likeReply'])->name('reply.like');
        Route::post('/{thread}/best-answer/{reply}',  [ForumController::class, 'markBestAnswer'])->name('best-answer');
        Route::post('/{thread}/resolve',              [ForumController::class, 'resolve'])->name('resolve');
    });
}); 