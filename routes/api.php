<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/verify', [UserController::class, 'verify']);
Route::post('/add/kids', [UserController::class, 'add_kids']);
Route::put('/modify/kids/{id}', [UserController::class, 'update_kids']);
Route::get('/get/kids/{id}', [UserController::class, 'get_kids']);
Route::put('/modify/parents/{id}', [UserController::class, 'modify_parents']);
Route::post('/add-kid-homework-progress', [UserController::class, 'add_kid_homework_progress']);
Route::get('/get-scores/{id}', [UserController::class, 'fetch_scores']);
