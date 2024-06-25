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
// rutas para los videos
Route::patch('videos/{id}/likes', [VideoController::class, 'updateLikes']);
Route::patch('videos/{id}/dislikes', [VideoController::class, 'updateDislikes']);
Route::patch('videos/{id}/views', [VideoController::class, 'updateViews']);
// rutas para los comentarios
Route::apiResource('comment', CommentController::class);
Route::get('videos/{id}/comments', [VideoController::class, 'getComments']);