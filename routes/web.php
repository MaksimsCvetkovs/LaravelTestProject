<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;

Route::get("/", [IndexController::class, "index"])->name("index");

Route::middleware("auth")->group(function () {
    Route::get("/projects/my", [UserController::class, "projects"])->name("user.project.my");
    Route::get("/projects/create", [UserController::class, "projectCreate"])->name("user.project.create");
    Route::post("/projects/create", [UserController::class, "projectCreatePost"]);
});

Route::get("/projects", [IndexController::class, "projects"])->name("project.list");
Route::get("/projects/{projectId}", [IndexController::class, "projectView"])->name("project.view");
Route::post("/projects/{projectId}", [IndexController::class, "projectViewPost"]);
