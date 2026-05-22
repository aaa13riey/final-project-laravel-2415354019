<?php

use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CustomerController;


// Service Routes
Route::apiResource("services", ServiceController::class);

Route::patch("services/{service}/activate", [
    ServiceController::class,
    "activate",
]);

Route::patch("services/{service}/deactivate", [
    ServiceController::class,
    "deactivate",
]);

// Customer Routes
Route::apiResource("customers", CustomerController::class);

Route::patch("customers/{customer}/activate", [
    CustomerController::class,
    "activate",
]);

Route::patch("customers/{customer}/deactivate", [
    CustomerController::class,
    "deactivate",
]);