<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/authors', [AuthorController::class, 'index'])->middleware('auth:sanctum');
Route::get('/paginate_authors', [AuthorController::class, 'paginate'])->middleware('auth:sanctum');
