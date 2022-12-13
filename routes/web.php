<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Model3DController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ManfController;

Route::get("/", [IndexController::class, "index"])->name("index");

Route::middleware("auth")->group(function () {
    Route::get("/models/my", [Model3DController::class, "modelsMy"])->name("user.model.my");
    Route::get("/models/create", [Model3DController::class, "modelCreate"])->name("user.model.create");
    Route::post("/models/create", [Model3DController::class, "modelCreatePost"]);
    Route::get("/models/{modelId}/edit", [Model3DController::class, "modelEdit"])->name("user.model.edit");
    Route::post("/models/{modelId}/edit", [Model3DController::class, "modelEditPost"]);
    Route::get("/models/{modelId}/delete", [Model3DController::class, "modelDelete"])->name("user.model.delete");
    Route::post("/models/{modelId}/delete", [Model3DController::class, "modelDeletePost"]);

    Route::get("/projects/my", [ProjectController::class, "projectsMy"])->name("user.project.my");
    Route::get("/projects/create", [ProjectController::class, "projectCreate"])->name("user.project.create");
    Route::post("/projects/create", [ProjectController::class, "projectCreatePost"]);
    Route::get("/projects/{projectId}/edit", [ProjectController::class, "projectEdit"])->name("user.project.edit");
    Route::post("/projects/{projectId}/edit", [ProjectController::class, "projectEditPost"]);
    Route::get("/projects/{projectId}/delete", [ProjectController::class, "projectDelete"])->name("user.project.delete");
    Route::post("/projects/{projectId}/delete", [ProjectController::class, "projectDeletePost"]);
    Route::get("/projects/{projectId}/edit/models/add", [ProjectController::class, "projectModelAddList"])->name("user.project.model.add.list");
    Route::get("/projects/{projectId}/edit/models/{modelId}/add", [ProjectController::class, "projectModelAdd"])->name("user.project.model.add");
    Route::post("/projects/{projectId}/edit/models/{modelId}/add", [ProjectController::class, "projectModelAddPost"]);
    Route::get("/projects/{projectId}/edit/models/{modelId}/delete", [ProjectController::class, "projectModelDelete"])->name("user.project.model.delete");
    Route::post("/projects/{projectId}/edit/models/{modelId}/delete", [ProjectController::class, "projectModelDeletePost"]);

    Route::get("/manfs/my", [ManfController::class, "manfsMy"])->name("user.manf.my");
    Route::get("/manfs/create", [ManfController::class, "manfCreate"])->name("user.manf.create");
    Route::post("/manfs/create", [ManfController::class, "manfCreatePost"]);
    Route::get("/manfs/{manfId}/edit", [ManfController::class, "manfEdit"])->name("user.manf.edit");
    Route::post("/manfs/{manfId}/edit", [ManfController::class, "manfEditPost"]);

    Route::get("/services/{serviceId}/edit", [UserController::class, "serviceEdit"])->name("user.service.edit");
    Route::post("/services/{serviceId}/edit", [UserController::class, "serviceEditPost"]);
    Route::get("/services/{serviceId}/delete", [UserController::class, "serviceDelete"])->name("user.service.delete");
    Route::post("/services/{serviceId}/delete", [UserController::class, "serviceDeletePost"]);
});

Route::get("/models", [Model3DController::class, "models"])->name("model.list");
Route::get("/models/{modelId}", [Model3DController::class, "modelView"])->name("model.view");

Route::get("/projects", [ProjectController::class, "projects"])->name("project.list");
Route::get("/projects/{projectId}", [ProjectController::class, "projectView"])->name("project.view");

Route::get("/manfs", [ManfController::class, "manfs"])->name("manf.list");
Route::get("/manfs/{manfId}", [ManfController::class, "manfView"])->name("manf.view");
Route::post("/manfs/{manfId}", [ManfController::class, "manfViewPost"]);

Route::get("/services", [IndexController::class, "services"])->name("service.list");
Route::get("/services/{serviceId}", [IndexController::class, "serviceView"])->name("service.view");
Route::post("/services/{serviceId}", [IndexController::class, "serviceViewPost"]);
