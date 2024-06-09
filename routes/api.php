<?php

use App\Http\Controllers\PatientController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/patient', [PatientController::class, 'index']);
Route::post('/patient', [PatientController::class, 'store']);
Route::get('/patient/{patient}', [PatientController::class, 'show']);
