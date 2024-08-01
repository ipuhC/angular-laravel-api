<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Ruta de prueba para verificar si la API está funcionando

Route::post('register', [AuthController::class, 'register']);

Route::post('users/{id}/change-password', [AuthController::class, 'changePassword']);

Route::post('login', [AuthController::class, 'login']);
Route::get('users/{id}/details', [AuthController::class, 'getUserDetails']);

Route::post('update-profile/{id}', [AuthController::class, 'updateProfile']);
// Route::get('users/{id}/profile-photo', [AuthController::class, 'getProfilePhoto']);

Route::apiResource('personas', PersonaController::class);
Route::apiResource('videos', VideoController::class);
// rutas para los videos
Route::patch('videos/{id}/likes', [VideoController::class, 'updateLikes']);
Route::patch('videos/{id}/dislikes', [VideoController::class, 'updateDislikes']);
Route::patch('videos/{id}/views', [VideoController::class, 'updateViews']);
// rutas para los comentarios
Route::apiResource('comment', CommentController::class);
Route::get('videos/{id}/comments', [VideoController::class, 'getComments']);


Route::post('subscribe/{targetUserId}', [SubscriptionController::class, 'subscribe']);
Route::post('unsubscribe/{targetUserId}', [SubscriptionController::class, 'unsubscribe']);
Route::get('subscribers/{userId}', [SubscriptionController::class, 'getSubscribers']);