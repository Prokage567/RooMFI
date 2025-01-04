<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/register", [App\http\Controllers\AuthController::class, "register"]);
Route::post("/login", [App\http\Controllers\AuthController::class, "login"]);

