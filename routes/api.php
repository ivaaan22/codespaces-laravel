<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::patch('/students/{id}', [StudentController::class, 'updatePartial']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

Route::get('/series', [SeriesController::class, 'index']);
Route::post('/series', [SeriesController::class, 'store']);
Route::get('/series/{id}', [SeriesController::class, 'show']);
Route::put('/series/{id}', [SeriesController::class, 'update']);
Route::delete('/series/{id}', [SeriesController::class, 'destroy']);

Route::get('/series/{series_id}/movies', [MovieController::class, 'index']);
Route::post('/series/{series_id}/movies', [MovieController::class, 'store']);
Route::get('/series/{series_id}/movies/{movie_id}', [MovieController::class, 'show']);
Route::put('/series/{series_id}/movies/{movie_id}', [MovieController::class, 'update']);
Route::delete('/series/{series_id}/movies/{movie_id}', [MovieController::class, 'destroy']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::get('/');

