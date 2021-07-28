<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AdminVideoController;
use App\Http\Controllers\CommentController;

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/videos/{category}', [VideoController::class, 'index'])->name('video.get');
        Route::get('/videos/{category}/{video_id}', [VideoController::class, 'singleVideo'])->name('video.get.video');
        Route::get('/comments/{video_id}', [CommentController::class, 'index'])->name('comment.get');
        Route::post('/add-comment', [CommentController::class, 'store'])->name('comment.add');
        Route::get("logout", [UserController::class, 'logout'])->name('logout');
        /*Admin routes*/
        Route::group(
            ['middleware' => ['admin'], 'prefix' => 'admin'],
            function () {
                Route::post('/add-video', [AdminVideoController::class, 'store'])->name('video.add');
                Route::post('/update-video', [AdminVideoController::class, 'update'])->name('video.update');
                Route::post('/delete-video', [AdminVideoController::class, 'delete'])->name('video.delete');
                Route::get('/videos/{category}', [AdminVideoController::class, 'index'])
                ->name('admin.videos.get');
                Route::get('/videos/{category}/{video_id}', [AdminVideoController::class, 'singleVideo'])
                ->name('admin.videos.get.single');
            }
        );
    }
);

Route::post("register", [UserController::class, 'register'])->name('register');
Route::post("/login", [UserController::class, 'login'])->name('login');
