<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Ruta de prueba para verificar si la API está funcionando

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('personas', PersonaController::class);
Route::apiResource('videos', VideoController::class);