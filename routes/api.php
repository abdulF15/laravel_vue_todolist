<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiTodolistController;

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

Route::post("todolist/delete/{id}", [ApiTodolistController::class, 'postDelete']);
Route::post("todolist/update/{id}", [ApiTodolistController::class, 'postUpdate']);
Route::post("todolist/create", [ApiTodolistController::class, 'postCreate']);
Route::get("todolist/show/{id}", [ApiTodolistController::class, 'show']);
Route::get("todolist/list", [ApiTodolistController::class, 'getList']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
