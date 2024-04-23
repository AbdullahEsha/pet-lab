<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthAsAdmin;

use App\Http\Controllers\CredentialController;
use App\Http\Controllers\UserController;

Route::post('/register', [CredentialController::class, 'register']);

Route::post('/login', [CredentialController::class, 'login']);

Route::post('/logout', [CredentialController::class, 'logout']);

Route::get('/users', [UserController::class, 'getAllUsers']);
// wrappe the routes in a middleware group
Route::middleware([AuthAsAdmin::class])->group(function () {
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
});
