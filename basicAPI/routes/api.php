<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// basic api
Route::apiResource("students", StudentController::class);

//jwt auth
Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

Route::middleware("auth:api")->group(function () {
  Route::get("profile", [ApiController::class, "profile"]);
  Route::get("refresh", [ApiController::class, "refreshToken"]);
  Route::get("logout", [ApiController::class, "logout"]);
});
