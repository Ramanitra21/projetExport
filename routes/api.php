<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellPoundController;

// Routes protégées par Sanctum pour récupérer les informations de l'utilisateur authentifié
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

// Route de test pour vérifier que l'API fonctionne
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello World']);
});

// Routes d'authentification
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées nécessitant l'authentification
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/sellpound', [SellPoundController::class, 'create']);
    Route::post('/achat', [SellPoundController::class, 'achat']);
    Route::get('/sellpounds/available', [SellPoundController::class, 'getAvailableSellPounds']);
});
