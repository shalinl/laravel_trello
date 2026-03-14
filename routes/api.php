<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FileController;

Route::post('/register',[AuthController::class,'createUser']);
Route::post('/login',[AuthController::class,'loginUser']);

/** protected routes **/
Route::middleware('auth:sanctum')->group(function(){

	// this prefix tasks added before url as api/tasks/..
	Route::prefix('/tasks')->group(function(){
		Route::post('/',[TaskController::class,'createTask']);
		Route::put('/{taskid}',[TaskController::class,'updateTask']);
		Route::delete('/{taskid}',[TaskController::class,'deleteTask']);
		Route::get('/',[TaskController::class,'getAllTasks']);
		Route::get('/{taskid}',[TaskController::class,'getTaskbyId']);
	});

	Route::prefix('/comments')->group(function(){
		Route::post('/',[CommentController::class,'createComment']);
		Route::put('/{commentid}',[CommentController::class,'updateComment']);
		Route::delete('/{commentid}',[CommentController::class,'deleteComment']);
		Route::get('/',[CommentController::class,'getAllComments']);
		Route::get('/{commentid}',[CommentController::class,'getCommentbyId']);
	});

	Route::prefix('/files')->group(function(){
		Route::post('/',[FileController::class,'uploadFile']);
	});

});

