<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);




// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::resource('tasks', TasksController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostsController::class);
    Route::post('/logout',[AuthController::class, 'logout']);
});