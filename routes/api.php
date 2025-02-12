<?php
use Illuminate\Support\Facades\Route;

Route::post("/register", [App\http\Controllers\AuthController::class, "register"]);
Route::post("/login", [App\http\Controllers\AuthController::class, "login"]);
route::middleware("auth:api")->get("/checktoken", [App\http\Controllers\AuthController::class, "checktoken"]);
route::middleware("auth:api")->post("/logout", [App\http\Controllers\AuthController::class, "logout"]);

Route::prefix("/section")->group(function () {
Route::get("/", [App\http\Controllers\SectionController::class, "all"]);
Route::post("/", [App\http\Controllers\SectionController::class, "store"])->middleware("auth:api");
Route::get("/{section}", [App\http\Controllers\SectionController::class, "show"]);
Route::patch("/{section}", [App\http\Controllers\SectionController::class, "update"])->middleware("auth:api");
Route::delete("/{section}", [App\http\Controllers\SectionController::class, "delete"])->middleware("auth:api");
});

Route::prefix("/room")->group(function(){
    route::get("/", [App\Http\Controllers\RoomController::class,"all"]);
    route::get("/{room}", [App\Http\Controllers\RoomController::class,"show"]);
    route::post("/", [App\Http\Controllers\RoomController::class,"store"])->middleware("auth:api");
    route::patch("/{room}", [App\Http\Controllers\RoomController::class,"update"])->middleware("auth:api");
    route::delete("/{room}", [App\Http\Controllers\RoomController::class,"delete"])->middleware("auth:api");
});
Route::prefix("/category")->group(function(){
    route::get("/", [App\Http\Controllers\CategoryController::class,"all"]);
    route::get("/{category}", [App\Http\Controllers\CategoryController::class,"show"]);
    route::post("/", [App\Http\Controllers\CategoryController::class,"store"])->middleware("auth:api");
    route::patch("/{category}", [App\Http\Controllers\CategoryController::class,"update"])->middleware("auth:api");
    route::delete("/{category}", [App\Http\Controllers\CategoryController::class,"delete"])->middleware("auth:api");
});

Route::prefix("/teacher")->group(function () {
    Route::get("/", [App\http\Controllers\TeacherController::class, "all"]);
    Route::post("/", [App\http\Controllers\TeacherController::class, "store"])->middleware("auth:api");
    Route::get("/{teacher}", [App\http\Controllers\TeacherController::class, "show"]);
    Route::patch("/{teacher}", [App\http\Controllers\TeacherController::class, "update"])->middleware("auth:api");
    Route::delete("/{teacher}", [App\http\Controllers\TeacherController::class, "delete"])->middleware("auth:api");
});

Route::prefix("/schedule")->group(function(){
    Route::get("/", [App\http\Controllers\ScheduleController::class, "all"]);
    Route::post("/", [App\http\Controllers\ScheduleController::class, "store"])->middleware("auth:api");
    Route::get("/{schedule}", [App\http\Controllers\ScheduleController::class, "show"]);
    Route::patch("/{schedule}", [App\http\Controllers\ScheduleController::class, "update"])->middleware("auth:api");
    Route::delete("/{schedule}", [App\http\Controllers\ScheduleController::class, "delete"])->middleware("auth:api");
});