<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Ruta de prueba para verificar si la API está funcionando

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('personas', PersonaController::class);
Route::apiResource('videos', VideoController::class);
Route::apiResource('comment', CommentController::class);
Route::get('videos/{id}/comments', [VideoController::class, 'getComments']);