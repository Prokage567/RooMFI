<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

Route::post("/register", [App\http\Controllers\AuthController::class, "register"]);
Route::post("/login", [App\http\Controllers\AuthController::class, "login"]);
route::middleware("auth:api")->get("/checktoken", [App\http\Controllers\AuthController::class, "checktoken"]);

Route::prefix("/section")->group(function () {
Route::get("/", [App\http\Controllers\SectionController::class, "all"])->middleware("auth:api");
Route::post("/", [App\http\Controllers\SectionController::class, "store"])->middleware("auth:api");
Route::get("/{section}", [App\http\Controllers\SectionController::class, "show"])->middleware("auth:api");
Route::delete("/{section}", [App\http\Controllers\SectionController::class, "delete"])->middleware("auth:api");
});

Route::prefix("/room")->group(function(){
    route::get("/", [App\Http\Controllers\RoomController::class,"all"])->middleware("auth:api");
    route::get("/{room}", [App\Http\Controllers\RoomController::class,"show"])->middleware("auth:api");
    route::post("/", [App\Http\Controllers\RoomController::class,"store"])->middleware("auth:api");
    route::patch("/{room}", [App\Http\Controllers\RoomController::class,"update"])->middleware("auth:api");
    route::delete("/{room}", [App\Http\Controllers\RoomController::class,"delete"])->middleware("auth:api");
});

Route::prefix("/teacher")->group(function () {
    Route::get("/", [App\http\Controllers\TeacherController::class, "all"])->middleware("auth:api");
    Route::post("/", [App\http\Controllers\TeacherController::class, "store"])->middleware("auth:api");
    Route::get("/{teacher}", [App\http\Controllers\TeacherController::class, "show"])->middleware("auth:api");
    Route::delete("/{teacher}", [App\http\Controllers\TeacherController::class, "delete"])->middleware("auth:api");
});

Route::prefix("/schedule")->group(function(){
    Route::get("/", [App\http\Controllers\ScheduleController::class, "all"])->middleware("auth:api");
    Route::post("/", [App\http\Controllers\ScheduleController::class, "store"])->middleware("auth:api");
    Route::get("/{schedule}", [App\http\Controllers\ScheduleController::class, "show"])->middleware("auth:api");
    Route::patch("/{schedule}", [App\http\Controllers\ScheduleController::class, "update"])->middleware("auth:api");
    Route::delete("/{schedule}", [App\http\Controllers\ScheduleController::class, "delete"])->middleware("auth:api");
});