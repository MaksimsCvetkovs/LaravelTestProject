<?php

use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::get("register", [RegisteredUserController::class, "create"])->name("register");
    Route::post("register", [RegisteredUserController::class, "store"]);

    Route::get("login", [AuthenticatedSessionController::class, "create"])->name("login");
    Route::post("login", [AuthenticatedSessionController::class, "store"]);
});

Route::any("logout", [AuthenticatedSessionController::class, "destroy"])->name("logout");