<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index']);
Route::resource('todos', TodoController::class)->except(['create', 'edit']);
Route::get('/analytics', [TodoController::class, 'analytics']);
