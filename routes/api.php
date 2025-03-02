<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::post('/bmd-data', [FileController::class, 'upload']);

// Fallback route for undefined or unsupported routes
Route::fallback(function () {
    return response()->json(['error' => 'Not Found'], 404);
});
