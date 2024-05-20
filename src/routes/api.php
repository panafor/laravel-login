<?php

use Illuminate\Support\Facades\Route;



Route::get("api/v1/user/info", [Usermp\LaravelLogin\app\Http\Controllers\Auth\InfoController::class,'info'])->name("user-info");
Route::post("api/v1/user/login/check", [Usermp\LaravelLogin\app\Http\Controllers\Auth\CheckController::class,'check'])->name("user-login-check");
Route::post("api/v1/user/login/credentials", [Usermp\LaravelLogin\app\Http\Controllers\Auth\CredentialsController::class,'credential'])->name("user-credential-check");
