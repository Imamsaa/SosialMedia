<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\JWTAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){

    Route::post('/register', [JWTAuthController::class, 'register']);

    //menghandle route untuk posts
    Route::prefix('posts')->group(function() {
        Route::get('/', [PostsController::class, 'index']); //Mengambil semua data post.
        Route::post('/', [PostsController::class, 'store']); //Menyimpan data post baru.
        Route::get('/{id}', [PostsController::class, 'show']); //Mengambil data post berdasarkan ID.
        Route::put('/{id}', [PostsController::class, 'update']); //Mengupdate data post berdasarkan ID.
        Route::delete('/{id}', [PostsController::class, 'destroy']); //Menghapus data post berdasarkan ID.
    });

    Route::prefix('comments')->group(function(){
        Route::post('/', [CommentsController::class, 'store']);
        Route::delete('/{id}', [CommentsController::class, 'destroy']);
    });

    Route::prefix('likes')->group(function(){
        Route::post('/', [LikesController::class, 'store']);
        Route::delete('/{id}', [LikesController::class, 'destroy']);
    });

    Route::prefix('messages')->group(function(){
        Route::post('/', [MessagesController::class, 'store']);
        Route::get('/{id}', [MessagesController::class, 'show']);
        Route::get('/getmessages/{id}', [MessagesController::class, 'getMessages']);
        Route::delete('/{id}', [MessagesController::class, 'destroy']);
    });
});