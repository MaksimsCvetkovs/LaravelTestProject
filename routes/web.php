<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;

Route::get("/", [IndexController::class, "index"])->name("index");
Route::get("/supplier", [IndexController::class, "suppliers"])->name("supplier.list");
Route::any("/supplier/create", [IndexController::class, "supplierCreate"])->name("supplier.create");
Route::any("/supplier/{supplierId}", [IndexController::class, "supplierView"])->name("supplier.view");
