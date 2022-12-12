<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;

Route::get("/", [IndexController::class, "index"])->name("index");

Route::middleware("auth")->group(function () {
    Route::get("/projects/my", [UserController::class, "projects"])->name("user.project.my");
    Route::get("/projects/create", [UserController::class, "projectCreate"])->name("user.project.create");
    Route::post("/projects/create", [UserController::class, "projectCreatePost"]);
    Route::get("/projects/{projectId}/edit", [UserController::class, "projectEdit"])->name("user.project.edit");
    Route::post("/projects/{projectId}/edit", [UserController::class, "projectEditPost"]);
});

Route::get("/projects", [IndexController::class, "projects"])->name("project.list");
Route::get("/projects/{projectId}", [IndexController::class, "projectView"])->name("project.view");

Route::get("/manfs", [IndexController::class, "manfs"])->name("manf.list");
Route::get("/manfs/{manfId}", [IndexController::class, "manfView"])->name("manf.view");
Route::post("/manfs/{manfId}", [IndexController::class, "manfViewPost"]);

Route::get("/services", [IndexController::class, "services"])->name("service.list");
Route::get("/services/{serviceId}", [IndexController::class, "serviceView"])->name("service.view");
Route::post("/services/{serviceId}", [IndexController::class, "serviceViewPost"]);
